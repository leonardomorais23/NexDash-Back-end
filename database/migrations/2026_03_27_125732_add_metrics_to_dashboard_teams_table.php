<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dashboard_teams', function (Blueprint $table) {
            $table->integer('pendentes')->default(0);
            $table->integer('abertas')->default(0);
            $table->integer('resolvidas')->default(0);
            $table->integer('total_volume')->default(0);
            $table->integer('tempo_espera_min')->default(0);
            $table->integer('tempo_primeira_resp_min')->default(0);
            $table->integer('tempo_resolucao_min')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dashboard_teams', function (Blueprint $table) {
        });
    }
};
