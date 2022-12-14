<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::create(['name' => 'Admin']);
        $rolePlayer = Role::create(['name' => 'Player']);

        Permission::create(['name' => 'admin.home'])->assignRole([$roleAdmin]);
        Permission::create(['name' => 'register'])->syncRoles([$roleAdmin, $rolePlayer]);
        Permission::create(['name' => 'login'])->syncRoles([$roleAdmin, $rolePlayer]);
        Permission::create(['name' => 'logout'])->syncRoles([$roleAdmin, $rolePlayer]);

        Permission::create(['name' => 'editName'])->syncRoles([$roleAdmin, $rolePlayer]);
        Permission::create(['name' => 'throw'])->syncRoles([$roleAdmin, $rolePlayer]);
        Permission::create(['name' => 'deleteThrows'])->syncRoles([$roleAdmin, $rolePlayer]);
        Permission::create(['name' => 'throws'])->syncRoles([$roleAdmin, $rolePlayer]);

        Permission::create(['name' => 'admin.fullSuccessRateRecord'])->assignRole($roleAdmin);
        Permission::create(['name' => 'ranking'])->assignRole($roleAdmin);
        Permission::create(['name' => 'loser'])->assignRole($roleAdmin);
        Permission::create(['name' => 'winner'])->assignRole($roleAdmin);
        Permission::create(['name' => 'admin.successRate'])->assignRole($roleAdmin);
    }
}
