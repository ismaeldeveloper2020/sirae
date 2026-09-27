<?php

namespace App\Livewire\Organizaciones;

use Livewire\Component;

use App\Models\Organizacion;

class Index extends Component
{
    public $nombre;

    protected $rules = [
        'nombre' => 'required|string|max:255',
    ];

    public function create()
    {
        $this->validate();
        Organizacion::create(['nombre' => $this->nombre]);
        $this->reset('nombre');
        session()->flash('status', 'Organización creada.');
    }

    public function delete($id)
    {
        $org = Organizacion::find($id);
        if ($org) {
            $org->delete();
            session()->flash('status', 'Organización eliminada.');
        }
    }

    public function render()
    {
        $organizaciones = Organizacion::orderBy('id', 'desc')->get();
        return view('livewire.organizaciones.index', compact('organizaciones'));
    }
}
