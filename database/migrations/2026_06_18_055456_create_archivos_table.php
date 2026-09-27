<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('padron_documentos', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();

            // Nombre original
            $table->string('nombre_mostrar', 255)->nullable();

            // Nombre físico guardado
            $table->string('nombre_file', 255)->nullable();

            // pdf, jpg, png
            $table->string('tipo_file', 100)->nullable();

            // tamaño en bytes
            $table->string('tamanio_file', 100)->nullable();

            // storage/padron/archivo.pdf
            $table->string('ruta_file', 255)->nullable();

            // catálogo de documentos
            $table->unsignedBigInteger('id_tipo_documento')->nullable();

            $table->boolean('validado')->default(false);

            $table->text('observacion')->nullable();

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
        Schema::dropIfExists('padron_documentos');
    }
};