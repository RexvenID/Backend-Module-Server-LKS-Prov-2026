<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    // ─── A1: Register ────────────────────────────────────────────────────────

    public function test_a1_register_success(): void
    {
        $response = $this->postJson('/api/register', [
            'name'     => 'Budi Santoso',
            'email'    => 'budi@tripplanner.id',
            'password' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'status'  => 'success',
                'message' => 'Registration successful',
            ])
            ->assertJsonStructure([
                'data' => ['id', 'name', 'email', 'created_at', 'updated_at', 'token'],
            ]);

        $this->assertEquals('budi@tripplanner.id', $response->json('data.email'));
        $this->assertNotNull($response->json('data.token'));
        $this->assertArrayNotHasKey('password', $response->json('data'));
        // token must be flat inside data, not nested under 'user'
        $this->assertArrayNotHasKey('user', $response->json('data'));
    }

    public function test_a1_register_fails_missing_name(): void
    {
        $response = $this->postJson('/api/register', [
            'email'    => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJson(['status' => 'error', 'message' => 'Invalid field'])
            ->assertJsonStructure(['errors' => ['name']]);
    }

    public function test_a1_register_fails_invalid_email(): void
    {
        $response = $this->postJson('/api/register', [
            'name'     => 'Test',
            'email'    => 'not-an-email',
            'password' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJson(['status' => 'error', 'message' => 'Invalid field'])
            ->assertJsonStructure(['errors' => ['email']]);
    }

    public function test_a1_register_fails_duplicate_email(): void
    {
        $response = $this->postJson('/api/register', [
            'name'     => 'Duplicate',
            'email'    => 'john.doe@gmail.com', // seeded user
            'password' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJson(['status' => 'error', 'message' => 'Invalid field'])
            ->assertJsonStructure(['errors' => ['email']]);
    }

    public function test_a1_register_fails_password_too_short(): void
    {
        $response = $this->postJson('/api/register', [
            'name'     => 'Test',
            'email'    => 'short@example.com',
            'password' => '12345', // 5 chars, min is 6
        ]);

        $response->assertStatus(422)
            ->assertJson(['status' => 'error', 'message' => 'Invalid field'])
            ->assertJsonStructure(['errors' => ['password']]);
    }

    // ─── A2: Login ───────────────────────────────────────────────────────────

    public function test_a2_login_success(): void
    {
        $user = User::factory()->create(['password' => Hash::make('mysecret')]);

        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => 'mysecret',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status'  => 'success',
                'message' => 'Login successful',
            ])
            ->assertJsonStructure([
                'data' => ['id', 'name', 'email', 'created_at', 'updated_at', 'token'],
            ]);

        $this->assertEquals($user->email, $response->json('data.email'));
        $this->assertNotNull($response->json('data.token'));
        // must be flat — no 'user' wrapper key
        $this->assertArrayNotHasKey('user', $response->json('data'));
    }

    public function test_a2_login_fails_wrong_password(): void
    {
        $user = User::factory()->create(['password' => Hash::make('correct')]);

        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'status'  => 'error',
                'message' => 'Username or password incorrect',
            ]);
    }

    public function test_a2_login_fails_nonexistent_email(): void
    {
        $response = $this->postJson('/api/login', [
            'email'    => 'ghost@nowhere.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'status'  => 'error',
                'message' => 'Username or password incorrect',
            ]);
    }

    // ─── A3: Logout ──────────────────────────────────────────────────────────

    public function test_a3_logout_success(): void
    {
        Sanctum::actingAs(User::find(1));

        $response = $this->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson([
                'status'  => 'success',
                'message' => 'Logout successful',
            ]);
    }

    public function test_a3_logout_fails_unauthenticated(): void
    {
        $response = $this->postJson('/api/logout');

        $response->assertStatus(401)
            ->assertJson([
                'status'  => 'error',
                'message' => 'Unauthenticated.',
            ]);
    }

    public function test_a3_logout_only_invalidates_current_token(): void
    {
        $user = User::factory()->create(['password' => Hash::make('pass')]);

        $token1 = $user->createToken('device-1')->plainTextToken;
        $token2 = $user->createToken('device-2')->plainTextToken;

        // Logout with token1
        $this->withHeader('Authorization', "Bearer $token1")
            ->postJson('/api/logout')
            ->assertStatus(200);

        // token2 must still work
        $this->withHeader('Authorization', "Bearer $token2")
            ->getJson('/api/itineraries')
            ->assertStatus(200);
    }
}
