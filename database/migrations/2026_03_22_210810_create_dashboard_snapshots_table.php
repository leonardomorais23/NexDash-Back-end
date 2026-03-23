<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('dashboard_snapshots', function (Blueprint $table) {
            $table->id();

            $table->foreignId('dashboard_team_id')
                ->constrained('dashboard_teams')
                ->onDelete('cascade');

            $table->integer('pendentes');
            $table->integer('abertas');
            $table->integer('resolvidas');
            $table->integer('total_volume');

            $table->integer('tempo_resolucao_min');
            $table->integer('tempo_espera_min');
            $table->integer('tempo_primeira_resp_min');

            $table->timestamp('recorded_at')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dashboard_snapshots');
    }
};
