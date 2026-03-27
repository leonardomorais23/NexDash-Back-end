<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DashboardTeam extends Model
{
    protected $fillable = [
        'slug', 'name', 'is_active',
        'pendentes', 'abertas', 'resolvidas',
        'total_volume', 'tempo_espera_min',
        'tempo_primeira_resp_min', 'tempo_resolucao_min'
    ];

    public function snapshots(): HasMany
    {
        return $this->hasMany(DashboardSnapshot::class);
    }
}
