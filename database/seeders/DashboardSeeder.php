<?php

namespace Database\Seeders;

use App\Models\Dashboard\DashboardTeam;
use App\Models\Dashboard\DashboardSnapshot;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DashboardSeeder extends Seeder
{
    public function run(): void
    {
        $pedagogico = DashboardTeam::updateOrCreate(
            ['slug' => 'pedagogico'],
            [
                'name' => 'Pedagógico Gestor',
                'is_active' => true,
            ]
        );

        $financeiro = DashboardTeam::updateOrCreate(
            ['slug' => 'financeiro'],
            [
                'name' => 'Financeiro - Gestor',
                'is_active' => true,
            ]
        );

        $now = Carbon::now();

        for ($i = 20; $i >= 0; $i--) {
            DashboardSnapshot::create([
                'dashboard_team_id' => $pedagogico->id,
                'pendentes' => rand(40, 55),
                'abertas' => rand(0, 5),
                'resolvidas' => ($i === 0) ? 210 : rand(0, 10),
                'total_volume' => 48,
                'tempo_resolucao_min' => 770,
                'tempo_espera_min' => 4889,
                'tempo_primeira_resp_min' => 504,
                'recorded_at' => $now->copy()->subMinutes($i),
            ]);
        }
    }
}
