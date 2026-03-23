<?php


namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DashboardSnapshot extends Model {
    protected $guarded = [];
    protected $casts = ['recorded_at' => 'datetime'];

    public function team(): BelongsTo
    {
        return $this->belongsTo(DashboardTeam::class, 'dashboard_team_id');
    }

}
