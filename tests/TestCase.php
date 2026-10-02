<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->resetWithDump();
    }

    private function resetWithDump(): void
    {
        $c    = config('database.connections.' . config('database.default'));
        $pass = $c['password'] ? "-p{$c['password']}" : '';
        $conn = "-h{$c['host']} -P{$c['port']} -u{$c['username']} {$pass}";
        $db   = $c['database'];
        $dump = base_path('tests/db-dump.sql');

        exec("mysql {$conn} -e \"DROP DATABASE IF EXISTS \`{$db}\`; CREATE DATABASE \`{$db}\`;\" 2>/dev/null");
        exec("mysql {$conn} {$db} < {$dump} 2>/dev/null");
    }
}
