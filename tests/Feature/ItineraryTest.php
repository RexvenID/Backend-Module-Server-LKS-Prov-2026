<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ItineraryTest extends TestCase
{
    // ─── B1: Create Itinerary ────────────────────────────────────────────────

    public function test_b1_create_itinerary_success(): void
    {
        Sanctum::actingAs(User::find(1));

        $response = $this->postJson('/api/itineraries', [
            'title'   => 'New Test Trip',
            'slug'    => 'new-test-trip',
            'summary' => 'A short summary',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'status'  => 'success',
                'message' => 'Itinerary created successful',
                'data'    => [
                    'user_id' => 1,
                    'title'   => 'New Test Trip',
                    'slug'    => 'new-test-trip',
                    'summary' => 'A short summary',
                ],
            ])
            ->assertJsonStructure([
                'data' => ['id', 'user_id', 'title', 'slug', 'summary', 'created_at', 'updated_at'],
            ]);

        $this->assertDatabaseHas('itineraries', ['slug' => 'new-test-trip', 'user_id' => 1]);
    }

    public function test_b1_create_itinerary_without_summary(): void
    {
        Sanctum::actingAs(User::find(1));

        $response = $this->postJson('/api/itineraries', [
            'title' => 'No Summary Trip',
            'slug'  => 'no-summary-trip',
        ]);

        $response->assertStatus(201)
            ->assertJson(['status' => 'success']);
    }

    public function test_b1_create_itinerary_fails_duplicate_slug(): void
    {
        Sanctum::actingAs(User::find(1));

        $response = $this->postJson('/api/itineraries', [
            'title' => 'Another Japan',
            'slug'  => 'japan-summer-trip', // already seeded
        ]);

        $response->assertStatus(422)
            ->assertJson(['status' => 'error', 'message' => 'Invalid field'])
            ->assertJsonStructure(['errors' => ['slug']]);
    }

    public function test_b1_create_itinerary_fails_invalid_slug_chars(): void
    {
        Sanctum::actingAs(User::find(1));

        $response = $this->postJson('/api/itineraries', [
            'title' => 'Bad Slug',
            'slug'  => 'Invalid Slug With Spaces!',
        ]);

        $response->assertStatus(422)
            ->assertJson(['status' => 'error', 'message' => 'Invalid field'])
            ->assertJsonStructure(['errors' => ['slug']]);
    }

    public function test_b1_create_itinerary_fails_missing_title(): void
    {
        Sanctum::actingAs(User::find(1));

        $response = $this->postJson('/api/itineraries', [
            'slug' => 'no-title-trip',
        ]);

        $response->assertStatus(422)
            ->assertJson(['status' => 'error', 'message' => 'Invalid field'])
            ->assertJsonStructure(['errors' => ['title']]);
    }

    public function test_b1_create_itinerary_fails_unauthenticated(): void
    {
        $response = $this->postJson('/api/itineraries', [
            'title' => 'Trip',
            'slug'  => 'trip',
        ]);

        $response->assertStatus(401)
            ->assertJson(['status' => 'error', 'message' => 'Unauthenticated.']);
    }

    // ─── B2: Get All Itineraries ─────────────────────────────────────────────

    public function test_b2_get_all_itineraries_returns_only_own(): void
    {
        Sanctum::actingAs(User::find(1));

        $response = $this->getJson('/api/itineraries');

        $response->assertStatus(200)
            ->assertJson([
                'status'  => 'success',
                'message' => 'Get all itineraries successful',
            ])
            ->assertJsonStructure([
                'data' => [
                    'itineraries' => [
                        '*' => ['id', 'user_id', 'title', 'slug', 'summary', 'created_at', 'updated_at'],
                    ],
                ],
            ]);

        $itineraries = $response->json('data.itineraries');
        $this->assertNotEmpty($itineraries);
        foreach ($itineraries as $item) {
            $this->assertEquals(1, $item['user_id']);
        }
    }

    public function test_b2_get_all_itineraries_does_not_return_other_users(): void
    {
        Sanctum::actingAs(User::find(1));

        $response  = $this->getJson('/api/itineraries');
        $slugs     = array_column($response->json('data.itineraries'), 'slug');

        $this->assertContains('japan-summer-trip', $slugs);
        $this->assertNotContains('bali-summer-escape', $slugs);
        $this->assertNotContains('paris-winter-getaway', $slugs);
    }

    public function test_b2_get_all_itineraries_fails_unauthenticated(): void
    {
        $this->getJson('/api/itineraries')
            ->assertStatus(401)
            ->assertJson(['status' => 'error', 'message' => 'Unauthenticated.']);
    }

    // ─── B3: Get Itinerary by Slug ───────────────────────────────────────────

    public function test_b3_get_itinerary_success(): void
    {
        Sanctum::actingAs(User::find(1));

        $response = $this->getJson('/api/itineraries/japan-summer-trip');

        $response->assertStatus(200)
            ->assertJson([
                'status'  => 'success',
                'message' => 'Get itinerary successful',
                'data'    => [
                    'user_id' => 1,
                    'slug'    => 'japan-summer-trip',
                ],
            ])
            ->assertJsonStructure([
                'data' => [
                    'id', 'user_id', 'title', 'slug', 'summary', 'created_at', 'updated_at',
                    'blocks' => [
                        '*' => [
                            'id', 'position',
                            'template' => ['id', 'name', 'slug'],
                            'fields'   => [
                                '*' => ['id', 'name', 'slug', 'type', 'value'],
                            ],
                        ],
                    ],
                ],
            ]);

        $blocks = $response->json('data.blocks');
        $this->assertNotEmpty($blocks);
        // fields of each block must not be empty (template fields always present)
        foreach ($blocks as $block) {
            $this->assertNotEmpty($block['fields']);
        }
    }

    public function test_b3_get_itinerary_forbidden_for_other_user(): void
    {
        Sanctum::actingAs(User::find(2)); // not owner

        $this->getJson('/api/itineraries/japan-summer-trip')
            ->assertStatus(403)
            ->assertJson(['status' => 'error', 'message' => 'Forbidden access']);
    }

    public function test_b3_get_itinerary_not_found(): void
    {
        Sanctum::actingAs(User::find(1));

        $this->getJson('/api/itineraries/nonexistent-slug')
            ->assertStatus(404)
            ->assertJson(['status' => 'error', 'message' => 'Not found']);
    }

    public function test_b3_get_itinerary_fails_unauthenticated(): void
    {
        $this->getJson('/api/itineraries/japan-summer-trip')
            ->assertStatus(401)
            ->assertJson(['status' => 'error', 'message' => 'Unauthenticated.']);
    }

    // ─── B4: Update Itinerary ────────────────────────────────────────────────

    public function test_b4_update_itinerary_success(): void
    {
        Sanctum::actingAs(User::find(1));

        $response = $this->putJson('/api/itineraries/japan-summer-trip', [
            'title'   => 'Updated Japan Trip',
            'slug'    => 'updated-japan-trip',
            'summary' => 'Updated summary',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status'  => 'success',
                'message' => 'Itinerary updated successful',
                'data'    => [
                    'user_id' => 1,
                    'title'   => 'Updated Japan Trip',
                    'slug'    => 'updated-japan-trip',
                    'summary' => 'Updated summary',
                ],
            ])
            ->assertJsonStructure([
                'data' => ['id', 'user_id', 'title', 'slug', 'summary', 'created_at', 'updated_at'],
            ]);
    }

    public function test_b4_update_itinerary_partial_title_only(): void
    {
        Sanctum::actingAs(User::find(1));

        $response = $this->putJson('/api/itineraries/japan-summer-trip', [
            'title' => 'Partial Update',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data'   => ['title' => 'Partial Update'],
            ]);
    }

    public function test_b4_update_itinerary_fails_duplicate_slug(): void
    {
        Sanctum::actingAs(User::find(1));

        $response = $this->putJson('/api/itineraries/japan-summer-trip', [
            'slug' => 'bali-summer-escape', // belongs to another itinerary
        ]);

        $response->assertStatus(422)
            ->assertJson(['status' => 'error', 'message' => 'Invalid field']);
    }

    public function test_b4_update_itinerary_forbidden(): void
    {
        Sanctum::actingAs(User::find(2)); // not owner

        $this->putJson('/api/itineraries/japan-summer-trip', ['title' => 'Hack'])
            ->assertStatus(403)
            ->assertJson(['status' => 'error', 'message' => 'Forbidden access']);
    }

    public function test_b4_update_itinerary_not_found(): void
    {
        Sanctum::actingAs(User::find(1));

        $this->putJson('/api/itineraries/nonexistent', ['title' => 'Update'])
            ->assertStatus(404)
            ->assertJson(['status' => 'error', 'message' => 'Not found']);
    }

    public function test_b4_update_itinerary_fails_unauthenticated(): void
    {
        $this->putJson('/api/itineraries/japan-summer-trip', ['title' => 'X'])
            ->assertStatus(401)
            ->assertJson(['status' => 'error', 'message' => 'Unauthenticated.']);
    }

    // ─── B5: Delete Itinerary ────────────────────────────────────────────────

    public function test_b5_delete_itinerary_success(): void
    {
        Sanctum::actingAs(User::find(1));

        $this->deleteJson('/api/itineraries/japan-summer-trip')
            ->assertStatus(200)
            ->assertJson(['status' => 'success', 'message' => 'Itinerary deleted successful']);

        $this->assertDatabaseMissing('itineraries', ['slug' => 'japan-summer-trip']);
        // blocks and field values must be cascade-deleted
        $this->assertDatabaseMissing('itinerary_blocks', ['itinerary_id' => 1]);
        $this->assertDatabaseMissing('block_field_values', ['itinerary_block_id' => 1]);
    }

    public function test_b5_delete_itinerary_forbidden(): void
    {
        Sanctum::actingAs(User::find(2)); // not owner

        $this->deleteJson('/api/itineraries/japan-summer-trip')
            ->assertStatus(403)
            ->assertJson(['status' => 'error', 'message' => 'Forbidden access']);
    }

    public function test_b5_delete_itinerary_not_found(): void
    {
        Sanctum::actingAs(User::find(1));

        $this->deleteJson('/api/itineraries/nonexistent')
            ->assertStatus(404)
            ->assertJson(['status' => 'error', 'message' => 'Not found']);
    }

    public function test_b5_delete_itinerary_fails_unauthenticated(): void
    {
        $this->deleteJson('/api/itineraries/japan-summer-trip')
            ->assertStatus(401)
            ->assertJson(['status' => 'error', 'message' => 'Unauthenticated.']);
    }
}
