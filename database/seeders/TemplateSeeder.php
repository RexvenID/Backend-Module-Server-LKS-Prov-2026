<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('templates')->insert([
            ['id' => 1, 'name' => 'Trip Overview Block', 'slug' => 'overview', 'created_at' => '2026-04-08 08:45:28', 'updated_at' => '2026-04-08 08:45:28'],
            ['id' => 2, 'name' => 'Day Plan Block', 'slug' => 'day-plan', 'created_at' => '2026-04-08 08:45:28', 'updated_at' => '2026-04-08 08:45:28'],
            ['id' => 3, 'name' => 'Activity List Block', 'slug' => 'activities', 'created_at' => '2026-04-08 08:45:28', 'updated_at' => '2026-04-08 08:45:28'],
            ['id' => 4, 'name' => 'Accommodation Block', 'slug' => 'accommodation', 'created_at' => '2026-04-08 08:45:28', 'updated_at' => '2026-04-08 08:45:28'],
            ['id' => 5, 'name' => 'Transport Block', 'slug' => 'transport', 'created_at' => '2026-04-08 08:45:28', 'updated_at' => '2026-04-08 08:45:28'],
            ['id' => 6, 'name' => 'Budget Summary Block', 'slug' => 'budget', 'created_at' => '2026-04-08 08:45:28', 'updated_at' => '2026-04-08 08:45:28'],
        ]);
    }
}
