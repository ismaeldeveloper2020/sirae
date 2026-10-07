<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('cat_opciones_si_no')) {
            Schema::create('cat_opciones_si_no', function (Blueprint $table) {
                $table->integer('id', true);
                $table->string('descripcion', 200);
                $table->integer('id_usuario_creo')->nullable();
                $table->integer('id_usuario_modifico')->nullable();
                $table->integer('id_usuario_elimino')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
                $table->timestamp('deleted_at')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cat_opciones_si_no');
    }
};
