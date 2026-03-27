<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dashboard\DashboardTeam;

class DashboardTeamSeeder extends Seeder
{
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Pedagógico Gestor',
                'slug' => 'pedagogico-gestor',
                'is_active' => true,
                'pendentes' => 12,
                'abertas' => 5,
                'resolvidas' => 85,
                'total_volume' => 102,
                'tempo_espera_min' => 45,
                'tempo_primeira_resp_min' => 120,
                'tempo_resolucao_min' => 480,
            ],
            [
                'name' => 'Financeiro - Gestor',
                'slug' => 'financeiro-gestor',
                'is_active' => true,
                'pendentes' => 8,
                'abertas' => 3,
                'resolvidas' => 40,
                'total_volume' => 51,
                'tempo_espera_min' => 15,
                'tempo_primeira_resp_min' => 60,
                'tempo_resolucao_min' => 180,
            ]
        ];

        foreach ($teams as $team) {
            DashboardTeam::updateOrCreate(['slug' => $team['slug']], $team);
        }
    }
}
