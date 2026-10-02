<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BlockTest extends TestCase
{
    // ─── D1: Add Block to Itinerary ──────────────────────────────────────────

    public function test_d1_add_block_success(): void
    {
        Sanctum::actingAs(User::find(1));

        $response = $this->postJson('/api/itineraries/japan-summer-trip/blocks', [
            'template_id' => 1,
            'position'    => 7,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'status'  => 'success',
                'message' => 'Block added successful',
                'data'    => [
                    'itinerary_id' => 1,
                    'template_id'  => 1,
                    'position'     => 7,
                    'template'     => [
                        'id'   => 1,
                        'name' => 'Trip Overview Block',
                        'slug' => 'overview',
                    ],
                ],
            ])
            ->assertJsonStructure([
                'data' => [
                    'id', 'itinerary_id', 'template_id', 'position',
                    'template' => ['id', 'name', 'slug'],
                    'fields'   => [
                        '*' => ['id', 'name', 'slug', 'type', 'value'],
                    ],
                    'created_at', 'updated_at',
                ],
            ]);

        // All 3 template fields of template 1 must appear with value: null
        $fields = $response->json('data.fields');
        $this->assertCount(3, $fields);
        foreach ($fields as $field) {
            $this->assertNull($field['value']);
        }
    }

    public function test_d1_add_block_fields_match_template(): void
    {
        Sanctum::actingAs(User::find(1));

        // Template 3 (activities) has 5 fields
        $response = $this->postJson('/api/itineraries/japan-summer-trip/blocks', [
            'template_id' => 3,
            'position'    => 7,
        ]);

        $response->assertStatus(201);
        $this->assertCount(5, $response->json('data.fields'));
    }

    public function test_d1_add_block_forbidden(): void
    {
        Sanctum::actingAs(User::find(2)); // not owner of japan-summer-trip

        $this->postJson('/api/itineraries/japan-summer-trip/blocks', [
            'template_id' => 1,
            'position'    => 1,
        ])
            ->assertStatus(403)
            ->assertJson(['status' => 'error', 'message' => 'Forbidden access']);
    }

    public function test_d1_add_block_itinerary_not_found(): void
    {
        Sanctum::actingAs(User::find(1));

        $this->postJson('/api/itineraries/nonexistent-itinerary/blocks', [
            'template_id' => 1,
            'position'    => 1,
        ])
            ->assertStatus(404)
            ->assertJson(['status' => 'error', 'message' => 'Not found']);
    }

    public function test_d1_add_block_invalid_template_id(): void
    {
        Sanctum::actingAs(User::find(1));

        $this->postJson('/api/itineraries/japan-summer-trip/blocks', [
            'template_id' => 999,
            'position'    => 1,
        ])
            ->assertStatus(422)
            ->assertJson(['status' => 'error', 'message' => 'Invalid field'])
            ->assertJsonStructure(['errors' => ['template_id']]);
    }

    public function test_d1_add_block_missing_position(): void
    {
        Sanctum::actingAs(User::find(1));

        $this->postJson('/api/itineraries/japan-summer-trip/blocks', [
            'template_id' => 1,
        ])
            ->assertStatus(422)
            ->assertJson(['status' => 'error', 'message' => 'Invalid field'])
            ->assertJsonStructure(['errors' => ['position']]);
    }

    public function test_d1_add_block_fails_unauthenticated(): void
    {
        $this->postJson('/api/itineraries/japan-summer-trip/blocks', [
            'template_id' => 1,
            'position'    => 1,
        ])
            ->assertStatus(401)
            ->assertJson(['status' => 'error', 'message' => 'Unauthenticated.']);
    }

    // ─── D2: Update Block Field Values ───────────────────────────────────────

    public function test_d2_update_block_fields_success(): void
    {
        Sanctum::actingAs(User::find(1));

        // Block 1: itinerary 1, template 1 (overview) — fields: 1,2,3
        $response = $this->putJson('/api/itineraries/japan-summer-trip/blocks/1/fields', [
            'fields' => [
                ['field_id' => 1, 'value' => 'Tokyo, Japan'],
                ['field_id' => 2, 'value' => 'July 1 - July 10, 2026'],
            ],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status'  => 'success',
                'message' => 'Block fields updated successful',
                'data'    => [
                    'id'           => 1,
                    'itinerary_id' => 1,
                    'template_id'  => 1,
                ],
            ])
            ->assertJsonStructure([
                'data' => [
                    'id', 'itinerary_id', 'template_id', 'position',
                    'fields' => [
                        '*' => ['id', 'name', 'slug', 'type', 'value'],
                    ],
                ],
            ]);

        // Verify updated value persisted
        $fields = $response->json('data.fields');
        $destination = collect($fields)->firstWhere('value', 'Tokyo, Japan');
        $this->assertNotNull($destination);
    }

    public function test_d2_update_block_fields_forbidden(): void
    {
        Sanctum::actingAs(User::find(2)); // not owner

        $this->putJson('/api/itineraries/japan-summer-trip/blocks/1/fields', [
            'fields' => [['field_id' => 1, 'value' => 'Hacked']],
        ])
            ->assertStatus(403)
            ->assertJson(['status' => 'error', 'message' => 'Forbidden access']);
    }

    public function test_d2_update_block_fields_block_not_found(): void
    {
        Sanctum::actingAs(User::find(1));

        $this->putJson('/api/itineraries/japan-summer-trip/blocks/999/fields', [
            'fields' => [['field_id' => 1, 'value' => 'Test']],
        ])
            ->assertStatus(404)
            ->assertJson(['status' => 'error', 'message' => 'Not found']);
    }

    public function test_d2_update_block_fields_missing_fields_key(): void
    {
        Sanctum::actingAs(User::find(1));

        $this->putJson('/api/itineraries/japan-summer-trip/blocks/1/fields', [])
            ->assertStatus(422)
            ->assertJson(['status' => 'error', 'message' => 'Invalid field'])
            ->assertJsonStructure(['errors' => ['fields']]);
    }

    public function test_d2_update_block_fields_invalid_field_id(): void
    {
        Sanctum::actingAs(User::find(1));

        $this->putJson('/api/itineraries/japan-summer-trip/blocks/1/fields', [
            'fields' => [['field_id' => 999, 'value' => 'Bad']],
        ])
            ->assertStatus(422)
            ->assertJson(['status' => 'error', 'message' => 'Invalid field']);
    }

    public function test_d2_update_block_fails_unauthenticated(): void
    {
        $this->putJson('/api/itineraries/japan-summer-trip/blocks/1/fields', [
            'fields' => [['field_id' => 1, 'value' => 'Test']],
        ])
            ->assertStatus(401)
            ->assertJson(['status' => 'error', 'message' => 'Unauthenticated.']);
    }

    // ─── D3: Reorder Blocks ──────────────────────────────────────────────────

    public function test_d3_reorder_blocks_success(): void
    {
        Sanctum::actingAs(User::find(1));

        // Itinerary 1 has blocks 1–6, reverse the order
        $response = $this->putJson('/api/itineraries/japan-summer-trip/blocks/reorder', [
            'blocks' => [6, 5, 4, 3, 2, 1],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status'  => 'success',
                'message' => 'Blocks reordered successful',
            ]);

        // Verify block 6 now has position 0 (first)
        $this->assertDatabaseHas('itinerary_blocks', ['id' => 6, 'position' => 0]);
        $this->assertDatabaseHas('itinerary_blocks', ['id' => 1, 'position' => 5]);
    }

    public function test_d3_reorder_blocks_forbidden(): void
    {
        Sanctum::actingAs(User::find(2)); // not owner

        $this->putJson('/api/itineraries/japan-summer-trip/blocks/reorder', [
            'blocks' => [1, 2, 3],
        ])
            ->assertStatus(403)
            ->assertJson(['status' => 'error', 'message' => 'Forbidden access']);
    }

    public function test_d3_reorder_blocks_itinerary_not_found(): void
    {
        Sanctum::actingAs(User::find(1));

        $this->putJson('/api/itineraries/nonexistent/blocks/reorder', [
            'blocks' => [1, 2],
        ])
            ->assertStatus(404)
            ->assertJson(['status' => 'error', 'message' => 'Not found']);
    }

    public function test_d3_reorder_blocks_missing_blocks_key(): void
    {
        Sanctum::actingAs(User::find(1));

        $this->putJson('/api/itineraries/japan-summer-trip/blocks/reorder', [])
            ->assertStatus(422)
            ->assertJson(['status' => 'error', 'message' => 'Invalid field'])
            ->assertJsonStructure(['errors' => ['blocks']]);
    }

    public function test_d3_reorder_blocks_fails_unauthenticated(): void
    {
        $this->putJson('/api/itineraries/japan-summer-trip/blocks/reorder', [
            'blocks' => [1, 2],
        ])
            ->assertStatus(401)
            ->assertJson(['status' => 'error', 'message' => 'Unauthenticated.']);
    }

    // ─── D4: Remove Block ────────────────────────────────────────────────────

    public function test_d4_remove_block_success(): void
    {
        Sanctum::actingAs(User::find(1));

        $this->deleteJson('/api/itineraries/japan-summer-trip/blocks/1')
            ->assertStatus(200)
            ->assertJson(['status' => 'success', 'message' => 'Block removed successful']);

        $this->assertDatabaseMissing('itinerary_blocks', ['id' => 1]);
        // Field values must also be deleted
        $this->assertDatabaseMissing('block_field_values', ['itinerary_block_id' => 1]);
    }

    public function test_d4_remove_block_forbidden(): void
    {
        Sanctum::actingAs(User::find(2)); // not owner

        $this->deleteJson('/api/itineraries/japan-summer-trip/blocks/1')
            ->assertStatus(403)
            ->assertJson(['status' => 'error', 'message' => 'Forbidden access']);
    }

    public function test_d4_remove_block_not_found(): void
    {
        Sanctum::actingAs(User::find(1));

        $this->deleteJson('/api/itineraries/japan-summer-trip/blocks/999')
            ->assertStatus(404)
            ->assertJson(['status' => 'error', 'message' => 'Not found']);
    }

    public function test_d4_remove_block_fails_unauthenticated(): void
    {
        $this->deleteJson('/api/itineraries/japan-summer-trip/blocks/1')
            ->assertStatus(401)
            ->assertJson(['status' => 'error', 'message' => 'Unauthenticated.']);
    }
}
