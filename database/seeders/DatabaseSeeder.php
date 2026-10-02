<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TemplateSeeder::class,
            TemplateFieldSeeder::class,
            ItinerarySeeder::class,
            ItineraryBlockSeeder::class,
            BlockFieldValueSeeder::class,
        ]);
    }
}
