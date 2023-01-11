<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;

class LogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // use RefreshDatabase;

    /** @test */

    public function test_auth_user_can_logout()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();
        Passport::actingAs($user);
        
        $response = $this->post(route('logout'))
        ->assertStatus(200);
        
        $this->assertAuthenticated();
    }
}
