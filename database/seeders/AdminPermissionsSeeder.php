<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class AdminPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@email.com')->first();

        if (!$admin) {
            $this->command->info('Admin não encontrado.');
            return;
        }

        $permissions = Permission::all();

        $admin->syncPermissions($permissions);

        $this->command->info('Todas as permissões atribuídas ao admin.');
    }
}
