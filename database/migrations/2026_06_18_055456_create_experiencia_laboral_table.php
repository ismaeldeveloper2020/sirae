<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
public function up(): void
{
Schema::create('padron_curriculum_experiencias_laborales', function(Blueprint $table){
    $table->id();
    $table->unsignedBigInteger('user_id')->nullable();
    $table->string('institucion_el',100)->nullable();
    $table->string('puesto_el',100)->nullable();
    $table->unsignedBigInteger('id_giro_el')->nullable();
    $table->string('periodo_el',50)->nullable();
    $table->date('fecha_ingreso_el')->nullable();
    $table->date('fecha_termino_el')->nullable();
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
Schema::dropIfExists('padron_curriculum_experiencias_laborales');
}
};
