<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Factories\UserFactory;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    // Este trait ejecutará las migraciones de la base de datos de la aplicación y, entre cada caso de prueba, actualizará la base de datos a su estado original.

    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function test_login_displays_validation_errors()
    {
        //al realizar una solicitud POST a la url login con credenciales no válidas, me redirecciona nuevamente a login y recibo un error de validación

        $response = $this->post(route('login'), []);

        $response->assertStatus(302); //302 redirección
        $response->assertSessionHasErrors(['password', 'email']); //error de validación en password y mail
    }


    /** @test */
    public function test_login_authenticates_user_and_login()
    {
        //al realizar una solicitud POST a la url login con credenciales válidas, el usuario es autentificado y la respuesta es OK

        $this->artisan('passport:install'); // crear personal access client

        $user = User::factory()->create();
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertStatus(200);
    }
}
