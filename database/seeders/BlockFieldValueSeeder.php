<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlockFieldValueSeeder extends Seeder
{
    public function run(): void
    {
        $ts = '2026-04-08 08:45:30';

        DB::table('block_field_values')->insert([
            // Block 1: Trip Overview
            ['id' => 1,  'itinerary_block_id' => 1, 'template_field_id' => 1,  'value' => 'Kyoto & Tokyo, Japan',                          'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 2,  'itinerary_block_id' => 1, 'template_field_id' => 2,  'value' => 'April 10 - April 17, 2026',                     'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 3,  'itinerary_block_id' => 1, 'template_field_id' => 3,  'value' => url('api/images/japan/cover_image.jpeg'),                 'created_at' => $ts, 'updated_at' => $ts],
            // Block 2: Day Plan
            ['id' => 4,  'itinerary_block_id' => 2, 'template_field_id' => 4,  'value' => 'Day 1: Arrival & Temple Exploration',            'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 5,  'itinerary_block_id' => 2, 'template_field_id' => 5,  'value' => 'Arrive at Tokyo and check local historic temples.', 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 6,  'itinerary_block_id' => 2, 'template_field_id' => 6,  'value' => url('api/images/japan/day_photo.jpeg'),                   'created_at' => $ts, 'updated_at' => $ts],
            // Block 3: Activity List
            ['id' => 7,  'itinerary_block_id' => 3, 'template_field_id' => 7,  'value' => 'Top Activities of the Day',                     'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 8,  'itinerary_block_id' => 3, 'template_field_id' => 8,  'value' => 'Shibuya Crossing Walk',                         'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 9,  'itinerary_block_id' => 3, 'template_field_id' => 9,  'value' => url('api/images/japan/activity_1_photo.jpeg'),            'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 10, 'itinerary_block_id' => 3, 'template_field_id' => 10, 'value' => 'Traditional Ramen Tasting',                     'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 11, 'itinerary_block_id' => 3, 'template_field_id' => 11, 'value' => url('api/images/japan/activity_2_photo.jpeg'),            'created_at' => $ts, 'updated_at' => $ts],
            // Block 4: Accommodation
            ['id' => 12, 'itinerary_block_id' => 4, 'template_field_id' => 12, 'value' => 'Grand Hyatt Tokyo',                             'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 13, 'itinerary_block_id' => 4, 'template_field_id' => 13, 'value' => '6-10-3 Roppongi, Minato City, Tokyo',           'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 14, 'itinerary_block_id' => 4, 'template_field_id' => 14, 'value' => '15:00 PM',                                      'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 15, 'itinerary_block_id' => 4, 'template_field_id' => 15, 'value' => url('api/images/japan/hotel_image.jpeg'),                'created_at' => $ts, 'updated_at' => $ts],
            // Block 5: Transport
            ['id' => 16, 'itinerary_block_id' => 5, 'template_field_id' => 16, 'value' => 'Shinkansen Bullet Train',                       'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 17, 'itinerary_block_id' => 5, 'template_field_id' => 17, 'value' => '08:30 AM',                                      'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 18, 'itinerary_block_id' => 5, 'template_field_id' => 18, 'value' => url('api/images/japan/route_map.jpeg'),                  'created_at' => $ts, 'updated_at' => $ts],
            // Block 6: Budget Summary
            ['id' => 19, 'itinerary_block_id' => 6, 'template_field_id' => 19, 'value' => '150000',                                        'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 20, 'itinerary_block_id' => 6, 'template_field_id' => 20, 'value' => url('api/images/japan/chart_image.jpeg'),                'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 21, 'itinerary_block_id' => 6, 'template_field_id' => 21, 'value' => 'Includes all bullet train passes and resort bookings.', 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 22, 'itinerary_block_id' => 6, 'template_field_id' => 22, 'value' => 'JPY',                                           'created_at' => $ts, 'updated_at' => $ts],

            // Block 7: Bali - Trip Overview
            ['id' => 23, 'itinerary_block_id' => 7,  'template_field_id' => 1,  'value' => 'Bali, Indonesia',                                         'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 24, 'itinerary_block_id' => 7,  'template_field_id' => 2,  'value' => 'July 15 - July 22, 2026',                                 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 25, 'itinerary_block_id' => 7,  'template_field_id' => 3,  'value' => url('api/images/bali/cover_image.jpeg'),                           'created_at' => $ts, 'updated_at' => $ts],
            // Block 8: Bali - Day Plan
            ['id' => 26, 'itinerary_block_id' => 8,  'template_field_id' => 4,  'value' => 'Day 1: Arrival & Ubud Exploration',                       'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 27, 'itinerary_block_id' => 8,  'template_field_id' => 5,  'value' => 'Arrive in Bali and head to Ubud to explore rice terraces and ancient temples.', 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 28, 'itinerary_block_id' => 8,  'template_field_id' => 6,  'value' => url('api/images/bali/day_photo.jpeg'),                             'created_at' => $ts, 'updated_at' => $ts],
            // Block 9: Bali - Activity List
            ['id' => 29, 'itinerary_block_id' => 9,  'template_field_id' => 7,  'value' => 'Best Activities in Bali',                                 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 30, 'itinerary_block_id' => 9,  'template_field_id' => 8,  'value' => 'Tanah Lot Temple Visit',                                  'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 31, 'itinerary_block_id' => 9,  'template_field_id' => 9,  'value' => url('api/images/bali/activity_1_photo.jpeg'),                      'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 32, 'itinerary_block_id' => 9,  'template_field_id' => 10, 'value' => 'Tegalalang Rice Terrace Trek',                            'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 33, 'itinerary_block_id' => 9,  'template_field_id' => 11, 'value' => url('api/images/bali/activity_2_photo.jpeg'),                      'created_at' => $ts, 'updated_at' => $ts],
            // Block 10: Bali - Accommodation
            ['id' => 34, 'itinerary_block_id' => 10, 'template_field_id' => 12, 'value' => 'The Mulia Bali',                                          'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 35, 'itinerary_block_id' => 10, 'template_field_id' => 13, 'value' => 'Jl. Raya Nusa Dua Selatan, Sawangan, Nusa Dua, Bali',    'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 36, 'itinerary_block_id' => 10, 'template_field_id' => 14, 'value' => '14:00 PM',                                                'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 37, 'itinerary_block_id' => 10, 'template_field_id' => 15, 'value' => url('api/images/bali/hotel_image.jpeg'),                           'created_at' => $ts, 'updated_at' => $ts],
            // Block 11: Bali - Transport
            ['id' => 38, 'itinerary_block_id' => 11, 'template_field_id' => 16, 'value' => 'Private Shuttle Bus',                                     'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 39, 'itinerary_block_id' => 11, 'template_field_id' => 17, 'value' => '10:00 AM',                                                'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 40, 'itinerary_block_id' => 11, 'template_field_id' => 18, 'value' => url('api/images/bali/route_map.jpeg'),                             'created_at' => $ts, 'updated_at' => $ts],
            // Block 12: Bali - Budget Summary
            ['id' => 41, 'itinerary_block_id' => 12, 'template_field_id' => 19, 'value' => '12000000',                                                'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 42, 'itinerary_block_id' => 12, 'template_field_id' => 20, 'value' => url('api/images/bali/chart_image.jpeg'),                           'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 43, 'itinerary_block_id' => 12, 'template_field_id' => 21, 'value' => 'Includes all villa bookings and guided tours.',           'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 44, 'itinerary_block_id' => 12, 'template_field_id' => 22, 'value' => 'IDR',                                                     'created_at' => $ts, 'updated_at' => $ts],

            // Block 13: Paris - Trip Overview
            ['id' => 45, 'itinerary_block_id' => 13, 'template_field_id' => 1,  'value' => 'Paris, France',                                           'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 46, 'itinerary_block_id' => 13, 'template_field_id' => 2,  'value' => 'December 20 - December 27, 2026',                         'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 47, 'itinerary_block_id' => 13, 'template_field_id' => 3,  'value' => url('api/images/paris/cover_image.jpeg'),                          'created_at' => $ts, 'updated_at' => $ts],
            // Block 14: Paris - Day Plan
            ['id' => 48, 'itinerary_block_id' => 14, 'template_field_id' => 4,  'value' => 'Day 1: Arrival & Eiffel Tower',                           'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 49, 'itinerary_block_id' => 14, 'template_field_id' => 5,  'value' => 'Arrive in Paris and enjoy the iconic Eiffel Tower at night.', 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 50, 'itinerary_block_id' => 14, 'template_field_id' => 6,  'value' => url('api/images/paris/day_photo.jpeg'),                            'created_at' => $ts, 'updated_at' => $ts],
            // Block 15: Paris - Activity List
            ['id' => 51, 'itinerary_block_id' => 15, 'template_field_id' => 7,  'value' => 'Top Paris Activities',                                    'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 52, 'itinerary_block_id' => 15, 'template_field_id' => 8,  'value' => 'Louvre Museum Tour',                                      'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 53, 'itinerary_block_id' => 15, 'template_field_id' => 9,  'value' => url('api/images/paris/activity_1_photo.jpeg'),                     'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 54, 'itinerary_block_id' => 15, 'template_field_id' => 10, 'value' => 'Seine River Cruise',                                      'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 55, 'itinerary_block_id' => 15, 'template_field_id' => 11, 'value' => url('api/images/paris/activity_2_photo.jpeg'),                     'created_at' => $ts, 'updated_at' => $ts],
            // Block 16: Paris - Accommodation
            ['id' => 56, 'itinerary_block_id' => 16, 'template_field_id' => 12, 'value' => 'Le Meurice',                                              'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 57, 'itinerary_block_id' => 16, 'template_field_id' => 13, 'value' => '228 Rue de Rivoli, 75001 Paris, France',                  'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 58, 'itinerary_block_id' => 16, 'template_field_id' => 14, 'value' => '15:00 PM',                                                'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 59, 'itinerary_block_id' => 16, 'template_field_id' => 15, 'value' => url('api/images/paris/hotel_image.jpeg'),                          'created_at' => $ts, 'updated_at' => $ts],
            // Block 17: Paris - Transport
            ['id' => 60, 'itinerary_block_id' => 17, 'template_field_id' => 16, 'value' => 'Eurostar Train',                                          'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 61, 'itinerary_block_id' => 17, 'template_field_id' => 17, 'value' => '09:00 AM',                                                'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 62, 'itinerary_block_id' => 17, 'template_field_id' => 18, 'value' => url('api/images/paris/route_map.jpeg'),                            'created_at' => $ts, 'updated_at' => $ts],
            // Block 18: Paris - Budget Summary
            ['id' => 63, 'itinerary_block_id' => 18, 'template_field_id' => 19, 'value' => '5000',                                                    'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 64, 'itinerary_block_id' => 18, 'template_field_id' => 20, 'value' => url('api/images/paris/chart_image.jpeg'),                          'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 65, 'itinerary_block_id' => 18, 'template_field_id' => 21, 'value' => 'Includes museum passes and guided city tour.',             'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 66, 'itinerary_block_id' => 18, 'template_field_id' => 22, 'value' => 'EUR',                                                     'created_at' => $ts, 'updated_at' => $ts],
        ]);
    }
}
