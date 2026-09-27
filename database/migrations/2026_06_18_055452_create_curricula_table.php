<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
public function up(): void
{
Schema::create('curriculums', function(Blueprint $table){
$table->id();
$table->foreignId('user_id')
->constrained('users')
->cascadeOnDelete();
$table->string('grado_academico');
$table->string('institucion')
->nullable();
$table->string('experiencia')
->nullable();
$table->text('habilidades')
->nullable();
$table->timestamps();
});
}
public function down(): void
{
Schema::dropIfExists('curriculums');
}
};