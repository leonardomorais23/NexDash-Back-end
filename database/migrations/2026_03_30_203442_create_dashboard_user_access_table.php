<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dashboard_user_access', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('dashboard_team_id')->constrained('dashboard_teams')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'dashboard_team_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dashboard_user_access');
    }
};
