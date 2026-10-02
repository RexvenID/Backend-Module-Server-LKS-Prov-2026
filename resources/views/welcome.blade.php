<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LKS API Server</title>
    <style>
        :root {
            --bg: #fafafa;
            --surface: #ffffff;
            --border: #e5e5e5;
            --text-main: #111111;
            --text-muted: #666666;
            --code-bg: #f4f4f5;
            --code-text: #d22d2d;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: var(--bg);
            color: var(--text-main);
            padding: 40px;
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        h1 {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
            letter-spacing: -0.02em;
        }

        h2 {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-muted);
            margin: 0 0 12px 0;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .endpoint-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .row {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        label {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
        }

        code {
            background: var(--code-bg);
            color: var(--code-text);
            padding: 10px 14px;
            border-radius: 6px;
            font-size: 13.5px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            word-break: break-all;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .list-box {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 16px;
            max-height: 240px;
            overflow-y: auto;
        }

        ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        li {
            padding: 6px 0;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 13px;
            color: #333;
            border-bottom: 1px solid #f5f5f5;
        }

        li:last-child {
            border-bottom: none;
        }

        .example-box {
            margin-top: 8px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
    </style>
</head>
<body>
<div class="container">

    <section>
        <h1>Session 2 API Service</h1>
        <div class="endpoint-card">
            <div class="row">
                <label>Base API URL</label>
                <code>{{ url('/api') }}</code>
            </div>
            <div class="row">
                <label>Image Resource URL Pattern</label>
                <code>{{ url('/api/images/{destination}/{filename}') }}</code>
            </div>
        </div>
    </section>

    <section>
        <h1>Asset Parameter Dictionary</h1>
        <div class="grid">
            <div>
                <h2>Available Destinations ({destination})</h2>
                <div class="list-box">
                    <ul>
                        <li>bali</li>
                        <li>japan</li>
                        <li>kyoto</li>
                        <li>london</li>
                        <li>paris</li>
                        <li>seoul</li>
                        <li>swiss</li>
                        <li>sydney</li>
                        <li>tokyo</li>
                    </ul>
                </div>
            </div>

            <div>
                <h2>Valid Filenames ({filename})</h2>
                <div class="list-box">
                    <ul>
                        <li>activity_1_photo.jpeg</li>
                        <li>activity_2_photo.jpeg</li>
                        <li>chart_image.jpeg</li>
                        <li>cover_image.jpeg</li>
                        <li>day_photo.jpeg</li>
                        <li>hotel_image.jpeg</li>
                        <li>route_map.jpeg</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="example-box">
            <label>Request Example</label>
            <code>{{ url('/images/bali/activity_1_photo.jpeg') }}</code>
        </div>
    </section>

</div>
</body>
</html>
