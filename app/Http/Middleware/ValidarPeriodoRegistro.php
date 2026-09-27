<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Configuraciones;
use Carbon\Carbon;

class ValidarPeriodoRegistro
{
    public function handle(Request $request, Closure $next)
    {

        $config = Configuraciones::whereHas('proceso', function($q){

            $q->where('nombre','REGISTRO');

        })
        ->where('activo',1)
        ->first();


        if(!$config){

            return redirect()
                ->route('login')
                ->with('status','El registro no está configurado.');

        }


        $inicio = Carbon::parse(
            $config->fecha_inicio.' '.$config->hora_inicio
        );


        $fin = Carbon::parse(
            $config->fecha_termino.' '.$config->hora_termino
        );


        if(!now()->between($inicio,$fin)){

            return redirect()
                ->route('login')
                ->with(
                    'status',
                    'El periodo de registro no está disponible.'
                );

        }


        return $next($request);

    }
}