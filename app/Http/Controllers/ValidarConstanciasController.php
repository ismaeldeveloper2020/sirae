<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidarConstanciasController extends Controller
{
    public function validar($key)
    {
        $constancia = DB::table('padron_constancias')
            ->where('verification_key', $key)
            ->whereNull('deleted_at')
            ->first();

        if (!$constancia) {
            return response()->json([
                'valida' => false,
                'mensaje' => 'La constancia no existe o el código de validación no es válido.',
            ], 404);
        }

        if ($constancia->estatus != 1) {
            return response()->json([
                'valida' => false,
                'mensaje' => 'La constancia no se encuentra vigente.',
                'motivo' => $constancia->motivo,
                'constancia' => [
                    'folio' => $constancia->folio,
                    'nombre' => $constancia->nombre,
                ],
            ], 200);
        }

        return response()->json([
            'valida' => true,
            'mensaje' => 'La constancia es válida.',
            'constancia' => [
                'folio' => $constancia->folio,
                'nombre' => $constancia->nombre,
                'tipo_enlace' => $constancia->tipo_enlace,
                'distrito_municipio' => $constancia->distrito_municipio,
                'fecha_emision' => $constancia->fecha_emision,
                'fecha_validacion' => $constancia->fecha_validacion,
            ],
        ], 200);
    }

    public function mostrar($key)
    {
        $constancia = DB::table('padron_constancias')
            ->where('verification_key', $key)
            ->whereNull('deleted_at')
            ->first();

        if (!$constancia) {
            return view('constancias.validacion', [
                'valida' => false,
                'constancia' => null,
                'mensaje' => 'La constancia no existe o el código de validación no es válido.',
            ]);
        }

        if ($constancia->estatus != 1) {
            return view('constancias.validacion', [
                'valida' => false,
                'constancia' => $constancia,
                'mensaje' => 'La constancia no se encuentra vigente.',
            ]);
        }

        return view('constancias.validacion', [
            'valida' => true,
            'constancia' => $constancia,
            'mensaje' => 'La constancia es válida.',
        ]);
    }

}
