<?php

namespace App\Services\Dashboard;

use App\Models\Dashboard\DashboardTeam;
use Carbon\Carbon;

class DashboardService
{

    private function formatInterval(int $totalMinutes): string
    {
        if ($totalMinutes <= 0) return "0 Min";

        $days = floor($totalMinutes / 1440);
        $hours = floor(($totalMinutes % 1440) / 60);
        $min = $totalMinutes % 60;

        $parts = [];

        if ($days > 0) $parts[] = "{$days} D";
        if ($hours > 0) $parts[] = "{$hours} Hr";

        if ($min > 0 || empty($parts)) {
            $parts[] = "{$min} Min";
        }

        return implode(' ', $parts);
    }


    public function getAllActiveTeams()
    {
        return DashboardTeam::where('is_active', true)
            ->get()
            ->map(function ($team) {
                return [
                    'id'    => (string) $team->slug,
                    'title' => $team->name,
                    'color' => 'text-emerald-400',
                ];
            });
    }

    public function getDashboardDataBySlug(string $slug): array
    {
        $team = DashboardTeam::where('slug', $slug)->firstOrFail();

        $latest = $team->snapshots()->latest('recorded_at')->first();

        $history = $team->snapshots()
            ->whereDate('recorded_at', Carbon::today())
            ->orderBy('recorded_at', 'asc')
            ->get()
            ->map(fn($s) => [
                'dateTime' => $s->recorded_at->format('H:i'),
                'atendimentosResolvidos' => $s->resolvidas,
                'atendimentosPendentes' => $s->pendentes
            ]);

        return [
            'metrics' => [
                'pendentes' => $latest->pendentes ?? 0,
                'abertas' => $latest->abertas ?? 0,
                'todos' => $latest->total_volume ?? 0,
                'tempoEspera' => $latest ? $this->formatInterval($latest->tempo_espera_min) : '0 D 0 Hr 0 Min',
                'tempoPrimeiraResp' => $latest ? $this->formatInterval($latest->tempo_primeira_resp_min) : '0 D 0 Hr 0 Min',
                'tempoResolucao' => $latest ? $this->formatInterval($latest->tempo_resolucao_min) : '0 D 0 Hr 0 Min',
            ],
            'history' => $history->values()
        ];
    }
}
