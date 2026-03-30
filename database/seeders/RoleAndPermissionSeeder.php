<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permission = Permission::findOrCreate('dashboard:financeiro:read', 'api');

        $roleAdmin = Role::findOrCreate('admin', 'api');

        $roleAdmin->givePermissionTo($permission);

        $user = User::where('email', 'leleo@nexdash.com')->first();

        if ($user) {
            $user->assignRole($roleAdmin);
            $this->command->info("Role Admin atribuída ao usuário Leleo!");
        }
    }
}
