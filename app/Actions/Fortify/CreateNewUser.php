<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Configuraciones;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Validation\ValidationException;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Validar periodo de registro
        $config = Configuraciones::whereHas('proceso', function($q){
            $q->where('nombre', 'REGISTRO');
        })
        ->where('activo',1)
        ->first();

        if(!$config){

            throw ValidationException::withMessages([
                'email' => 'El periodo de registro no está configurado.'
            ]);

        }

        $inicio = Carbon::parse($config->fecha_inicio)
            ->setTimeFromTimeString($config->hora_inicio);

        $fin = Carbon::parse($config->fecha_termino)
            ->setTimeFromTimeString($config->hora_termino);


        if(!now()->between($inicio,$fin)){

            throw ValidationException::withMessages([
                'email' => 'El periodo de registro no se encuentra disponible.'
            ]);

        }

        Validator::make($input, [
            'nombre' => ['required', 'string', 'max:255'],
            'apaterno' => ['required', 'string', 'max:255'],
            'amaterno' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'nombre' => $input['nombre'],
            'apaterno' => $input['apaterno'],
            'amaterno' => $input['amaterno'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
        // Rol Aspirante
        $user->assignRole(5);
        return $user;
    }
}
