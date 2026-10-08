<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('cat_documentos')) {
            Schema::create('cat_documentos', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->integer('orden')->default(0);
                $table->boolean('obligatorio')->nullable()->default(true);
                $table->boolean('activo')->nullable()->default(true);
                $table->unsignedBigInteger('id_usuario_creo')->nullable();
                $table->unsignedBigInteger('id_usuario_modifico')->nullable();
                $table->unsignedBigInteger('id_usuario_elimino')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cat_documentos');
    }
};
