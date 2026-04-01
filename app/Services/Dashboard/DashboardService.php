<?php

namespace App\Services\Dashboard;

use App\Models\Dashboard\DashboardTeam;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        if ($min > 0 || empty($parts)) $parts[] = "{$min} Min";

        return implode(' ', $parts);
    }

    public function getAllActiveTeams()
    {
        $user = Auth::user();

        $dashboards = DashboardTeam::where('is_active', true)->get();

        return $dashboards->filter(function ($team) use ($user) {
            return $user->can("dashboard:{$team->slug}:read");
        })->map(function ($team) {
            return [
                'id'    => (string) $team->slug,
                'title' => $team->name,
                'color' => 'text-emerald-400',
            ];
        })->values();
    }

    public function getDashboardDataBySlug(string $slug): array
    {
        $team = DashboardTeam::where('slug', $slug)->firstOrFail();

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
                'pendentes' => $team->pendentes ?? 0,
                'abertas'   => $team->abertas ?? 0,
                'todos'     => $team->total_volume ?? 0,
                'tempoEspera'       => $this->formatInterval($team->tempo_espera_min ?? 0),
                'tempoPrimeiraResp' => $this->formatInterval($team->tempo_primeira_resp_min ?? 0),
                'tempoResolucao'    => $this->formatInterval($team->tempo_resolucao_min ?? 0),
            ],
            'history' => $history->values()
        ];
    }
}
