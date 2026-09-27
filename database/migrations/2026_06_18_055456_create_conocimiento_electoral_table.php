<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
public function up(): void
{
Schema::create('padron_curriculum_conocimientos_electorales', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id')->nullable();
    $table->unsignedBigInteger('id_tipo_ce')->nullable();
    $table->string('otro_ce',100)->nullable();
    $table->unsignedBigInteger('id_participacion_ce')->nullable();
    $table->string('institucion_ce',100)->nullable();
    $table->string('descripcion_ce',100)->nullable();
    $table->string('periodo_ce',50)->nullable();
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
Schema::dropIfExists('pad_conocimientos_electoral');
}
};