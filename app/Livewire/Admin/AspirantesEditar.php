<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.admin')]
class AspirantesEditar extends Component
{
    public $user_id;

    public bool $loadCurriculum = false;
    public bool $loadArchivos = false;

    public function mount($user_id)
    {
        $this->user_id = $user_id;
    }

    #[On('load-curriculum')]
    public function loadCurriculum()
    {
        $this->loadCurriculum = true;
    }

    #[On('load-archivos')]
    public function loadArchivos()
    {
        $this->loadArchivos = true;
    }

    public function render()
    {
        return view('livewire.admin.aspirantes-editar', [
            'user' => User::findOrFail($this->user_id)
        ]);
    }
}