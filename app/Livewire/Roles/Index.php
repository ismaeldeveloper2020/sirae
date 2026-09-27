<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    public $name;

    protected $rules = [
        'name' => 'required|string|max:255|unique:roles,name',
    ];

    public function createRole()
    {
        $this->validate();
        Role::create(['name' => $this->name]);
        $this->reset('name');
        session()->flash('status', 'Rol creado correctamente.');
    }

    public function deleteRole($id)
    {
        $role = Role::findById($id);
        if ($role) {
            $role->delete();
            session()->flash('status', 'Rol eliminado.');
        }
    }

    public function render()
    {
        $roles = Role::orderBy('id', 'desc')->get();
        return view('livewire.roles.index', compact('roles'));
    }
}
