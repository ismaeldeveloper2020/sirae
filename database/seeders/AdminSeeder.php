<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use InvalidArgumentException;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = trim((string) config('sirae.superadmin.email', 'isc.ipp@gmail.com'));
        $password = (string) config('sirae.superadmin.password', '');

        if (
            $email === '' ||
            strlen($password) < 16 ||
            ! preg_match('/[A-Z]/', $password) ||
            ! preg_match('/[a-z]/', $password) ||
            ! preg_match('/[0-9]/', $password) ||
            ! preg_match('/[^A-Za-z0-9]/', $password)
        ) {
            throw new InvalidArgumentException(
                'Configura SUPERADMIN_PASSWORD en .env con al menos 16 caracteres, mayúsculas, minúsculas, números y símbolos.'
            );
        }

        Role::firstOrCreate([
            'name' => 'SuperAdmin',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        $superAdmin = User::updateOrCreate(
            ['email' => $email],
            [
                'nombre' => 'Super Administrador',
                'apaterno' => 'del',
                'amaterno' => 'Sistema',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );

        $superAdmin->syncRoles(['SuperAdmin']);
    }
}
