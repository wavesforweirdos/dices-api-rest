<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class GameTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan("db:seed", ['--class' => 'RoleSeeder']);
        $this->app->make(PermissionRegistrar::class)->registerPermissions();
    }

    /** @test */
    public function test_unauth_user_cant_play()
    {
        $this->artisan('passport:install');

        $user = User::factory()->create();

        $response = $this->post(
            route('throw', $user->id)
        )->assertRedirect(route('login'));
    }

    /** @test */
    public function test_auth_user_can_play_with_own_id()
    {
        $this->artisan('passport:install');

        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->post(
            route('throw', $user->id)
        );

        $this->assertDatabaseHas('games', [
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function test_auth_user_cant_play_with_other_id()
    {
        $this->artisan('passport:install');

        $user1 = User::factory()->create();
        Passport::actingAs($user1);
        $user2 = User::factory()->create();

        $response = $this->post(
            route('throw', $user2->id)
        );

        $this->assertDatabaseMissing('games', [
            'user_id' => $user2->id,
        ]);
    }

    /** @test */
    public function test_auth_user_can_show_all_his_games()
    {
        $this->artisan('passport:install');

        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->get(
            route('throws', $user->id)
        )->assertStatus(200);
    }

    /** @test */
    public function test_auth_user_cant_show_games_of_other_users()
    {
        $this->artisan('passport:install');

        $user1 = User::factory()->create()->assignRole('Player');
        $user2 = User::factory()
            ->has(Game::factory()->count(5))
            ->create();
        Passport::actingAs($user1);

        $response = $this->get(
            route('throws', $user2->id)
        )->assertStatus(401);

    }

    /** @test */
    public function test_admin_user_can_show_games_of_other_users()
    {
        $this->artisan('passport:install');

        $admin = User::factory()->create()->assignRole('Admin');
        $user = User::factory()
            ->has(Game::factory()->count(5))
            ->create()
            ->assignRole('Player');
        Passport::actingAs($admin);

        $response = $this->get(
            route('throws', $user->id)
        )->assertStatus(200);
    }

    /** @test */
    public function test_auth_user_can_destroy_all_his_games()
    {
        $this->artisan('passport:install');

        $user = User::factory()
            ->has(Game::factory()->count(5))
            ->create();
        Passport::actingAs($user);

        $response = $this->delete(
            route('deleteThrows', $user->id)
        )->assertStatus(200);
    }

    /** @test */
    public function test_auth_user_cant_destroy_games_of_other_users()
    {
        $this->artisan('passport:install');

        $user1 = User::factory()->create()->assignRole('Player');
        $user2 = User::factory()
            ->has(Game::factory()->count(5))
            ->create()
            ->assignRole('Player');
        Passport::actingAs($user1);

        $response = $this->delete(
            route('deleteThrows', $user2->id)
        )->assertStatus(401);
    }

    /** @test */
    public function test_admin_user_can_destroy_games_of_other_users()
    {
        $this->artisan('passport:install');

        $admin = User::factory()->create()->assignRole('Admin');
        $user = User::factory()
            ->has(Game::factory()->count(5))
            ->create()
            ->assignRole('Player');
        Passport::actingAs($admin);

        $response = $this->delete(
            route('deleteThrows', $user->id)
        )->assertStatus(200);
    }

    /** @test */
    public function test_unauth_user_cant_show_full_success_rate_record()
    {
        $this->artisan('passport:install');

        $response = $this->get(
            route('admin.fullSuccessRateRecord')
        )->assertRedirect(route('login'));
    }

    /** @test */
    public function test_auth_user_cant_show_full_success_rate_record()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create()->assignRole('Player');
        Passport::actingAs($user);

        $response = $this->get(
            route('admin.fullSuccessRateRecord')
        )->assertStatus(403); //the server understands the request but refuses to authorize it
    }

    /** @test */
    public function test_admin_can_show_full_success_rate_record()
    {
        $this->artisan('passport:install');
        $admin = User::factory()->create()->assignRole('Admin');
        Passport::actingAs($admin);

        $response = $this->get(
            route('admin.fullSuccessRateRecord')
        )->assertStatus(200);
    }

    /** @test */
    public function test_unauth_user_cant_get_ranking()
    {
        $user = User::factory()->create();

        $response = $this->get(
            route('ranking')
        );

        $this->assertGuest($guard = null); // Comprueba que el usuario no está autenticado.

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function test_auth_user_can_get_ranking()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->get(
            route('ranking')
        );

        $this->assertAuthenticatedAs($user);
        $response->assertStatus(200);
    }

    /** @test */
    public function test_unauth_user_cant_get_winner()
    {
        $user = User::factory()->create();

        $response = $this->get(
            route('winner')
        );

        $this->assertGuest($guard = null); // Comprueba que el usuario no está autenticado.

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function test_auth_user_can_get_winner()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->get(
            route('winner')
        );

        $this->assertAuthenticatedAs($user);
        $response->assertStatus(200);
    }

    /** @test */
    public function test_unauth_user_cant_get_loser()
    {
        $user = User::factory()->create();

        $response = $this->get(
            route('loser')
        );

        $this->assertGuest($guard = null); // Comprueba que el usuario no está autenticado.

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function test_auth_user_can_get_loser()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->get(
            route('loser')
        );

        $this->assertAuthenticatedAs($user);
        $response->assertStatus(200);
    }

    /** @test */
    public function test_auth_user_cant_show_success_rate()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create()->assignRole('Player');
        Passport::actingAs($user);

        $response = $this->get(
            route('admin.successRate')
        )->assertStatus(403); //the server understands the request but refuses to authorize it
    }

    /** @test */
    public function test_admin_can_show_success_rate()
    {
        $this->artisan('passport:install');
        $admin = User::factory()->create()->assignRole('Admin');
        Passport::actingAs($admin);

        $response = $this->get(
            route('admin.successRate')
        )->assertStatus(200);
    }
}
