<?php

namespace App\Livewire\Perfiles;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Index extends Component
{
    public $nombre;
    public $apaterno;
    public $amaterno;
    public $email;
    public $rol;

    public $password;
    public $password_confirmation;

    protected $rules = [
        'password' => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required|string|min:8',
    ];

    protected $messages = [
        'password.required' => 'La contraseña es obligatoria.',
        'password.min' => 'La contraseña debe contener al menos 8 caracteres.',
        'password.confirmed' => 'Las contraseñas no coinciden.',
        'password_confirmation.required' => 'Confirma la contraseña.',
        'password_confirmation.min' => 'La confirmación debe contener al menos 8 caracteres.',
    ];

    public function mount()
    {
        $user = Auth::user();

        $this->nombre = $user->nombre;
        $this->apaterno = $user->apaterno;
        $this->amaterno = $user->amaterno;
        $this->email = $user->email;

        $this->rol = $user->roles->first()?->name ?? 'Sin rol asignado';
    }

    public function actualizarPassword()
    {
        $this->validate();

        $user = Auth::user();

        $user->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset([
            'password',
            'password_confirmation',
        ]);

        session()->flash(
            'status',
            'Contraseña actualizada correctamente.'
        );
    }

    public function render()
    {
        return view('livewire.perfiles.index');
    }
}