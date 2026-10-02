<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john.doe@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => '2026-04-08 08:45:27',
                'updated_at' => '2026-04-08 08:45:27',
            ],
            [
                'id' => 2,
                'name' => 'Richard Roe',
                'email' => 'richard.roe@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => '2026-04-08 08:45:27',
                'updated_at' => '2026-04-08 08:45:27',
            ],
            [
                'id' => 3,
                'name' => 'Jane Poe',
                'email' => 'jane.poe@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => '2026-04-08 08:45:28',
                'updated_at' => '2026-04-08 08:45:28',
            ],
        ]);
    }
}
