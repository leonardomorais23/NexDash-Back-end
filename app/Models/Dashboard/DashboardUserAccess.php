<?php

namespace App\Models\Dashboard;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardUserAccess extends Model
{
    use HasFactory;

    protected $table = 'dashboard_user_access';

    protected $fillable = ['user_id', 'dashboard_team_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dashboardTeam()
    {
        return $this->belongsTo(DashboardTeam::class, 'dashboard_team_id');
    }
}
