<div>

    @push('styles')
    <style>
        .readonly-field {
            background-color: #e9ecef !important;
            cursor: not-allowed !important;
        }

        .btn-guardar {
            background: linear-gradient(135deg, #E22275, #E22275);
            border: none;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(103, 58, 183, .35);
            transition: .25s ease;
        }

        .btn-guardar:hover {
            background: linear-gradient(135deg, #E22275, #E22275);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(103, 58, 183, .45);
        }

    </style>
    @endpush


    @if(session('status'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('status') }}
    </div>
    @endif


    <div class="card shadow-sm border-0">

        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-person-circle me-2"></i>
                Mi perfil
            </h5>
        </div>


        <div class="card-body">

            <div class="row g-3">

                {{-- NOMBRE --}}
                <div class="col-md-12">
                    <label class="form-label text-muted">
                        <i class="bi bi-person me-1"></i>
                        Nombre
                    </label>

                    <input type="text" class="form-control readonly-field" value="{{ $nombre }}" readonly>
                </div>


                {{-- PRIMER APELLIDO --}}
                <div class="col-md-12">
                    <label class="form-label text-muted">
                        Primer apellido
                    </label>

                    <input type="text" class="form-control readonly-field" value="{{ $apaterno }}" readonly>
                </div>


                {{-- SEGUNDO APELLIDO --}}
                <div class="col-md-12">
                    <label class="form-label text-muted">
                        Segundo apellido
                    </label>

                    <input type="text" class="form-control readonly-field" value="{{ $amaterno }}" readonly>
                </div>


                {{-- CORREO --}}
                <div class="col-md-12">
                    <label class="form-label text-muted">
                        <i class="bi bi-envelope me-1"></i>
                        Correo electrónico
                    </label>

                    <input type="email" class="form-control readonly-field" value="{{ $email }}" readonly>
                </div>

                {{-- ROL --}}
                <div class="col-md-12">
                    <label class="form-label text-muted">
                        <i class="bi bi-person-badge me-1"></i>
                        Rol
                    </label>

                    <input type="text" class="form-control readonly-field" value="{{ $rol }}" readonly>
                </div>

            </div>


            <hr class="my-4">


            {{-- CAMBIO DE CONTRASEÑA --}}
            <h6 class="fw-bold mb-3">
                <i class="bi bi-shield-lock me-2"></i>
                Cambiar contraseña
            </h6>


            <form wire:submit="actualizarPassword">

                <div class="row g-3">

                    {{-- NUEVA CONTRASEÑA --}}
                    <div class="col-md-12">

                        <label class="form-label">
                            Nueva contraseña
                        </label>

                        <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="********" wire:model="password">

                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>


                    {{-- CONFIRMAR --}}
                    <div class="col-md-12">

                        <label class="form-label">
                            Confirmar contraseña
                        </label>

                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="********" wire:model="password_confirmation">

                        @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                </div>


                <div class="mt-4 d-flex justify-content-end">

                    <button type="submit" style="background-color: #E22275 !important; border-color: #fff !important;" class="btn btn-guardar btn-lg rounded-pill px-4" wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            <i class="bi bi-key me-1"></i>
                            Guardar
                        </span>

                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Actualizando...
                        </span>
                    </button>



                </div>

            </form>

        </div>

    </div>

</div>
