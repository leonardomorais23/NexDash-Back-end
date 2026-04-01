<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Dashboard\DashboardTeam;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roleAdmin = Role::findOrCreate('admin', 'api');

        $dashboards = DashboardTeam::where('is_active', true)->get();

        foreach ($dashboards as $team) {
            $permissionName = "dashboard:{$team->slug}:read";
            $permission = Permission::findOrCreate($permissionName, 'api');
            $roleAdmin->givePermissionTo($permission);
        }

        $user = User::where('email', 'admin@email.com')->first();
        if ($user) {
            $user->assignRole($roleAdmin);
            $this->command->info("Role Admin atribuída ao usuário Leleo com todas as permissões de dashboards ativos!");
        }
    }
}
