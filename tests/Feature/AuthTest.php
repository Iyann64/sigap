<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_see_login_page_at_root(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }

    public function test_active_user_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'anggota@sigap.test',
            'password' => 'password',
            'role' => 'anggota',
            'is_active' => true,
        ]);

        $response = $this->post(route('login.store'), [
            'email' => 'anggota@sigap.test',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_inactive_user_cannot_login(): void
    {
        User::factory()->create([
            'email' => 'inactive@sigap.test',
            'password' => 'password',
            'role' => 'anggota',
            'is_active' => false,
        ]);

        $response = $this->from(route('login'))->post(route('login.store'), [
            'email' => 'inactive@sigap.test',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
