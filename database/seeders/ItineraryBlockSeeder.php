<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItineraryBlockSeeder extends Seeder
{
    public function run(): void
    {
        $ts = '2026-04-08 08:45:29';

        DB::table('itinerary_blocks')->insert([
            // Itinerary 1: Japan Spring Trip
            ['id' => 1,  'itinerary_id' => 1, 'template_id' => 1, 'position' => 1, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 2,  'itinerary_id' => 1, 'template_id' => 2, 'position' => 2, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 3,  'itinerary_id' => 1, 'template_id' => 3, 'position' => 3, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 4,  'itinerary_id' => 1, 'template_id' => 4, 'position' => 4, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 5,  'itinerary_id' => 1, 'template_id' => 5, 'position' => 5, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 6,  'itinerary_id' => 1, 'template_id' => 6, 'position' => 6, 'created_at' => $ts, 'updated_at' => $ts],
            // Itinerary 2: Bali Summer Escape
            ['id' => 7,  'itinerary_id' => 2, 'template_id' => 1, 'position' => 1, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 8,  'itinerary_id' => 2, 'template_id' => 2, 'position' => 2, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 9,  'itinerary_id' => 2, 'template_id' => 3, 'position' => 3, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 10, 'itinerary_id' => 2, 'template_id' => 4, 'position' => 4, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 11, 'itinerary_id' => 2, 'template_id' => 5, 'position' => 5, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 12, 'itinerary_id' => 2, 'template_id' => 6, 'position' => 6, 'created_at' => $ts, 'updated_at' => $ts],
            // Itinerary 3: Paris Winter Getaway
            ['id' => 13, 'itinerary_id' => 3, 'template_id' => 1, 'position' => 1, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 14, 'itinerary_id' => 3, 'template_id' => 2, 'position' => 2, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 15, 'itinerary_id' => 3, 'template_id' => 3, 'position' => 3, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 16, 'itinerary_id' => 3, 'template_id' => 4, 'position' => 4, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 17, 'itinerary_id' => 3, 'template_id' => 5, 'position' => 5, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 18, 'itinerary_id' => 3, 'template_id' => 6, 'position' => 6, 'created_at' => $ts, 'updated_at' => $ts],
        ]);
    }
}
