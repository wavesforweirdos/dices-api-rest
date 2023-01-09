<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AuthUserTest extends TestCase
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
    public function test_auth_user_can_be_updated_by_himself()
    {
        $this->artisan('passport:install');

        $user = User::factory()->create();
        $user = Passport::actingAs($user);

        $user_updated =
            [
                'name' => 'test',
                'email' => 'test@email.com'
            ];

        $response = $this->put(
            route('editName', $user->id),
            $user_updated
        );

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['name' => 'test']);
        $response->assertOk();
    }

    /** @test */
    public function test_auth_user_can_be_updated_by_admin()
    {
        $this->artisan('passport:install');

        $user = User::factory()->create();
        $admin = User::factory()->create()->assignRole('Admin');
        Passport::actingAs($admin);

        $user_updated =
            [
                'name' => 'test2',
                'email' => 'test2@email.com'
            ];

        $response = $this->put(
            route('editName', $user->id),
            $user_updated
        );

        $this->assertAuthenticatedAs($admin);
        $this->assertDatabaseHas('users', ['name' => 'test2']);
        $response->assertOk();
    }

    /** @test */
    public function test_auth_user_cant_be_updated_by_others_no_admin_members()
    {
        $this->artisan('passport:install');

        $user1 = User::factory()->create()->assignRole('Player');
        $user2 = User::factory()->create()->assignRole('Player');
        Passport::actingAs($user2);

        $user_updated =
            [
                'name' => 'test3',
                'email' => 'test3@email.com'
            ];

        $response = $this->put(
            route('editName', $user1->id),
            $user_updated
        );

        $this->assertAuthenticatedAs($user2);
        $this->assertDatabaseMissing('users', ['name' => 'test3']);
        $response->assertOk();
    }

    /** @test */
    public function test_auth_user_cant_be_updated_with_empty_name()
    {
        $this->artisan('passport:install');

        $user = User::factory()->create();
        $user = Passport::actingAs($user);

        $user_updated =
            [
                'name' => '',
                'email' => 'test4@email.com'
            ];

        $response = $this->put(
            route('editName', $user->id),
            $user_updated
        )->assertStatus(302);
    }
}
