<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DashboardTeam extends Model
{
    protected $fillable = ['slug', 'name', 'is_active'];

    public function snapshots(): HasMany
    {
        return $this->hasMany(DashboardSnapshot::class);
    }
}
