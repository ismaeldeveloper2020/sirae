<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
public function up(): void
{
Schema::create('padron_curriculum_datos_academicos', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id')->nullable();
    $table->unsignedBigInteger('id_nivel_estudios')->nullable();
    $table->unsignedBigInteger('id_status_nivel_estudios')->nullable();
    $table->unsignedBigInteger('id_carrera')->nullable();
    $table->string('otra_carrera',100)->nullable();
    $table->unsignedBigInteger('id_otros_estudios')->nullable();
    $table->unsignedBigInteger('id_status_otro_estudios')->nullable();
    $table->string('posgrado',200)->nullable();
    $table->string('periodo_nivel_estudios',100)->nullable();
    $table->string('periodo_otros_estudios',100)->nullable();
    $table->unsignedBigInteger('id_usuario_creo')->nullable();
    $table->unsignedBigInteger('id_usuario_modifico')->nullable();
    $table->unsignedBigInteger('id_usuario_elimino')->nullable();


    // crea created_at y updated_at
    $table->timestamps();

                // crea deleted_at
    $table->softDeletes();
});
}
public function down(): void
{
Schema::dropIfExists('pad_datos_academicos');
}
};