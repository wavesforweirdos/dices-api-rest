<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function test_register_insert_user_on_database()
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', $user->toArray());
    }

    /** @test */
    public function test_register_creates_and_authenticates_a_user()
    {
        // solicitud POST al registro de usuario con datos válidos
        $this->artisan('passport:install');

        $name = $this->faker->name;
        $email = $this->faker->safeEmail;
        $password = $this->faker->password(8);

        $user = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $response = $this->post(route('register'), $user);
        $response->assertStatus(200);
    }

    /** @test */
    public function test_register_displays_validation_errors()
    {
        // solicitud POST al registro de usuario con validación de errores
        $response = $this->post(route('register'), []);
        $response->assertStatus(302);
    }

    /** @test */
    public function test_register_user_with_empty_password()
    {
        // solicitud POST al registro de usuario con campo de password vacío
        $this->artisan('passport:install');
        $user = [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ];
        $response =  $this->postJson(route('register'), $user);
        $response->assertStatus(422);
    }

    /** @test */
    public function test_register_user_with_wrong_password_confirmation()
    {
        // solicitud POST al registro de usuario con campo de password_confirmation distinto a password
        $this->artisan('passport:install');
        $user = [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345679',
        ];
        $response = $this->postJson(route('register'), $user);
        $response->assertStatus(422);
    }

    /** @test */
    public function test_register_user_with_empty_name_return_an_anonymous_user()
    {
        // solicitud POST al registro de usuario con campo de nombre vacío
        $this->artisan('passport:install');
        $user = [
            'name' => '',
            'email' => 'test@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];
        $response = $this->post(route('register'), $user);
        $this->assertDatabaseHas('users', [
            'name' => 'Anonymous',
            'email' => 'test@example.com',
        ]);
    }
}
