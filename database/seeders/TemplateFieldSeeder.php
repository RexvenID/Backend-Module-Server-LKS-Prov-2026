<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateFieldSeeder extends Seeder
{
    public function run(): void
    {
        $ts = '2026-04-08 08:45:28';

        DB::table('template_fields')->insert([
            // Template 1: Trip Overview Block
            ['id' => 1,  'name' => 'destination',      'type' => 'text',  'template_id' => 1, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 2,  'name' => 'trip_dates',        'type' => 'text',  'template_id' => 1, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 3,  'name' => 'cover_image',       'type' => 'image', 'template_id' => 1, 'created_at' => $ts, 'updated_at' => $ts],
            // Template 2: Day Plan Block
            ['id' => 4,  'name' => 'day_title',         'type' => 'text',  'template_id' => 2, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 5,  'name' => 'day_description',   'type' => 'text',  'template_id' => 2, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 6,  'name' => 'day_photo',         'type' => 'image', 'template_id' => 2, 'created_at' => $ts, 'updated_at' => $ts],
            // Template 3: Activity List Block
            ['id' => 7,  'name' => 'title',             'type' => 'text',  'template_id' => 3, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 8,  'name' => 'activity_1_name',   'type' => 'text',  'template_id' => 3, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 9,  'name' => 'activity_1_photo',  'type' => 'image', 'template_id' => 3, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 10, 'name' => 'activity_2_name',   'type' => 'text',  'template_id' => 3, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 11, 'name' => 'activity_2_photo',  'type' => 'image', 'template_id' => 3, 'created_at' => $ts, 'updated_at' => $ts],
            // Template 4: Accommodation Block
            ['id' => 12, 'name' => 'hotel_name',        'type' => 'text',  'template_id' => 4, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 13, 'name' => 'address',           'type' => 'text',  'template_id' => 4, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 14, 'name' => 'check_in',          'type' => 'text',  'template_id' => 4, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 15, 'name' => 'hotel_image',       'type' => 'image', 'template_id' => 4, 'created_at' => $ts, 'updated_at' => $ts],
            // Template 5: Transport Block
            ['id' => 16, 'name' => 'mode',              'type' => 'text',  'template_id' => 5, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 17, 'name' => 'departure_time',    'type' => 'text',  'template_id' => 5, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 18, 'name' => 'route_map',         'type' => 'image', 'template_id' => 5, 'created_at' => $ts, 'updated_at' => $ts],
            // Template 6: Budget Summary Block
            ['id' => 19, 'name' => 'total_cost',        'type' => 'text',  'template_id' => 6, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 20, 'name' => 'chart_image',       'type' => 'image', 'template_id' => 6, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 21, 'name' => 'notes',             'type' => 'text',  'template_id' => 6, 'created_at' => $ts, 'updated_at' => $ts],
            ['id' => 22, 'name' => 'currency',          'type' => 'text',  'template_id' => 6, 'created_at' => $ts, 'updated_at' => $ts],
        ]);
    }
}
