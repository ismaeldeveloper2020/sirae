<div>
     @push('styles')
    <style>
        .readonly-field {
            background-color: #e9ecef !important;
            opacity: 1 !important;
            cursor: not-allowed !important;
        }
        .btn-guardar {
            background: linear-gradient(135deg, #673AB7, #512DA8);
            border: none;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(103, 58, 183, .35);
            transition: .25s ease;
        }
        .btn-guardar:hover {
            background: linear-gradient(135deg, #512DA8, #4527A0);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(103, 58, 183, .45);
        }
        /* cuando Livewire esta procesando */
        .btn-guardar:disabled {
            background: linear-gradient(135deg, #9575CD, #7E57C2);
            color: white;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
    </style>
    @endpush
    @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
  
    <div class="card-header d-flex align-items-center w-100">
        <h5 class="mb-0">
            <i class="bi bi-people-fill me-2"></i>
            Usuarios
        </h5>
        <button 
            class="btn rounded-pill text-white ms-auto"
            style="background-color:#E22275; border-color:#E22275;"
            wire:click="abrirModal">
            <i class="bi bi-person-plus me-1"></i>
            Agregar usuario
        </button>
    </div>
    <div class="card-body">
        <table id="tablaUsuarios" class="table table-hover align-middle nowrap" style="width:100%">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th width="150">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        {{$user->id}}
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                style="width:42px;height:42px;">
                                {{ strtoupper(substr($user->nombre,0,1)) }}
                            </div>
                            {{$user->nombre}}
                            {{$user->apaterno}}
                            {{$user->amaterno}}
                        </div>
                    </td>
                    <td>
                        {{$user->email}}
                    </td>
                    <td>
                        @foreach($user->roles as $r)
                        <span class="badge bg-info">
                            {{$r->name}}
                        </span>
                        @endforeach
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm" wire:click="editar({{$user->id}})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="confirm('¿Eliminar usuario?') || event.stopImmediatePropagation()" wire:click="eliminar({{$user->id}})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- MODAL USUARIO -->
    <div class="modal fade" id="modalUsuario" tabindex="-1" wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <div class="modal-header text-white rounded-top-4"
                    style="background:linear-gradient(135deg,#E22275 ,#dd2977 );">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-person-circle me-2"></i>
                        {{ $user_id ? 'Editar usuario' : 'Nuevo usuario' }}
                    </h5>
                    <button type="button"
                            class="btn-close btn-close-white"
                            wire:click="cerrarModal">
                    </button>
                </div>
                <form wire:submit="guardar">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-12 mb-2">
                                <label class="form-label small @error('id_rol') text-danger @else text-muted @enderror">
                                    <i class="fa-solid fa-star text-muted" style="font-size:8px;"></i>
                                    Rol
                                </label>
                                <div wire:ignore>  
                                <select id="id_rol" class="form-select select2" data-model="id_rol">
                                     <option value=""></option>
                                    @foreach($roles as $key=>$value)
                                    <option value="{{ $key }}" @selected($id_rol==$key)>
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                                </div>
                                @error('id_rol')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label small @error('nombre') text-danger @else text-muted @enderror">
                                    <i class="bi bi-person me-1"></i>
                                    Nombre
                                </label>
                                <input type="text"
                                    class="form-control form-control-md rounded-3"
                                    placeholder="Nombre"
                                    wire:model="nombre">
                                @error('nombre')
                                <small class="text-danger">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label small @error('apaterno') text-danger @else text-muted @enderror">
                                    <i class="bi bi-person me-1"></i>
                                    Primer apellido
                                </label>
                                <input type="text"
                                    class="form-control form-control-md rounded-3"
                                    placeholder="Primer apellido"
                                    wire:model="apaterno">
                            @error('apaterno')
                                <small class="text-danger">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label small @error('amaterno') text-danger @else text-muted @enderror">
                                    <i class="bi bi-person me-1"></i>
                                    Segundo apellido
                                </label>
                                <input type="text"
                                    class="form-control form-control-md rounded-3"
                                    placeholder="Segundo apellido"
                                    wire:model="amaterno">
                            @error('amaterno')
                                <small class="text-danger">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label small @error('email') text-danger @else text-muted @enderror">
                                    <i class="bi bi-envelope me-1"></i>
                                    Correo
                                </label>
                                <input type="email"
                                    class="form-control form-control-md rounded-3"
                                    placeholder="correo@email.com"
                                    wire:model="email">
                                @error('email')
                                    <small class="text-danger">
                                        {{$message}}
                                    </small>
                                    @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label small @error('password') text-danger @else text-muted @enderror">
                                    <i class="bi bi-lock me-1"></i>
                                    Contraseña
                                </label>
                                <input type="password"
                                    class="form-control form-control-md rounded-3"
                                    placeholder="********"
                                    wire:model="password">
                                @error('password')
                                    <small class="text-danger">
                                        {{$message}}
                                    </small>
                                    @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label small @error('password_confirmation') text-danger @else text-muted @enderror">
                                    <i class="bi bi-lock-fill me-1"></i>
                                    Confirmar contraseña
                                </label>
                                <input type="password"
                                    class="form-control form-control-md rounded-3"
                                    placeholder="********"
                                    wire:model="password_confirmation">
                                @error('password_confirmation')
                                    <small class="text-danger">
                                        {{$message}}
                                    </small>
                                    @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light rounded-bottom-4">
                         <button type="button" 
                                class="btn btn-outline-secondary rounded-pill px-4"
                                wire:click="cerrarModal">
                            <i class="bi bi-x-circle me-1"></i>
                            Cancelar
                        </button>
                        <button type="submit" style="background-color: #E22275 !important; border-color: #fff !important;"
                                class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-save me-1"></i>
                            Guardar usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>

        document.addEventListener('livewire:init', () => {

            /*
            ==========================================================
            VARIABLE PARA CONTROLAR SELECT2
            ==========================================================
            */

            let selectsInicializados = false;


            /*
            ==========================================================
            DATATABLE
            ==========================================================
            */

            function iniciarTabla() {

                if (!$('#tablaUsuarios').length) {
                    return;
                }

                if ($.fn.DataTable.isDataTable('#tablaUsuarios')) {

                    $('#tablaUsuarios')
                        .DataTable()
                        .destroy();

                }

                $('#tablaUsuarios').DataTable({

                    responsive: true,

                    pageLength: 10,

                    language: {

                        search: "Buscar:",

                        lengthMenu: "Mostrar _MENU_ registros",

                        info: "Mostrando _START_ a _END_ de _TOTAL_",

                        infoEmpty: "Sin información",

                        zeroRecords: "Sin información",

                        paginate: {

                            previous: "Anterior",

                            next: "Siguiente"

                        }

                    }

                });

            }


            /*
            ==========================================================
            SELECT2
            SE CONSTRUYE SOLAMENTE UNA VEZ
            ==========================================================
            */

            function iniciarSelects() {

                let rol = $('#id_rol');
                // =====================================================
                // ROL
                // =====================================================

                if (
                    rol.length &&
                    !rol.hasClass('select2-hidden-accessible')
                ) {

                    rol.select2({

                        theme: 'bootstrap-5',

                        width: '100%',

                        allowClear: true,

                        placeholder: 'Seleccione una opción',

                        dropdownParent: $('#modalUsuario')

                    });


                    rol.off('change.sefech')
                        .on('change.sefech', function () {

                            let valor = $(this).val();

                            @this.set('id_rol', valor);

                        });

                }

            }

            /*
            ==========================================================
            INICIALIZAR TABLA AL CARGAR LA PÁGINA
            ==========================================================
            */

            iniciarTabla();


            /*
            ==========================================================
            ABRIR MODAL
            ==========================================================
            */
            Livewire.on('abrirModal', () => {

                let modalElement =
                    document.getElementById('modalUsuario');

                if (!modalElement) {
                    return;
                }


                let modal =
                    bootstrap.Modal.getOrCreateInstance(
                        modalElement
                    );


                modal.show();


                setTimeout(() => {

                    iniciarSelects();


                    /*
                    ==============================================
                    TOMAR LOS VALORES ACTUALES DE LIVEWIRE
                    ==============================================
                    */

                    let rol =
                        @this.get('id_rol');


                    /*
                    ==============================================
                    ACTUALIZAR VISUALMENTE SELECT2
                    SIN DISPARAR CHANGE
                    ==============================================
                    */

                    $('#id_rol')
                        .val(
                            rol ? String(rol) : '0'
                        )
                        .trigger('change.select2');
                }, 300);

            });
            /*
            ==========================================================
            CERRAR MODAL
            ==========================================================
            */

            Livewire.on('cerrarModal', () => {

                let modalElement =
                    document.getElementById('modalUsuario');

                if (!modalElement) {
                    return;
                }


                let modal =
                    bootstrap.Modal.getInstance(
                        modalElement
                    );


                if (modal) {

                    modal.hide();

                }

                setTimeout(() => {
                    iniciarTabla();
                }, 100);

            });

            /*
            ==========================================================
            CARGAR VALORES AL EDITAR
            ==========================================================
            */

            Livewire.on('cargarSelects', (data) => {

                setTimeout(() => {

                    iniciarSelects();


                    let rol =
                        data[0].rol;

                    let organizacion =
                        data[0].organizacion;


                    /*
                    ==============================================
                    CAMBIAR SOLO LA INTERFAZ DE SELECT2
                    ==============================================
                    */

                    $('#id_rol')
                        .val(
                            rol ? String(rol) : '0'
                        )
                        .trigger('change.select2');

                }, 300);

            });


            /*
            ==========================================================
            RESETEAR SELECTS
            NUEVO USUARIO
            ==========================================================
            */

            Livewire.on('resetSelects', () => {

                setTimeout(() => {

                    $('#id_rol')
                        .val('0')
                        .trigger('change.select2');

                }, 100);

            });


            /*
            ==========================================================
            RECARGAR TABLA
            ==========================================================
            */

            Livewire.on('tabla', () => {

                setTimeout(() => {

                    iniciarTabla();

                }, 500);

            });



        });

        </script>
    @endpush
</div>
