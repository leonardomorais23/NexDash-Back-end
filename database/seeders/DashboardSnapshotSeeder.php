<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dashboard\DashboardTeam;
use App\Models\Dashboard\DashboardSnapshot;
use Carbon\Carbon;

class DashboardSnapshotSeeder extends Seeder
{
    public function run(): void
    {
        $teams = DashboardTeam::all();
        $now = Carbon::now();

        foreach ($teams as $team) {
            for ($i = 1; $i >= 0; $i--) {
                $time = $now->copy()->subMinutes($i * 30);

                DashboardSnapshot::create([
                    'dashboard_team_id' => $team->id,
                    'pendentes' => max(0, $team->pendentes + rand(-5, 15)),
                    'abertas' => max(0, $team->abertas + rand(-2, 5)),
                    'resolvidas' => max(0, $team->resolvidas + rand(0, 10)),
                    'total_volume' => $team->total_volume + rand(0, 20),
                    'tempo_espera_min' => $team->tempo_espera_min + rand(-10, 20),
                    'tempo_primeira_resp_min' => $team->tempo_primeira_resp_min,
                    'tempo_resolucao_min' => $team->tempo_resolucao_min,
                    'recorded_at' => $time,
                ]);
            }
        }
    }
}
