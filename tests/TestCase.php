<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\ClientRepository;

abstract class TestCase extends BaseTestCase
{
    /**
     * Crea el cliente de acceso personal que Passport necesita para emitir tokens
     * (antes lo hacía `passport:install`, que ahora pide datos por consola).
     */
    protected function createPassportClients(): void
    {
        app(ClientRepository::class)->createPersonalAccessGrantClient('Dice Game Personal Access Client', 'users');
    }
}
