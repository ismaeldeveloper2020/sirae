<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('cat_distritos_municipios')) {
            Schema::create('cat_distritos_municipios', function (Blueprint $table) {
                $table->string('id_distrito', 20);
                $table->string('id_municipio', 11);
                $table->boolean('cabecera_distrital');
                $table->primary(['id_distrito', 'id_municipio']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cat_distritos_municipios');
    }
};
