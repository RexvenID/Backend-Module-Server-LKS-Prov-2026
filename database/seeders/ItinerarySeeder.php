<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItinerarySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('itineraries')->insert([
            [
                'id' => 1,
                'title' => 'Japan Summer Trip',
                'summary' => 'A beautiful summer journey through Tokyo and Kyoto.',
                'slug' => 'japan-summer-trip',
                'user_id' => 1,
                'created_at' => '2026-04-08 08:45:28',
                'updated_at' => '2026-04-08 08:45:28',
            ],
            [
                'id' => 2,
                'title' => 'Bali Summer Escape',
                'summary' => 'A relaxing summer retreat through Ubud and Nusa Dua.',
                'slug' => 'bali-summer-escape',
                'user_id' => 2,
                'created_at' => '2026-04-08 08:45:28',
                'updated_at' => '2026-04-08 08:45:28',
            ],
            [
                'id' => 3,
                'title' => 'Paris Winter Getaway',
                'summary' => 'A romantic winter trip to the City of Light.',
                'slug' => 'paris-winter-getaway',
                'user_id' => 3,
                'created_at' => '2026-04-08 08:45:28',
                'updated_at' => '2026-04-08 08:45:28',
            ],
        ]);
    }
}
