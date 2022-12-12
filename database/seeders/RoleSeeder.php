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

        Permission::create(['name' => 'admin.home'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'register'])->syncRoles([$roleAdmin, $rolePlayer]);
        Permission::create(['name' => 'login'])->syncRoles([$roleAdmin, $rolePlayer]);
        Permission::create(['name' => 'logout'])->syncRoles([$roleAdmin, $rolePlayer]);

        Permission::create(['name' => 'createPlayer'])->syncRoles([$roleAdmin, $rolePlayer]);
        Permission::create(['name' => 'editName'])->syncRoles([$roleAdmin, $rolePlayer]);
        Permission::create(['name' => 'throw'])->syncRoles([$roleAdmin, $rolePlayer]);
        Permission::create(['name' => 'deleteThrows'])->syncRoles([$roleAdmin, $rolePlayer]);

        Permission::create(['name' => 'admin.show-victories'])->syncRoles($roleAdmin);
        Permission::create(['name' => 'throws'])->syncRoles([$roleAdmin, $rolePlayer]);
        Permission::create(['name' => 'admin.show-players'])->syncRoles($roleAdmin);
        Permission::create(['name' => 'admin.loser'])->syncRoles($roleAdmin);
        Permission::create(['name' => 'admin.winner'])->syncRoles($roleAdmin);
    }
}
