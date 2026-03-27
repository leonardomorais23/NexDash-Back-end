<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Dashboard\DashboardTeam;
use App\Models\Dashboard\DashboardSnapshot;
use Carbon\Carbon;

class CaptureDashboardSnapshots extends Command
{

    protected $signature = 'app:capture-dashboard-snapshots';


    protected $description = 'Captura os dados atuais dos times e salva no histórico (snapshot)';

    public function handle()
    {
        $this->info('Iniciando captura de snapshots...');

        $teams = DashboardTeam::where('is_active', true)->get();

        if ($teams->isEmpty()) {
            $this->warn('Nenhum time ativo encontrado.');
            return;
        }

        foreach ($teams as $team) {
            DashboardSnapshot::create([
                'dashboard_team_id'       => $team->id,
                'pendentes'               => $team->pendentes ?? 0,
                'abertas'                 => $team->abertas ?? 0,
                'resolvidas'              => $team->resolvidas ?? 0,
                'total_volume'            => $team->total_volume ?? 0,
                'tempo_espera_min'        => $team->tempo_espera_min ?? 0,
                'tempo_primeira_resp_min' => $team->tempo_primeira_resp_min ?? 0,
                'tempo_resolucao_min'     => $team->tempo_resolucao_min ?? 0,
                'recorded_at'             => Carbon::now(),
            ]);

            $this->line("✔ Snapshot salvo para: {$team->name}");
        }

        $this->info('Processo concluído com sucesso!');
    }
}
