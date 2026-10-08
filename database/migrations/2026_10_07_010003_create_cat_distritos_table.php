<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('cat_distritos')) {
            Schema::create('cat_distritos', function (Blueprint $table) {
                $table->string('id_distrito', 11);
                $table->string('id_estado', 11);
                $table->primary('id_distrito');
                $table->index('id_estado');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cat_distritos');
    }
};
