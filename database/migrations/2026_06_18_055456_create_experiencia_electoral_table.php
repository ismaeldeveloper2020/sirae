<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
public function up(): void
{
Schema::create('padron_curriculum_experiencias_electorales', function(Blueprint $table){
$table->id();
$table->unsignedBigInteger('user_id')->nullable();
$table->unsignedBigInteger('id_cargo_ee')->nullable();
$table->string('descripcion_otro_cargo_ee',100)->nullable();
$table->unsignedBigInteger('id_institucion_ee')->nullable();
$table->string('descripcion_otro_institucion_ee',100)->nullable();
$table->unsignedBigInteger('id_periodo_ee')->nullable();
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
Schema::dropIfExists('padron_curriculum_experiencias_electorales');
}
};
