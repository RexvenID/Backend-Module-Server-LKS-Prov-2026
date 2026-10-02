<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TemplateTest extends TestCase
{
    // ─── C1: Get All Templates ───────────────────────────────────────────────

    public function test_c1_get_all_templates_success(): void
    {
        Sanctum::actingAs(User::find(1));

        $response = $this->getJson('/api/templates');

        $response->assertStatus(200)
            ->assertJson([
                'status'  => 'success',
                'message' => 'Get all templates successful',
            ])
            ->assertJsonStructure([
                'data' => [
                    'templates' => [
                        '*' => [
                            'id', 'name', 'slug',
                            'fields' => [
                                '*' => ['id', 'template_id', 'name', 'slug', 'type'],
                            ],
                        ],
                    ],
                ],
            ]);

        $templates = $response->json('data.templates');
        $this->assertCount(6, $templates);
    }

    public function test_c1_get_all_templates_correct_overview_template(): void
    {
        Sanctum::actingAs(User::find(1));

        $response  = $this->getJson('/api/templates');
        $templates = $response->json('data.templates');
        $overview  = collect($templates)->firstWhere('slug', 'overview');

        $this->assertNotNull($overview);
        $this->assertEquals(1, $overview['id']);
        $this->assertEquals('Trip Overview Block', $overview['name']);
        $this->assertCount(3, $overview['fields']); // destination, trip_dates, cover_image
    }

    public function test_c1_get_all_templates_fields_have_correct_structure(): void
    {
        Sanctum::actingAs(User::find(1));

        $response  = $this->getJson('/api/templates');
        $templates = $response->json('data.templates');
        $overview  = collect($templates)->firstWhere('slug', 'overview');
        $fields    = $overview['fields'];

        // Each field must have required keys
        foreach ($fields as $field) {
            $this->assertArrayHasKey('id', $field);
            $this->assertArrayHasKey('template_id', $field);
            $this->assertArrayHasKey('name', $field);
            $this->assertArrayHasKey('slug', $field);
            $this->assertArrayHasKey('type', $field);
            $this->assertEquals(1, $field['template_id']);
            $this->assertContains($field['type'], ['text', 'image']);
        }
    }

    public function test_c1_get_all_templates_correct_template_count_per_template(): void
    {
        Sanctum::actingAs(User::find(1));

        $response  = $this->getJson('/api/templates');
        $templates = $response->json('data.templates');

        $expected = [
            'overview'      => 3, // destination, trip_dates, cover_image
            'day-plan'      => 3, // day_title, day_description, day_photo
            'activities'    => 5, // title, activity_1_name, activity_1_photo, activity_2_name, activity_2_photo
            'accommodation' => 4, // hotel_name, address, check_in, hotel_image
            'transport'     => 3, // mode, departure_time, route_map
            'budget'        => 4, // total_cost, chart_image, notes, currency
        ];

        foreach ($templates as $template) {
            $this->assertCount(
                $expected[$template['slug']],
                $template['fields'],
                "Template {$template['slug']} should have {$expected[$template['slug']]} fields"
            );
        }
    }

    public function test_c1_get_all_templates_fails_unauthenticated(): void
    {
        $this->getJson('/api/templates')
            ->assertStatus(401)
            ->assertJson(['status' => 'error', 'message' => 'Unauthenticated.']);
    }

    // ─── C2: Get Template by Slug ────────────────────────────────────────────

    public function test_c2_get_template_by_slug_success(): void
    {
        Sanctum::actingAs(User::find(1));

        $response = $this->getJson('/api/templates/overview');

        $response->assertStatus(200)
            ->assertJson([
                'status'  => 'success',
                'message' => 'Get template successful',
                'data'    => [
                    'id'   => 1,
                    'name' => 'Trip Overview Block',
                    'slug' => 'overview',
                ],
            ])
            ->assertJsonStructure([
                'data' => [
                    'id', 'name', 'slug',
                    'fields' => [
                        '*' => ['id', 'template_id', 'name', 'slug', 'type'],
                    ],
                ],
            ]);

        $this->assertCount(3, $response->json('data.fields'));
    }

    public function test_c2_get_template_budget_has_correct_fields(): void
    {
        Sanctum::actingAs(User::find(1));

        $response = $this->getJson('/api/templates/budget');

        $response->assertStatus(200)
            ->assertJson([
                'data' => ['slug' => 'budget'],
            ]);

        $this->assertCount(4, $response->json('data.fields')); // total_cost, chart_image, notes, currency
    }

    public function test_c2_get_template_not_found(): void
    {
        Sanctum::actingAs(User::find(1));

        $this->getJson('/api/templates/nonexistent')
            ->assertStatus(404)
            ->assertJson(['status' => 'error', 'message' => 'Not found']);
    }

    public function test_c2_get_template_fails_unauthenticated(): void
    {
        $this->getJson('/api/templates/overview')
            ->assertStatus(401)
            ->assertJson(['status' => 'error', 'message' => 'Unauthenticated.']);
    }
}
