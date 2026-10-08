<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('cat_municipios')) {
            Schema::create('cat_municipios', function (Blueprint $table) {
                $table->string('id_municipio', 11);
                $table->string('id_estado', 11);
                $table->string('municipio_local');
                $table->primary('id_municipio');
                $table->index('id_estado');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cat_municipios');
    }
};
