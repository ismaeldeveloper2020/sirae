<?php
namespace App\Livewire\Usuarios;
use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Aspirantes\Generales;


class Index extends Component
{
    public $user_id;
    public $nombre;
    public $apaterno;
    public $amaterno;
    public $email;
  public $id_rol;
    public $password;
    public $password_confirmation;
    public $role;
    public $modal = false;

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'apaterno' => 'required|string|max:255',
        'amaterno' => 'nullable|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required|string|min:8',
        'id_rol' => 'required||not_in:0|integer',
    ];
    protected $messages = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
        'apaterno.required' => 'El primer apellido es obligatorio.',
        'apaterno.max' => 'El primer apellido no puede exceder 255 caracteres.',
        'amaterno.max' => 'El segundo apellido no puede exceder 255 caracteres.',
        'email.required' => 'El correo electrónico es obligatorio.',
        'email.email' => 'El correo electrónico no es válido.',
        'email.max' => 'El correo electrónico no puede exceder 255 caracteres.',
        'password.required' => 'La contraseña es obligatoria.',
        'password.min' => 'La contraseña debe contener al menos 8 caracteres.',
        'password.confirmed' => 'Las contraseñas no coinciden.',
        'password_confirmation.required' => 'Confirma la contraseña.',
        'password_confirmation.min' => 'La confirmación debe contener al menos 8 caracteres.',
        'id_rol.required' => 'Seleccione un rol.',
        'id_rol.not_in' => 'Seleccione un rol válido.',
        'id_rol.integer' => 'Seleccione un rol válido.'
    ];

    public function abrirModal()
    {
        $this->reset();
        $this->modal = true;
        $this->dispatch('abrirModal');
    }
    public function cerrarModal()
    {
        $this->modal=false;
        $this->reset();
        $this->dispatch('cerrarModal');
    }
    public function guardar()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $role = Role::findOrFail($this->id_rol);
            if ($this->user_id) {
                $user = User::findOrFail($this->user_id);
                $user->update([
                    'nombre'   => $this->nombre,
                    'apaterno' => $this->apaterno,
                    'amaterno' => $this->amaterno,
                    'email'    => $this->email,
                ]);
                if (!empty($this->password)) {
                    $user->update([
                        'password' => Hash::make($this->password),
                    ]);
                }
                $user->syncRoles([$role]);
                // 🔥 Actualizar generales si existe
                Generales::where('user_id', $user->id)
                ->update([
                    'nombre'   => $this->nombre,
                    'apaterno' => $this->apaterno,
                    'amaterno' => $this->amaterno,
                ]);
            } else {
                $user = User::create([
                    'nombre'   => $this->nombre,
                    'apaterno' => $this->apaterno,
                    'amaterno' => $this->amaterno,
                    'email'    => $this->email,
                    'password' => Hash::make($this->password),
                ]);

                $user->assignRole($role);

            }
            DB::commit();
            session()->flash(
                'status',
                'Usuario guardado correctamente.'
            );
            $this->cerrarModal();
            $this->dispatch('tabla');
        } catch(\Exception $e){

            DB::rollBack();

            session()->flash(
                'error',
                $e->getMessage()
            );
        }
    }
    public function editar($id)
    {
        $user = User::with('roles')->findOrFail($id);

        $this->user_id   = $user->id;
        $this->nombre    = $user->nombre;
        $this->apaterno  = $user->apaterno;
        $this->amaterno  = $user->amaterno;
        $this->email     = $user->email;
        $this->id_rol    = optional($user->roles->first())->id;

        $this->modal = true;

        $this->dispatch('abrirModal');
    }
    public function eliminar($id)
    {
        User::find($id)?->delete();
        session()->flash(
            'status',
            'Usuario eliminado.'
        );
        $this->dispatch('tabla');
    }
    public function render()
    {
        $datos_roles = DB::table('roles')
            ->where('name', '!=', 'SuperAdmin')
            ->orderBy('id', 'asc')
            ->select('name', 'id')
            ->pluck('name', 'id')
            ->toArray();

        $datos_roles = ['0' => 'Seleccione una opción'] + $datos_roles;

        return view('livewire.usuarios.index', [
            'users' => User::whereDoesntHave('roles', function ($query) {
                    $query->where('name', 'SuperAdmin');
                })
                ->with('roles')
                ->orderBy('id', 'desc')
                ->get(),

            'roles' => $datos_roles
        ]);
    }
}