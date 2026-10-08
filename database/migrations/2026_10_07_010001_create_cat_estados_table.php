<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('cat_estados')) {
            Schema::create('cat_estados', function (Blueprint $table) {
                $table->string('id_estado', 11);
                $table->string('nombre');
                $table->primary('id_estado');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cat_estados');
    }
};
