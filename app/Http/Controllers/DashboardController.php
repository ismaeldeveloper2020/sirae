<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
   public function index()
    {
        if (auth()->user()->hasRole('Aspirante')) {
            return $this->dashboardAspirante();
        }
        return $this->dashboardAdministrador();
    }
    protected function dashboardAspirante()
    {
        return view('Aspirantes.dashboard');
    }
    protected function dashboardAdministrador()
    {
        $estadisticas = $this->estadisticas();
        return view(
            'dashboard',
            $estadisticas
        );
    }
    public function estadisticas()
    {
        // TOTAL REGISTROS
        $total = DB::table('padron_generales')
            ->whereNull('deleted_at')
            ->count();
        // ESTADOS DEL PROCESO
        $conRequerimientoTotal = DB::table('padron_aspirantes_modulos')
            ->whereNull('deleted_at')
            ->whereIn('modulo_registro', [2, 4])
            ->count();
        $designadosTotal = DB::table('padron_generales')
            ->whereNull('deleted_at')
            ->where('designado', 1)
            ->count();
        /*$designadosTotal = DB::table('padron_generales')
            ->whereNull('deleted_at')
            ->selectRaw("
                SUM(CASE WHEN designado = 1 THEN 1 ELSE 0 END) as designados,
                SUM(CASE WHEN designado = 0 OR designado IS NULL THEN 1 ELSE 0 END) as no_designados
            ")
            ->first();*/

        $validadosTotal = DB::table('padron_aspirantes_modulos')
            ->whereNull('deleted_at')
            ->where('modulo_registro', 5)
            ->count();

        // REGISTROS POR SEXO
        $sexos = DB::table('padron_generales')
            ->whereNull('deleted_at')
            ->select(
                DB::raw("
                    CASE
                        WHEN id_genero = 1 THEN 'Hombre'
                        WHEN id_genero = 2 THEN 'Mujer'
                        WHEN id_genero = 3 THEN 'No Binario'
                        ELSE 'Sin especificar'
                    END as genero
                "),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('id_genero')
            ->get();
            
        // DISTRITOS
        $distritos = DB::table('cat_distritos_municipios as dm')
            ->join('cat_municipios as m', 'm.id_municipio', '=', 'dm.id_municipio')
            ->leftJoin('padron_generales as p', function ($join) {
                $join->on('dm.id_distrito', '=', 'p.id_distrital')
                    ->whereNull('p.deleted_at');
            })
            ->where('dm.cabecera_distrital', 1)
            ->select(
                'dm.id_distrito',
                'm.municipio_local',
                DB::raw('COUNT(DISTINCT p.id) as total'),
                DB::raw("COUNT(DISTINCT CASE WHEN p.id_genero = 1 THEN p.id END) as hombres"),
                DB::raw("COUNT(DISTINCT CASE WHEN p.id_genero = 2 THEN p.id END) as mujeres"),
                DB::raw("COUNT(DISTINCT CASE WHEN p.id_genero = 3 THEN p.id END) as no_binarios")
            )
            ->groupBy(
                'dm.id_distrito',
                'm.municipio_local'
            )
            ->orderBy('dm.id_distrito')
            ->get();


        // MUNICIPIOS
        $municipios = DB::table('cat_municipios as m')
            ->leftJoinSub(
                DB::table('padron_generales as p')
                    ->whereNull('p.deleted_at')
                    ->select(
                        'p.id_municipal',
                        DB::raw('COUNT(p.id) as total'),
                        DB::raw("SUM(CASE WHEN p.id_genero = 1 THEN 1 ELSE 0 END) as hombres"),
                        DB::raw("SUM(CASE WHEN p.id_genero = 2 THEN 1 ELSE 0 END) as mujeres"),
                        DB::raw("SUM(CASE WHEN p.id_genero = 3 THEN 1 ELSE 0 END) as no_binarios")
                    )
                    ->groupBy('p.id_municipal'),
                'padron',
                'padron.id_municipal',
                '=',
                'm.id_municipio'
            )
            ->leftJoinSub(
                DB::table('cat_distritos_municipios')
                    ->select(
                        'id_municipio',
                        DB::raw('MIN(id_distrito) as id_distrito')
                    )
                    ->groupBy('id_municipio'),
                'dm',
                'dm.id_municipio',
                '=',
                'm.id_municipio'
            )
            ->where('m.id_municipio', '!=', '064')
            ->select(
                'dm.id_distrito',
                'm.id_municipio',
                'm.municipio_local',
                DB::raw('COALESCE(padron.total, 0) as total'),
                DB::raw('COALESCE(padron.hombres, 0) as hombres'),
                DB::raw('COALESCE(padron.mujeres, 0) as mujeres'),
                DB::raw('COALESCE(padron.no_binarios, 0) as no_binarios')
            )
            ->orderBy('dm.id_distrito')
            ->orderBy('m.municipio_local')
            ->get();



        // DISTRITO POR SEXO
        $distritoSexo = DB::table('padron_generales')
            ->join(
                'cat_distritos_municipios',
                'cat_distritos_municipios.id_distrito',
                '=',
                'padron_generales.id_distrital'
            )
            ->select(
                'cat_distritos_municipios.id_distrito',
                'genero',
                DB::raw('COUNT(*) as total')
            )
            ->whereNull('padron_generales.deleted_at')
            ->groupBy(
                'cat_distritos_municipios.id_distrito',
                'genero'
            )
            ->get();

        // MUNICIPIO POR SEXO
        $municipioSexo = DB::table('padron_generales')
            ->join(
                'cat_municipios',
                'cat_municipios.id_municipio',
                '=',
                'padron_generales.id_municipal'
            )
            ->select(
                'cat_municipios.municipio_local',
                'genero',
                DB::raw('COUNT(*) as total')
            )
            ->whereNull('padron_generales.deleted_at')
            ->groupBy(
                'cat_municipios.municipio_local',
                'genero'
            )
            ->get();

            $hombres = optional($sexos->firstWhere('genero', 'Hombre'))->total ?? 0;
            $mujeres = optional($sexos->firstWhere('genero', 'Mujer'))->total ?? 0;
            $noBinario = optional($sexos->firstWhere('genero', 'No Binario'))->total ?? 0;


        return compact(
            'total',
            'validadosTotal',
            'designadosTotal',
            'conRequerimientoTotal',
            'sexos',
            'hombres',
            'mujeres',
            'noBinario',
            'distritos',
            'municipios',
            'distritoSexo',
            'municipioSexo'
        );
    }
}
