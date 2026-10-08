<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            Schema::hasTable('padron_curriculum_experiencias_electorales') &&
            ! Schema::hasColumn('padron_curriculum_experiencias_electorales', 'periodo_ee')
        ) {
            Schema::table('padron_curriculum_experiencias_electorales', function (Blueprint $table) {
                $table->string('periodo_ee', 50)
                    ->nullable()
                    ->default(null)
                    ->after('id_periodo_ee');
            });
        }
    }

    public function down(): void
    {
        if (
            Schema::hasTable('padron_curriculum_experiencias_electorales') &&
            Schema::hasColumn('padron_curriculum_experiencias_electorales', 'periodo_ee')
        ) {
            Schema::table('padron_curriculum_experiencias_electorales', function (Blueprint $table) {
                $table->dropColumn('periodo_ee');
            });
        }
    }
};
