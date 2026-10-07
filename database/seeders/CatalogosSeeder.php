<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogosSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $this->seedSimpleCatalogs();
            $this->seedGeographicCatalogs();
            $this->seedProcessCatalogs();
            $this->seedDocumentCatalog();
        });
    }

    private function seedSimpleCatalogs(): void
    {
        $catalogs = [
            'cat_cargos_ocupados' => [
                'Capturista en Consejo Distrital o Municipal Electoral del IEPC',
                'Consejería distrital electoral del INE',
                'Consejería distrital electoral del IEPC',
                'Consejería distrital electoral suplente del INE',
                'Consejería distrital electoral suplente del IEPC',
                'Consejería local electoral del INE',
                'Consejería local electoral suplente del INE',
                'Consejería municipal electoral del IEPC',
                'Consejería municipal electoral suplente del IEPC',
                'Enlace distrital electoral',
                'Enlace municipal electoral',
                'Persona capacitadora asistente electoral',
                'Persona escrutadora de Mesa Directiva de Casilla',
                'Persona observadora electoral',
                'Persona supervisora electoral',
                'Presidencia de Consejo Distrital Electoral del IEPC',
                'Presidencia de Mesa Directiva de Casilla',
                'Presidencia del Consejo Municipal Electoral del IEPC',
                'Secretaría de Mesa Directiva de Casilla',
                'Secretaría Técnica del Consejo Distrital Electoral del IEPC',
                'Secretaría Técnica del Consejo Municipal Electoral del IEPC',
                'Otro',
            ],
            'cat_cargos_tipos' => ['Distrital', 'Municipal'],
            'cat_carreras' => [
                'Contaduría pública',
                'Administración',
                'Derecho',
                'Médico cirujano',
                'Ingeniería en sistemas computacionales',
                'Ciencias de la educación',
                'Odontología',
                'Nutriología',
                'Otro',
            ],
            'cat_conocimientos_electorales' => [
                'Curso', 'Diplomado', 'Especialidad', 'Taller', 'Maestría',
                'Doctorado', 'Foro', 'Congreso', 'Otro',
            ],
            'cat_discapacidades' => [
                'Ninguna', 'Física', 'Intelectual', 'Mental', 'Psicosocial',
                'Múltiple', 'Sensorial', 'Auditiva', 'Visual',
            ],
            'cat_ejercicios' => ['2026', '2027', '2028', '2029', '2030'],
            'cat_estatus_nivel_estudios' => ['Concluido', 'En proceso', 'Trunco'],
            'cat_estudios_posgrados' => ['Especialidad', 'Maestría', 'Doctorado', 'Ninguno'],
            'cat_etnias' => [
                'Tsotsil', 'Chol', 'Tseltal', 'Zoque', 'Tojolabal', 'Mame',
                'Kakchiquel', 'Lacandón', 'Mocho', 'Jacalteco', 'Chuj',
                'Kanjobal', 'Ninguna',
            ],
            'cat_generos' => ['Hombre', 'Mujer', 'No Binario'],
            'cat_giros' => ['Pública', 'Privada'],
            'cat_idiomas' => [
                'Español', 'Tsotsil', 'Tseltal', 'Zoque', 'Tojolabal', 'Mame',
                'Kakchiquel', 'Lacandón', 'Mocho', 'Jacalteco', 'Chuj',
                'Kanjobal', 'Chol', 'Otra', 'Ninguna',
            ],
            'cat_institutos' => [
                'Fiscalía de Delitos Electorales del Estado Chiapas',
                'Fiscalía Especializada en materia de Delitos Electorales (FISEL)',
                'Instituto de Elecciones y Participación Ciudadana de Chiapas (IEPC)',
                'Instituto Nacional Electoral (INE)',
                'Partido político',
                'Tribunal Electoral del Estado de Chiapas (TEECH)',
                'Tribunal Electoral del Poder Judicial de la Federación (TEPJF)',
                'Otro',
            ],
            'cat_nivel_estudios' => ['Sin estudios', 'Primaria', 'Secundaria', 'Bachillerato', 'Licenciatura'],
            'cat_opciones_si_no' => ['SI', 'No'],
            'cat_periodos' => [
                'PROCESO ELECTORAL LOCAL 1994',
                'PROCESO ELECTORAL LOCAL 1995',
                'PROCESO ELECTORAL LOCAL 1998',
                'PROCESO ELECTORAL LOCAL 2000',
                'PROCESO ELECTORAL LOCAL 2001',
                'PROCESO ELECTORAL LOCAL 2004',
                'PROCESO ELECTORAL LOCAL 2006',
                'PROCESO ELECTORAL LOCAL 2007',
                'PROCESO ELECTORAL LOCAL 2010',
                'PROCESO ELECTORAL LOCAL 2012',
                'PROCESO ELECTORAL LOCAL 2014-2015',
                'PROCESO ELECTORAL LOCAL 2015-2016',
                'PROCESO ELECTORAL LOCAL 2017-2018',
                'PROCESO ELECTORAL LOCAL EXTRAORDINARIO 2018',
                'PROCESO ELECTORAL LOCAL ORDINARIO 2021',
                'PROCESO ELECTORAL LOCAL EXTRAORDINARIO 2022',
                'PROCESO ELECTORAL FEDERAL 1991',
                'PROCESO ELECTORAL FEDERAL 1994',
                'PROCESO ELECTORAL FEDERAL 1997',
                'PROCESO ELECTORAL FEDERAL 2000',
                'PROCESO ELECTORAL FEDERAL 2003',
                'PROCESO ELECTORAL FEDERAL 2006',
                'PROCESO ELECTORAL FEDERAL 2009',
                'PROCESO ELECTORAL FEDERAL 2012',
                'PROCESO ELECTORAL FEDERAL 2014-2015',
                'PROCESO ELECTORAL FEDERAL 2017-2018',
                'PROCESO ELECTORAL FEDERAL ORDINARIO 2020-2021',
            ],
            'cat_tipo_documentos' => [
                'Acta de nacimiento',
                'Credencial para votar (INE)',
                'Comprobante de domicilio',
                'Constancia del último grado de estudios',
                'Clave Única de Regitro de Población (CURP)',
                'Declaración bajo protesta de decir verdad',
                'Constancia o carta compromiso de situación fiscal',
                'Conocimiento electoral',
                'Experiencia electoral',
                'Experiencia docente',
                'Licencia de conducir',
            ],
            'cat_tipo_licencias' => ['Ninguna', 'Automovilista', 'Chofer', 'Motociclista'],
            'cat_tipos_asistencias' => ['Estudiante', 'Asistente', 'Docente', 'Ponente'],
        ];

        foreach ($catalogs as $table => $descriptions) {
            $rows = [];

            foreach ($descriptions as $id => $descripcion) {
                $rows[] = [
                    'id' => $id + 1,
                    'descripcion' => $descripcion,
                ];
            }

            DB::table($table)->upsert($rows, ['id'], ['descripcion']);
        }

        DB::table('cat_idiomas')
            ->where('id', 15)
            ->update(['deleted_at' => '2026-09-04 22:42:35']);
    }

    private function seedGeographicCatalogs(): void
    {
        DB::table('cat_estados')->upsert([
            ['id_estado' => '07', 'nombre' => 'Chiapas'],
        ], ['id_estado'], ['nombre']);

        $municipios = [
            '001|Acacoyagua', '002|Acala', '003|Acapetahua', '004|Altamirano',
            '005|Amatán', '006|Amatenango De La Frontera', '007|Amatenango Del Valle',
            '008|Ángel Albino Corzo', '009|Arriaga', '010|Bejucal De Ocampo',
            '011|Bella Vista', '012|Berriozabal', '013|Bochil', '014|El Bosque',
            '015|Cacahoatán', '016|Catazajá', '017|Cintalapa', '018|Coapilla',
            '019|Comitán De Domínguez', '020|La Concordia', '021|Copainalá',
            '022|Chalchihuitán', '023|Chamula', '024|Chanal', '025|Chapultenango',
            '026|Chenalhó', '027|Chiapa De Corzo', '028|Chiapilla', '029|Chicoasén',
            '030|Chicomuselo', '031|Chilón', '032|Escuintla', '033|Francisco León',
            '034|Frontera Comalapa', '035|Frontera Hidalgo', '036|La Grandeza',
            '037|Huehuetán', '038|Huitiupán', '039|Huixtán', '040|Huixtla',
            '041|La Independencia', '042|Ixhuatán', '043|Ixtacomitán', '044|Ixtapa',
            '045|Ixtapangajoya', '046|Jiquipilas', '047|Jitotol', '048|Juárez',
            '049|Larráinzar', '050|La Libertad', '051|Mapastepec', '052|Las Margaritas',
            '053|Mazapa De Madero', '054|Mazatán', '055|Metapa', '056|Mitontic',
            '057|Motozintla', '058|Nicolás Ruiz', '059|Ocosingo', '060|Ocotepec',
            '061|Ocozocoautla De Espinosa', '062|Ostuacán', '063|Osumacinta',
            '064|Oxchuc', '065|Palenque', '066|Pantelhó', '067|Pantepec',
            '068|Pichucalco', '069|Pijijiapan', '070|El Porvenir',
            '071|Pueblo Nuevo Solistahuacán', '072|Rayón', '073|Reforma', '074|Las Rosas',
            '075|Sabanilla', '076|Salto De Agua', '077|San Cristóbal De Las Casas',
            '078|San Fernando', '079|San Juan Cancuc', '080|San Lucas', '081|Siltepec',
            '082|Simojovel', '083|Sitalá', '084|Socoltenango', '085|Solosuchiapa',
            '086|Soyaló', '087|Suchiapa', '088|Suchiate', '089|Sunuapa',
            '090|Tapachula', '091|Tapalapa', '092|Tapilula', '093|Tecpatán',
            '094|Tenejapa', '095|Teopisca', '096|Tila', '097|Tonalá', '098|Totolapa',
            '099|La Trinitaria', '100|Tumbalá', '101|Tuxtla Chico', '102|Tuxtla Gutiérrez',
            '103|Tuzantán', '104|Tzimol', '105|Unión Juárez', '106|Venustiano Carranza',
            '107|Villa Comaltitlán', '108|Villa Corzo', '109|Villaflores', '110|Yajalón',
            '111|Zinacantán', '112|Aldama', '113|Benemérito De Las Américas',
            '114|Maravilla Tenejapa', '115|Marqués De Comillas', '116|Montecristo De Guerrero',
            '117|San Andrés Duraznal', '118|Santiago El Pinar', '119|Capitán Luis Ángel Vidal',
            '120|Rincón Chamula San Pedro', '121|El Parral', '122|Emiliano Zapata',
            '123|Mezcalapa', '124|Honduras De La Sierra',
        ];

        DB::table('cat_municipios')->upsert(
            array_map(static function (string $municipio): array {
                [$id, $nombre] = explode('|', $municipio, 2);

                return [
                    'id_municipio' => $id,
                    'id_estado' => '07',
                    'municipio_local' => $nombre,
                ];
            }, $municipios),
            ['id_municipio'],
            ['id_estado', 'municipio_local']
        );

        DB::table('cat_distritos')->upsert(
            array_map(static fn (int $id): array => [
                'id_distrito' => str_pad((string) $id, 2, '0', STR_PAD_LEFT),
                'id_estado' => '07',
            ], range(1, 24)),
            ['id_distrito'],
            ['id_estado']
        );

        $relaciones = [
            '01|102|1',
            '02|012|0', '02|029|0', '02|063|0', '02|078|0', '02|102|1',
            '03|002|0', '03|027|1', '03|028|0', '03|044|0', '03|080|0', '03|087|0', '03|098|0', '03|122|0',
            '04|066|0', '04|075|0', '04|096|0', '04|100|0', '04|110|1',
            '05|077|1',
            '06|019|1', '06|074|0', '06|084|0', '06|104|0',
            '07|059|1', '07|113|0', '07|115|0',
            '08|014|0', '08|022|0', '08|026|0', '08|038|0', '08|049|0', '08|082|1', '08|112|0', '08|118|0',
            '09|016|0', '09|050|0', '09|065|1', '09|076|0',
            '10|011|0', '10|030|0', '10|034|0', '10|099|1',
            '11|005|0', '11|013|1', '11|018|0', '11|042|0', '11|047|0', '11|060|0', '11|067|0', '11|071|0', '11|072|0', '11|086|0', '11|091|0', '11|092|0', '11|117|0', '11|120|0',
            '12|021|0', '12|025|0', '12|033|0', '12|043|0', '12|045|0', '12|048|0', '12|062|0', '12|068|1', '12|073|0', '12|085|0', '12|089|0', '12|093|0', '12|123|0',
            '13|102|1',
            '14|017|1', '14|046|0', '14|061|0',
            '15|001|0', '15|009|0', '15|051|0', '15|069|0', '15|097|1',
            '16|003|0', '16|032|0', '16|037|0', '16|040|1', '16|054|0', '16|103|0', '16|107|0',
            '17|006|0', '17|008|0', '17|010|0', '17|036|0', '17|053|0', '17|057|1', '17|070|0', '17|081|0', '17|116|0', '17|119|0', '17|124|0',
            '18|015|0', '18|035|0', '18|055|0', '18|088|0', '18|090|1', '18|101|0', '18|105|0',
            '19|090|1',
            '20|004|0', '20|041|0', '20|052|1', '20|114|0',
            '21|007|0', '21|024|0', '21|039|0', '21|058|0', '21|064|0', '21|077|0', '21|095|0', '21|106|1',
            '22|023|1', '22|056|0', '22|094|0', '22|111|0',
            '23|020|0', '23|108|0', '23|109|1', '23|121|0',
            '24|031|1', '24|059|0', '24|079|0', '24|083|0',
        ];

        DB::table('cat_distritos_municipios')->upsert(
            array_map(static function (string $relacion): array {
                [$distrito, $municipio, $cabecera] = explode('|', $relacion);

                return [
                    'id_distrito' => $distrito,
                    'id_municipio' => $municipio,
                    'cabecera_distrital' => (int) $cabecera,
                ];
            }, $relaciones),
            ['id_distrito', 'id_municipio'],
            ['cabecera_distrital']
        );
    }

    private function seedProcessCatalogs(): void
    {
        DB::table('cat_procesos')->upsert([
            ['id' => 1, 'nombre' => 'REGISTRO', 'descripcion' => 'Registro de aspirantes', 'activo' => 1],
            ['id' => 2, 'nombre' => 'EXAMEN', 'descripcion' => 'Aplicación de examen', 'activo' => 1],
        ], ['id'], ['nombre', 'descripcion', 'activo']);

        DB::table('cat_configuraciones')->upsert([
            [
                'id' => 1,
                'proceso_id' => 1,
                'numero_bloque' => null,
                'descripcion' => 'Periodo de registro de aspirantes para el proceso local ordinario 2027',
                'fecha_inicio' => '2026-08-01',
                'hora_inicio' => '09:00:00',
                'fecha_termino' => '2026-09-20',
                'hora_termino' => '23:59:59',
                'activo' => 1,
            ],
            [
                'id' => 2,
                'proceso_id' => 2,
                'numero_bloque' => 1,
                'descripcion' => 'Examen de conocimientos para el proceso local ordinario 2027',
                'fecha_inicio' => '2026-08-18',
                'hora_inicio' => '12:00:00',
                'fecha_termino' => '2026-08-18',
                'hora_termino' => '16:00:00',
                'activo' => 1,
            ],
            [
                'id' => 3,
                'proceso_id' => 2,
                'numero_bloque' => 1,
                'descripcion' => 'Primer bloque de examen para el proceso local ordinario 2027',
                'fecha_inicio' => '2026-08-10',
                'hora_inicio' => '09:00:00',
                'fecha_termino' => '2026-08-10',
                'hora_termino' => '12:00:00',
                'activo' => 0,
            ],
            [
                'id' => 4,
                'proceso_id' => 2,
                'numero_bloque' => 2,
                'descripcion' => 'Segundo bloque de examen para el proceso local ordinario 2027',
                'fecha_inicio' => '2026-08-10',
                'hora_inicio' => '15:00:00',
                'fecha_termino' => '2026-08-10',
                'hora_termino' => '18:00:00',
                'activo' => 0,
            ],
        ], ['id'], [
            'proceso_id', 'numero_bloque', 'descripcion', 'fecha_inicio',
            'hora_inicio', 'fecha_termino', 'hora_termino', 'activo',
        ]);
    }

    private function seedDocumentCatalog(): void
    {
        DB::table('cat_documentos')->upsert([
            ['id' => 1, 'nombre' => 'Acta de nacimiento', 'orden' => 1, 'obligatorio' => 1, 'activo' => 1],
            ['id' => 2, 'nombre' => 'Constancia de estudios, título y/o cédula profesional', 'orden' => 2, 'obligatorio' => 1, 'activo' => 1],
            ['id' => 3, 'nombre' => 'Constancia o carta compromiso de situación fiscal', 'orden' => 3, 'obligatorio' => 1, 'activo' => 1],
            ['id' => 4, 'nombre' => 'CURP', 'orden' => 4, 'obligatorio' => 1, 'activo' => 1],
            ['id' => 5, 'nombre' => 'Credencial para Votar o comprobante de trámite', 'orden' => 5, 'obligatorio' => 1, 'activo' => 1],
            ['id' => 6, 'nombre' => 'Comprobante de domicilio', 'orden' => 6, 'obligatorio' => 1, 'activo' => 1],
            ['id' => 7, 'nombre' => 'Licencia para conducir', 'orden' => 7, 'obligatorio' => 1, 'activo' => 1],
            ['id' => 8, 'nombre' => 'Carta bajo protesta de decir verdad', 'orden' => 8, 'obligatorio' => 1, 'activo' => 1],
            ['id' => 9, 'nombre' => 'Conocimiento electoral', 'orden' => 9, 'obligatorio' => 0, 'activo' => 1],
            ['id' => 10, 'nombre' => 'Experiencia electoral', 'orden' => 10, 'obligatorio' => 0, 'activo' => 1],
            ['id' => 11, 'nombre' => 'Experiencia docente', 'orden' => 11, 'obligatorio' => 0, 'activo' => 1],
            ['id' => 12, 'nombre' => 'Experiencia laboral', 'orden' => 12, 'obligatorio' => 0, 'activo' => 1],
        ], ['id'], ['nombre', 'orden', 'obligatorio', 'activo']);
    }
}
