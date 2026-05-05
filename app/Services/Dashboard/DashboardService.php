<?php

namespace App\Services\Dashboard;

use App\Http\Requests\Dashboard\GetDashRequest;
use App\Models\Dashboard\DashboardTeam;
use App\Services\Permissions\PermissionsService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

readonly class DashboardService
{
    public function __construct(
        private PermissionsService $permissionsService
    ) {}

    public function createDashboard(array $data): void
    {
        DB::transaction(function () use ($data) {
            $slug = Str::slug($data['name']);

            DashboardTeam::create([
                'name' => $data['name'],
                'slug' => $slug,
                'is_active' => true,
            ]);

            $this->permissionsService->createPermission($slug, $data['roles'] ?? []);
        });
    }
    public function updateDashboards(int $id, array $data): void
    {
        DB::transaction(function () use ($id, $data) {
            $dash = DashboardTeam::findOrFail($id);

            $oldSlug = $dash->slug;
            $newSlug = Str::slug($data['name']);

            $dash->update([
                'name'      => $data['name'],
                'slug'      => $newSlug,
                'is_active' => $data['status'] === 'ativo',
            ]);

            if ($oldSlug !== $newSlug) {
                $this->permissionsService->updateDashboardPermission($oldSlug, $newSlug);
            }
        });
    }

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
                'slug'    => (string) $team->slug,
                'name' => $team->name,
                'color' => 'text-emerald-400',
            ];
        })->values();
    }

    public function getDashboard(GetDashRequest $getDashRequest): Collection
    {
        return DashboardTeam::all();
    }

    public function getDashboardDataBySlug(string $slug): array
    {
        $team = DashboardTeam::where('slug', $slug)->firstOrFail();

        $snapshots = $team->snapshots()
            ->whereDate('recorded_at', Carbon::today())
            ->orderBy('recorded_at', 'asc')
            ->get();

        $history = $snapshots->map(function ($s, $index) use ($snapshots) {
            if ($index === 0) {
                return [
                    'dateTime' => $s->recorded_at->format('H:i'),
                    'atendimentosResolvidos' => $s->resolvidas,
                    'atendimentosPendentes' => $s->pendentes
                ];
            }

            $previous = $snapshots[$index - 1];

            return [
                'dateTime' => $s->recorded_at->format('H:i'),
                'atendimentosResolvidos' => max(0, $s->resolvidas - $previous->resolvidas),
                'atendimentosPendentes' => max(0, $s->pendentes - $previous->pendentes)
            ];
        });

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
