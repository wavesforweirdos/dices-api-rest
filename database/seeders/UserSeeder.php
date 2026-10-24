<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => bcrypt('123456789')
        ])->assignRole('Admin');

        $players = User::factory(10)->create();
        foreach ($players as $player) {
            $player->assignRole('Player');
        }
    }
}
