<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamenPreguntasSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/examen_preguntas.sql');

        if (! is_file($path)) {
            throw new \RuntimeException('No se encontró el archivo de preguntas del examen.');
        }

        DB::unprepared((string) file_get_contents($path));
    }
}
