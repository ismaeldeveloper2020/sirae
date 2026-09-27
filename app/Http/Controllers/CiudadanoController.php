<?php

namespace App\Http\Controllers;

use App\Models\Ciudadano;
use Illuminate\Http\Request;

class CiudadanoController extends Controller
{
    /**
     * Store a new ciudadano registration.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        $user = $request->user();

        // Attach user_id if authenticated
        if ($user) {
            $data['user_id'] = $user->id;

            // Optionally ensure the user has the Aspirante role
            if (method_exists($user, 'assignRole') && ! $user->hasRole('Aspirante')) {
                $user->assignRole('Aspirante');
            }
        }

        // Create or update ciudadano by email
        $ciudadano = Ciudadano::updateOrCreate(
            ['email' => $data['email']],
            $data
        );

        return redirect()->route('dashboard')->with('status', 'Registro aspirante guardado correctamente.');
    }
}
