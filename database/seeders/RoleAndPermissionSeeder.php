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

        $roleAdmin       = Role::findOrCreate('admin', 'api');
        $roleGerente     = Role::findOrCreate('gerente', 'api');
        $roleColaborador = Role::findOrCreate('colaborador', 'api');

        $dashboards = DashboardTeam::where('is_active', true)->get();

        foreach ($dashboards as $team) {
            $permissionName = "dashboard:{$team->slug}:read";
            Permission::findOrCreate($permissionName, 'api');
        }

        $allPermissions = Permission::all();
        $roleAdmin->syncPermissions($allPermissions);

        $user = User::where('email', 'admin@email.com')->first();
        if ($user) {
            $user->syncRoles([$roleAdmin]);

            $this->command->info("--- Configuração Concluída ---");
            $this->command->info("Usuário: {$user->name}");
            $this->command->info("Role: Admin (com " . $allPermissions->count() . " permissões)");
            $this->command->info("Roles 'gerente' e 'colaborador' criadas (vazias).");
        }
    }
}
