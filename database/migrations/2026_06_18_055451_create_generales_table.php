<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

public function up(): void
{


Schema::create('padron_generales', function (Blueprint $table) {

    $table->id();
    $table->unsignedBigInteger('user_id')->nullable();
    $table->string('folio')->nullable();

    // Ubicación registro

    $table->unsignedBigInteger('id_tipo_cargo')->nullable();
    $table->unsignedBigInteger('id_distrital')->nullable();
    $table->unsignedBigInteger('id_municipal')->nullable();


    // Datos personales

    $table->string('nombre')->nullable();
    $table->string('apaterno')->nullable();
    $table->string('amaterno')->nullable();

    $table->string('rfc',20)->nullable();
    $table->string('homoclave',5)->nullable();

    $table->string('curp',20)->nullable();


    $table->unsignedBigInteger('id_discapacidad')->nullable();
    $table->unsignedBigInteger('id_genero')->nullable();


    $table->string('telefono_casa',20)->nullable();
    $table->string('telefono_movil',20)->nullable();


    $table->unsignedBigInteger('id_tipo_licencia')->nullable();


    $table->unsignedBigInteger('id_etnia')->nullable();

    $table->unsignedBigInteger('id_idioma_predominante')->nullable();

    $table->unsignedBigInteger('id_otro_idioma')->nullable();

    $table->string('especifique_idioma')->nullable();


    $table->string('ocupacion_actual')->nullable();


    $table->string('clave_elector',30)->nullable();



    // Datos calculados

    $table->date('fecha_nacimiento')->nullable();

    $table->string('genero')->nullable();

    $table->integer('edad')->nullable();



    // domicilio


    $table->string('calle')->nullable();

    $table->string('num_casa_exterior')->nullable();

    $table->string('num_casa_interior')->nullable();

    $table->string('colonia')->nullable();

    $table->string('cp',5)->nullable();



    $table->unsignedBigInteger('id_estado')->nullable();

    $table->unsignedBigInteger('id_municipio')->nullable();

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


    Schema::dropIfExists('padron_generales');


}

};