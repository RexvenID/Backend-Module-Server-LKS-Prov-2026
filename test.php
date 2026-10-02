<?php
// ─── Config ───────────────────────────────────────────────────────────────────
define('DATA_FILE', __DIR__ . '/tracker_data.json');
define('QUOTA_SECONDS', 15 * 60); // 15 menit per peserta

// ─── Data helpers ─────────────────────────────────────────────────────────────
function loadData(): array {
    if (!file_exists(DATA_FILE)) {
        return ['participants' => [], 'active_id' => null, 'session_start' => null];
    }
    return json_decode(file_get_contents(DATA_FILE), true)
        ?? ['participants' => [], 'active_id' => null, 'session_start' => null];
}

function saveData(array $data): void {
    file_put_contents(DATA_FILE, json_encode($data, JSON_PRETTY_PRINT));
}

// Hitung sisa detik peserta aktif (real-time)
function remainingSeconds(array $p, ?int $session_start): int {
    $used = $p['used_seconds'];
    if ($session_start !== null) {
        $used += (time() - $session_start);
    }
    return max(0, QUOTA_SECONDS - $used);
}

// ─── Action handler ───────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $data   = loadData();

    switch ($action) {

        case 'add_participant':
            $name = trim($_POST['name'] ?? '');
            if ($name !== '') {
                $data['participants'][] = [
                    'id'           => uniqid(),
                    'name'         => $name,
                    'used_seconds' => 0,
                    'added'        => time(),
                    'exhausted'    => false,
                ];
                saveData($data);
            }
            break;

        case 'start':
            // Mulai sesi untuk peserta tertentu
            // Kalau ada yg lagi aktif, commit dulu waktu yang terpakai
            $id = $_POST['id'] ?? '';
            $target = null;
            foreach ($data['participants'] as $p) {
                if ($p['id'] === $id) { $target = $p; break; }
            }
            if (!$target || $target['exhausted']) break;

            // commit sesi sebelumnya kalau ada
            if ($data['active_id'] && $data['session_start']) {
                foreach ($data['participants'] as &$p) {
                    if ($p['id'] === $data['active_id']) {
                        $p['used_seconds'] += time() - $data['session_start'];
                        if ($p['used_seconds'] >= QUOTA_SECONDS) {
                            $p['used_seconds'] = QUOTA_SECONDS;
                            $p['exhausted']    = true;
                        }
                        break;
                    }
                }
                unset($p);
            }

            $data['active_id']    = $id;
            $data['session_start'] = time();
            saveData($data);
            break;

        case 'stop':
            // Stop sesi aktif, commit waktu
            if ($data['active_id'] && $data['session_start']) {
                foreach ($data['participants'] as &$p) {
                    if ($p['id'] === $data['active_id']) {
                        $p['used_seconds'] += time() - $data['session_start'];
                        if ($p['used_seconds'] >= QUOTA_SECONDS) {
                            $p['used_seconds'] = QUOTA_SECONDS;
                            $p['exhausted']    = true;
                        }
                        break;
                    }
                }
                unset($p);
            }
            $data['active_id']    = null;
            $data['session_start'] = null;
            saveData($data);
            break;

        case 'reset_participant':
            $id = $_POST['id'] ?? '';
            foreach ($data['participants'] as &$p) {
                if ($p['id'] === $id) {
                    // jangan reset yg lagi aktif
                    if ($data['active_id'] === $id) break;
                    $p['used_seconds'] = 0;
                    $p['exhausted']    = false;
                    break;
                }
            }
            unset($p);
            saveData($data);
            break;

        case 'remove':
            $id = $_POST['id'] ?? '';
            if ($id === $data['active_id']) {
                // stop dulu
                if ($data['session_start']) {
                    foreach ($data['participants'] as &$p) {
                        if ($p['id'] === $id) {
                            $p['used_seconds'] += time() - $data['session_start'];
                            break;
                        }
                    }
                    unset($p);
                }
                $data['active_id']    = null;
                $data['session_start'] = null;
            }
            $data['participants'] = array_values(
                array_filter($data['participants'], fn($p) => $p['id'] !== $id)
            );
            saveData($data);
            break;
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// ─── Prepare display data ─────────────────────────────────────────────────────
$data = loadData();

// Cek apakah peserta aktif sudah habis waktu secara real-time
// kalau iya, auto-stop (commit)
if ($data['active_id'] && $data['session_start']) {
    foreach ($data['participants'] as $p) {
        if ($p['id'] === $data['active_id']) {
            $liveUsed = $p['used_seconds'] + (time() - $data['session_start']);
            if ($liveUsed >= QUOTA_SECONDS) {
                // auto-commit
                foreach ($data['participants'] as &$pp) {
                    if ($pp['id'] === $data['active_id']) {
                        $pp['used_seconds'] = QUOTA_SECONDS;
                        $pp['exhausted']    = true;
                        break;
                    }
                }
                unset($pp);
                $data['active_id']    = null;
                $data['session_start'] = null;
                saveData($data);
            }
            break;
        }
    }
}

// Pisah peserta berdasar state
$active_p   = null;
$available  = []; // masih punya sisa waktu, tidak aktif
$exhausted  = []; // habis waktu

foreach ($data['participants'] as $p) {
    $rem = remainingSeconds($p, ($p['id'] === $data['active_id']) ? $data['session_start'] : null);
    $p['_remaining'] = $rem;
    $p['_pct']       = round(($rem / QUOTA_SECONDS) * 100, 1);

    if ($p['id'] === $data['active_id']) {
        $active_p = $p;
    } elseif ($p['exhausted'] || $rem === 0) {
        $exhausted[] = $p;
    } else {
        $available[] = $p;
    }
}

// SVG arc helper
function arcPath(float $pct, float $r = 54): string {
    $circ = 2 * M_PI * $r;
    $offset = $circ * (1 - ($pct / 100));
    return sprintf('stroke-dasharray="%.2f" stroke-dashoffset="%.2f"', $circ, max(0, $offset));
}

$autoRefresh = $data['active_id'] ? '<meta http-equiv="refresh" content="1">' : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $autoRefresh ?>
    <title>PC Time Tracker</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:       #FFFFFF;
            --surface:  #F8FAFC;
            --border:   #E2E8F0;
            --muted:    #94A3B8;
            --text:     #0F172A;
            --sub:      #475569;
            --blue:     #3B82F6;
            --blue-lt:  #EFF6FF;
            --green:    #10B981;
            --green-lt: #ECFDF5;
            --amber:    #F59E0B;
            --amber-lt: #FFFBEB;
            --red:      #EF4444;
            --red-lt:   #FEF2F2;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 32px;
            border-bottom: 1px solid var(--border);
        }

        header h1 { font-size: 15px; font-weight: 600; letter-spacing: -0.01em; }
        header span { font-size: 12px; color: var(--muted); }

        main {
            flex: 1;
            display: grid;
            grid-template-columns: 360px 1fr;
        }

        /* ─── Left: active session ─── */
        .panel-left {
            border-right: 1px solid var(--border);
            padding: 36px 32px;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        .panel-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
        }

        /* Arc timer */
        .arc-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }

        .arc-outer {
            position: relative;
            width: 148px;
            height: 148px;
        }

        .arc-outer svg { transform: rotate(-90deg); }

        .arc-bg   { fill: none; stroke: var(--border); stroke-width: 6; }
        .arc-fg   { fill: none; stroke-width: 6; stroke-linecap: round; }

        .arc-fg.c-green  { stroke: var(--green); }
        .arc-fg.c-amber  { stroke: var(--amber); }
        .arc-fg.c-red    { stroke: var(--red); }
        .arc-fg.c-border { stroke: var(--border); }

        .arc-center {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 2px;
        }

        .arc-digits {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            font-size: 30px;
            letter-spacing: -0.02em;
            line-height: 1;
        }

        .arc-digits.c-green { color: var(--green); }
        .arc-digits.c-amber { color: var(--amber); }
        .arc-digits.c-red   { color: var(--red); }
        .arc-digits.c-muted { color: var(--muted); }

        .arc-sublabel {
            font-size: 10px;
            color: var(--muted);
            font-weight: 500;
            letter-spacing: 0.04em;
        }

        .active-name {
            font-size: 17px;
            font-weight: 600;
            text-align: center;
            letter-spacing: -0.02em;
        }

        .active-name.empty {
            font-size: 13px;
            font-weight: 400;
            color: var(--muted);
        }

        /* pulse */
        @keyframes pulse {
            0%, 100% { opacity: 0.5; transform: scale(1); }
            50%       { opacity: 0.2; transform: scale(1.05); }
        }
        .pulse-ring {
            position: absolute;
            inset: -7px;
            border-radius: 50%;
            border: 2px solid var(--green);
            animation: pulse 2s ease-in-out infinite;
            pointer-events: none;
        }

        /* session used bar */
        .used-bar-wrap {
            width: 100%;
        }

        .used-bar-label {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: var(--muted);
            margin-bottom: 5px;
        }

        .used-bar-track {
            height: 4px;
            background: var(--border);
            border-radius: 99px;
            overflow: hidden;
        }

        .used-bar-fill {
            height: 100%;
            border-radius: 99px;
            transition: width 0.3s;
        }

        .fill-green { background: var(--green); }
        .fill-amber { background: var(--amber); }
        .fill-red   { background: var(--red); }

        /* controls */
        .controls { display: flex; flex-direction: column; gap: 8px; }

        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            border: none;
            cursor: pointer;
            width: 100%;
            transition: opacity 0.15s, transform 0.1s;
            letter-spacing: -0.01em;
        }

        .btn:active { transform: scale(0.98); }
        .btn:disabled { opacity: 0.3; cursor: not-allowed; }
        .btn-red    { background: var(--red);    color: #fff; }
        .btn-ghost  { background: var(--surface); color: var(--sub); border: 1px solid var(--border); }
        .btn-ghost:hover:not(:disabled) { background: var(--border); }

        /* ─── Right: participants ─── */
        .panel-right {
            padding: 36px 32px;
            display: flex;
            flex-direction: column;
            gap: 24px;
            overflow-y: auto;
        }

        .add-row {
            display: flex;
            gap: 8px;
        }

        .inp {
            flex: 1;
            padding: 9px 13px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            color: var(--text);
            outline: none;
            transition: border-color 0.15s;
        }

        .inp:focus { border-color: var(--blue); }
        .inp::placeholder { color: var(--muted); }

        .btn-add {
            padding: 9px 18px;
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-add:hover { opacity: 0.85; }

        /* section */
        .section { display: flex; flex-direction: column; gap: 8px; }

        .sec-title {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .chip {
            background: var(--border);
            color: var(--sub);
            font-size: 10px;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 99px;
        }

        /* participant card */
        .plist { display: flex; flex-direction: column; gap: 5px; }

        .pcard {
            display: flex;
            align-items: center;
            padding: 11px 14px;
            border-radius: 8px;
            border: 1px solid var(--border);
            gap: 12px;
            transition: border-color 0.15s;
        }

        .pcard:hover { border-color: #CBD5E1; }

        .pcard.is-active {
            border-color: var(--green);
            background: var(--green-lt);
        }

        .pcard.is-exhausted {
            opacity: 0.45;
        }

        /* mini arc */
        .mini-arc {
            position: relative;
            width: 36px;
            height: 36px;
            flex-shrink: 0;
        }

        .mini-arc svg { transform: rotate(-90deg); }
        .mini-arc .m-bg { fill: none; stroke: var(--border); stroke-width: 4; }
        .mini-arc .m-fg { fill: none; stroke-width: 4; stroke-linecap: round; }
        .mini-arc .m-fg.c-green { stroke: var(--green); }
        .mini-arc .m-fg.c-amber { stroke: var(--amber); }
        .mini-arc .m-fg.c-red   { stroke: var(--red); }
        .mini-arc .m-fg.c-border { stroke: var(--border); }

        .mini-center {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mini-pct {
            font-size: 8px;
            font-weight: 700;
            color: var(--sub);
            line-height: 1;
        }

        .pinfo { flex: 1; min-width: 0; }

        .pname {
            font-size: 14px;
            font-weight: 500;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ptime {
            font-size: 11px;
            color: var(--muted);
            margin-top: 2px;
        }

        .ptime .tval {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            font-size: 11px;
        }

        .ptime .tval.c-green { color: var(--green); }
        .ptime .tval.c-amber { color: var(--amber); }
        .ptime .tval.c-red   { color: var(--red); }
        .ptime .tval.c-muted { color: var(--muted); }

        .pactions { display: flex; gap: 5px; align-items: center; }

        .btn-xs {
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            transition: opacity 0.15s;
        }

        .btn-xs:hover { opacity: 0.8; }
        .btn-xs-start  { background: var(--green-lt);  color: var(--green); }
        .btn-xs-stop   { background: var(--red-lt);    color: var(--red); }
        .btn-xs-reset  { background: var(--blue-lt);   color: var(--blue); }
        .btn-xs-remove { background: var(--surface);   color: var(--muted); border: 1px solid var(--border); }

        .empty-state {
            padding: 20px;
            text-align: center;
            color: var(--muted);
            font-size: 13px;
            border: 1px dashed var(--border);
            border-radius: 8px;
        }

        @media (max-width: 780px) {
            main { grid-template-columns: 1fr; }
            .panel-left { border-right: none; border-bottom: 1px solid var(--border); }
        }
    </style>
</head>
<body>

<header>
    <h1>PC Time Tracker</h1>
    <span>Kuota <?= QUOTA_SECONDS / 60 ?> menit per peserta &mdash; bisa dipakai bertahap</span>
</header>

<main>

    <!-- ─── Left panel: active ──────────────────────────────── -->
    <div class="panel-left">
        <div class="panel-label">Sedang Menggunakan PC</div>

        <?php
        $rem  = $active_p ? $active_p['_remaining'] : QUOTA_SECONDS;
        $pct  = $active_p ? $active_p['_pct'] : 100;
        $used = $active_p ? $active_p['used_seconds'] + (time() - $data['session_start']) : 0;
        $used = min($used, QUOTA_SECONDS);

        $arcColor = 'c-border';
        if ($active_p) {
            $arcColor = $pct > 30 ? 'c-green' : ($pct > 10 ? 'c-amber' : 'c-red');
        }

        $dispMin = floor($rem / 60);
        $dispSec = $rem % 60;
        ?>

        <div class="arc-wrap">
            <div class="arc-outer">
                <?php if ($active_p): ?>
                    <div class="pulse-ring"></div>
                <?php endif; ?>
                <svg width="148" height="148" viewBox="0 0 120 120">
                    <circle class="arc-bg" cx="60" cy="60" r="54"/>
                    <circle class="arc-fg <?= $arcColor ?>" cx="60" cy="60" r="54"
                        <?= arcPath($pct) ?>
                    />
                </svg>
                <div class="arc-center">
                    <span class="arc-digits <?= $active_p ? $arcColor : 'c-muted' ?>">
                        <?= sprintf('%02d:%02d', $dispMin, $dispSec) ?>
                    </span>
                    <span class="arc-sublabel">sisa waktu</span>
                </div>
            </div>

            <div class="<?= $active_p ? 'active-name' : 'active-name empty' ?>">
                <?= $active_p ? htmlspecialchars($active_p['name']) : 'Tidak ada sesi aktif' ?>
            </div>
        </div>

        <?php if ($active_p): ?>
            <div class="used-bar-wrap">
                <div class="used-bar-label">
                    <span>Terpakai sesi ini</span>
                    <span><?= gmdate('i:s', $used) ?> / <?= gmdate('i:s', QUOTA_SECONDS) ?></span>
                </div>
                <div class="used-bar-track">
                    <div class="used-bar-fill <?= $arcColor === 'c-green' ? 'fill-green' : ($arcColor === 'c-amber' ? 'fill-amber' : 'fill-red') ?>"
                         style="width: <?= round(($used / QUOTA_SECONDS) * 100, 1) ?>%">
                    </div>
                </div>
            </div>

            <div class="controls">
                <form method="POST">
                    <input type="hidden" name="action" value="stop">
                    <button type="submit" class="btn btn-red">⏹ Stop &amp; Simpan Waktu</button>
                </form>
            </div>
        <?php else: ?>
            <div class="controls">
                <button class="btn btn-ghost" disabled>Pilih peserta dari daftar</button>
            </div>
        <?php endif; ?>

    </div>

    <!-- ─── Right panel: participants ───────────────────────── -->
    <div class="panel-right">

        <!-- Add form -->
        <form method="POST" class="add-row">
            <input type="hidden" name="action" value="add_participant">
            <input type="text" name="name" class="inp" placeholder="Nama peserta..." autocomplete="off" required>
            <button type="submit" class="btn-add">+ Tambah</button>
        </form>

        <!-- Available participants -->
        <div class="section">
            <div class="sec-title">
                Peserta
                <span class="chip"><?= count($available) + ($active_p ? 1 : 0) ?></span>
            </div>
            <div class="plist">
                <?php
                // active first
                if ($active_p): ?>
                    <div class="pcard is-active">
                        <?php
                        $ac = $active_p['_pct'];
                        $acColor = $ac > 30 ? 'c-green' : ($ac > 10 ? 'c-amber' : 'c-red');
                        $miniCirc = 2 * M_PI * 13;
                        $miniOff  = $miniCirc * (1 - ($ac / 100));
                        ?>
                        <div class="mini-arc">
                            <svg width="36" height="36" viewBox="0 0 30 30">
                                <circle class="m-bg" cx="15" cy="15" r="13"/>
                                <circle class="m-fg <?= $acColor ?>" cx="15" cy="15" r="13"
                                        stroke-dasharray="<?= round($miniCirc,2) ?>"
                                        stroke-dashoffset="<?= round(max(0,$miniOff),2) ?>"/>
                            </svg>
                            <div class="mini-center">
                                <span class="mini-pct"><?= round($ac) ?>%</span>
                            </div>
                        </div>
                        <div class="pinfo">
                            <div class="pname"><?= htmlspecialchars($active_p['name']) ?></div>
                            <div class="ptime">
                                Sisa <span class="tval <?= $acColor ?>"><?= sprintf('%02d:%02d', floor($active_p['_remaining']/60), $active_p['_remaining']%60) ?></span>
                                &bull; Aktif sekarang
                            </div>
                        </div>
                        <div class="pactions">
                            <form method="POST">
                                <input type="hidden" name="action" value="stop">
                                <button type="submit" class="btn-xs btn-xs-stop">⏹ Stop</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (empty($available) && !$active_p): ?>
                    <div class="empty-state">Belum ada peserta. Tambahkan di atas.</div>
                <?php endif; ?>

                <?php foreach ($available as $p):
                    $pct   = $p['_pct'];
                    $color = $pct > 30 ? 'c-green' : ($pct > 10 ? 'c-amber' : 'c-red');
                    $miniCirc = 2 * M_PI * 13;
                    $miniOff  = $miniCirc * (1 - ($pct / 100));
                    ?>
                    <div class="pcard">
                        <div class="mini-arc">
                            <svg width="36" height="36" viewBox="0 0 30 30">
                                <circle class="m-bg" cx="15" cy="15" r="13"/>
                                <circle class="m-fg <?= $color ?>" cx="15" cy="15" r="13"
                                        stroke-dasharray="<?= round($miniCirc,2) ?>"
                                        stroke-dashoffset="<?= round(max(0,$miniOff),2) ?>"/>
                            </svg>
                            <div class="mini-center">
                                <span class="mini-pct"><?= round($pct) ?>%</span>
                            </div>
                        </div>
                        <div class="pinfo">
                            <div class="pname"><?= htmlspecialchars($p['name']) ?></div>
                            <div class="ptime">
                                Sisa <span class="tval <?= $color ?>"><?= sprintf('%02d:%02d', floor($p['_remaining']/60), $p['_remaining']%60) ?></span>
                            </div>
                        </div>
                        <div class="pactions">
                            <?php if (!$data['active_id']): ?>
                                <form method="POST">
                                    <input type="hidden" name="action" value="start">
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                    <button type="submit" class="btn-xs btn-xs-start">▶ Mulai</button>
                                </form>
                            <?php endif; ?>
                            <form method="POST">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <button type="submit" class="btn-xs btn-xs-remove"
                                        onclick="return confirm('Hapus <?= htmlspecialchars($p['name']) ?>?')">✕</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Exhausted participants -->
        <?php if (!empty($exhausted)): ?>
            <div class="section">
                <div class="sec-title">
                    Kuota Habis
                    <span class="chip"><?= count($exhausted) ?></span>
                </div>
                <div class="plist">
                    <?php foreach ($exhausted as $p): ?>
                        <div class="pcard is-exhausted">
                            <div class="mini-arc">
                                <svg width="36" height="36" viewBox="0 0 30 30">
                                    <circle class="m-bg" cx="15" cy="15" r="13"/>
                                    <circle class="m-fg c-border" cx="15" cy="15" r="13"
                                            stroke-dasharray="<?= round(2*M_PI*13,2) ?>"
                                            stroke-dashoffset="<?= round(2*M_PI*13,2) ?>"/>
                                </svg>
                                <div class="mini-center">
                                    <span class="mini-pct">0%</span>
                                </div>
                            </div>
                            <div class="pinfo">
                                <div class="pname"><?= htmlspecialchars($p['name']) ?></div>
                                <div class="ptime">Kuota <?= QUOTA_SECONDS/60 ?> menit habis</div>
                            </div>
                            <div class="pactions">
                                <form method="POST">
                                    <input type="hidden" name="action" value="reset_participant">
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                    <button type="submit" class="btn-xs btn-xs-reset">↺ Reset</button>
                                </form>
                                <form method="POST">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                    <button type="submit" class="btn-xs btn-xs-remove"
                                            onclick="return confirm('Hapus?')">✕</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</main>

</body>
</html>
