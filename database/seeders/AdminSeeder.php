<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles
        $superAdminRole = Role::firstOrCreate([
            'name' => 'SuperAdmin'
        ]);

        $adminRole = Role::firstOrCreate([
            'name' => 'Admin'
        ]);

        // Usuario SuperAdmin
        $superAdmin = User::firstOrCreate(
            [
                'email' => 'isc.ipp@gmail.com'
            ],
            [
                'nombre' => 'Super Administrador',
                'apaterno' => 'del',
                'amaterno' => 'Sistema',
                'password' => Hash::make('1234567890'),
            ]
        );

        $superAdmin->syncRoles(['SuperAdmin']);

        // Usuario Admin
        $admin = User::firstOrCreate(
            [
                'email' => 'admin@sistema.com'
            ],
            [
                'nombre' => 'Administrador',
                'apaterno' => 'del',
                'amaterno' => 'Sistema',
                'password' => Hash::make('1234567890'),
            ]
        );

        $admin->syncRoles(['Admin']);
    }
}