<div class="card border-0 shadow-sm">
    <style>
        .readonly-field {
            background-color: #e9ecef !important;
            opacity: 1 !important;
            cursor: not-allowed !important;
        }

        /* ancho completo */
        .select2-container {
            width: 100% !important;
        }

        /* SELECT NORMAL */
        .select2-container--default .select2-selection--single {
            height: 38px !important;
            border: 1px solid #dee2e6 !important;
            border-radius: .375rem !important;
            background-color: #fff !important;
            transition: border-color .15s ease-in-out,
                box-shadow .15s ease-in-out;
        }

        /* TEXTO */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px !important;
            padding-left: .75rem !important;
            padding-right: 65px !important;
            font-size: 1rem !important;
            color: #212529 !important;
        }

        /* FLECHA */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px !important;
            right: 8px !important;
        }

        /* FOCUS AZUL */
        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #86b7fe !important;
            box-shadow:
                0 0 0 .25rem rgba(13, 110, 253, .25) !important;
        }

        /* ERROR ROJO */
        .select2-container.select2-error .select2-selection--single {
            border-color: #dc3545 !important;
            box-shadow:
                0 0 0 .25rem rgba(220, 53, 69, .25) !important;
        }

        /* X PARA LIMPIAR */
        .select2-container--default .select2-selection--single .select2-selection__clear {
            position: absolute !important;
            right: 35px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            font-size: 22px !important;
            color: #dc3545 !important;
            font-weight: bold !important;
            margin: 0 !important;
            line-height: 1 !important;
            cursor: pointer !important;
            z-index: 20 !important;
        }

        /* hover X */
        .select2-container--default .select2-selection--single .select2-selection__clear:hover {
            color: #b02a37 !important;
        }

        /* OPCION MARCADA */
        .select2-container--default .select2-results__option[aria-selected="true"] {
            background-color: #e9ecef !important;
            color: #212529 !important;
        }

        /* OPCION AL PASAR */
        .select2-container--default .select2-results__option--highlighted {
            background-color: #0d6efd !important;
            color: white !important;
        }

        /* BUSCADOR */
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #dee2e6 !important;
            border-radius: .375rem !important;
        }

        /* DESHABILITADO */
        .select2-container--default.select2-container--disabled .select2-selection--single {
            background-color: #e9ecef !important;
            cursor: not-allowed !important;
        }

        .select2-selection__clear {
            display: none !important;
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
    <div class="card-header bg-primary text-white" style="background-color: #E22275 !important;">
        <h5 class="mb-0">
            <i class="fa-solid fa-file me-2"></i>
            Datos Generales
        </h5>
    </div>
    <div class="card-body">
        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
        @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <div class="col-md-12 mb-2">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="fw-bold mb-1">
                        <i class="fa-solid fa-list-check text-primary me-2"></i>
                        Datos por registrar
                    </h5>
                    <small class="text-muted">
                        Consulta y edita los registros capturados
                    </small>

                    <small class="text-muted d-block mt-1">
                        <i class="fa-solid fa-asterisk text-danger me-1"></i>
                        Campos obligatorios para completar el registro.
                    </small>
                </div>
            </div>
        </div>
        {{-- ================= STEP 1 ================= --}}
        <div class="col-12">
            <div class="d-flex align-items-center border-bottom pb-2 mb-3" style="color:#d41f6e;">
                <span class="badge me-2" style="background:#ec4c92;">
                    1
                </span>
                <strong>
                    Seleccione el municipio o distrito
                </strong>
            </div>
        </div>
        {{-- TIPO ENLACE --}}
        <div class="mb-3">
            <label class="form-label small @error('id_tipo_cargo') text-danger @else text-muted @enderror">
                <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                Tipo de enlace
            </label>
            <select id="id_tipo_cargo" class="form-select select2" data-model="id_tipo_cargo" wire:ignore>
                @foreach($cargos as $key=>$value)
                <option value="{{ $key }}" @selected($id_tipo_cargo==$key)>
                    {{ $value }}
                </option>
                @endforeach
            </select>
            @error('id_tipo_cargo')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>
        {{-- DISTRITO --}}
        @if($mostrar_distrito)
        <div class="mb-3">
            <label class="form-label small @error('id_distrital') text-danger @else text-muted @enderror">
                <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                Distrito
            </label>
            <select id="id_distrital" class="form-select select2" data-model="id_distrital" wire:ignore>
                @foreach($distritos as $key=>$value)
                <option value="{{ $key }}" @selected($id_distrital==$key)>
                    {{ $value }}
                </option>
                @endforeach
            </select>
            @error('id_distrital')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>
        @endif
        {{-- MUNICIPIO --}}
        @if($mostrar_municipio)
        <div class="mb-3">
            <label class="form-label small @error('id_municipal') text-danger @else text-muted @enderror">
                <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                Municipio
            </label>
            <select id="id_municipal" class="form-select select2" data-model="id_municipal" wire:ignore>
                @foreach($municipios as $key=>$value)
                <option value="{{ $key }}" @selected($id_municipal==$key)>
                    {{ $value }}
                </option>
                @endforeach
            </select>
            @error('id_municipal')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>
        @endif
        {{-- ================= STEP 2 ================= --}}
        <div class="col-12 mt-4">
            <div class="d-flex align-items-center border-bottom pb-2 mb-3" style="color:#d41f6e;">
                <span class="badge me-2" style="background:#ec4c92;">
                    2
                </span>
                <strong>
                    Datos personales
                </strong>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{-- NOMBRE --}}
                <div class="mb-3">
                    <label class="form-label small text-muted">
                        <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                        Nombre(s)
                    </label>
                    <input type="text" id="nombre" class="form-control 
                    @error('nombre') is-invalid @enderror" wire:model="nombre">
                    @error('nombre')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                {{-- APELLIDO PATERNO --}}
                <div class="mb-3">
                    <label class="form-label small text-muted">
                        <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                        Primer apellido
                    </label>
                    <input type="text" id="apaterno" class="form-control 
                    @error('apaterno') is-invalid @enderror" wire:model="apaterno">
                    @error('apaterno')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                {{-- APELLIDO MATERNO --}}
                <div class="mb-3">
                    <label class="form-label small text-muted">
                        Segundo apellido
                    </label>
                    <input type="text" id="amaterno" class="form-control 
                    @error('amaterno') is-invalid @enderror" wire:model="amaterno">
                    @error('amaterno')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                {{-- RFC --}}
                <div class="row">
                    <div class="col-md-7 mb-3">
                        <label class="form-label small text-muted">
                            <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                            Rfc
                        </label>
                        <input type="text" id="rfc" class="form-control text-uppercase
                        @error('rfc') is-invalid @enderror" wire:model="rfc">
                        <small id="rfc_error" class="text-danger"></small>
                        @error('rfc')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
                    <div class="col-md-5 mb-3">
                        <label class="form-label small text-muted">
                            Homoclave
                        </label>
                        <input type="text" id="homoclave" class="form-control text-uppercase
                        @error('homoclave') is-invalid @enderror" wire:model="homoclave">
                        @error('homoclave')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
                </div>
                {{-- CURP --}}
                <div class="mb-3">
                    <label class="form-label small text-muted">
                        <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                        Curp
                    </label>
                    <input type="text" id="curp" class="form-control text-uppercase
                    @error('curp') is-invalid @enderror" wire:model="curp">
                    <small id="curp_error" class="text-danger"></small>
                    @error('curp')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                {{-- DISCAPACIDAD --}}
                <div class="mb-3">
                    <label class="form-label small @error('id_discapacidad') text-danger @else text-muted @enderror">
                        <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                        Discapacidad
                    </label>
                    <select id="id_discapacidad" class="form-select select2" data-model="id_discapacidad" wire:ignore>
                        @foreach($discapacidades as $key=>$value)
                        <option value="{{ $key }}" @selected($id_discapacidad==$key)>
                            {{ $value }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_discapacidad')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                {{-- GENERO --}}
                <div class="mb-3">
                    <label class="form-label small @error('id_genero') text-danger @else text-muted @enderror">
                        <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                        Género
                    </label>
                    <select id="id_genero" class="form-select select2" data-model="id_genero" wire:ignore>
                        @foreach($generos as $key=>$value)
                        <option value="{{ $key }}" @selected($id_genero==$key)>
                            {{ $value }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_genero')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                {{-- TELEFONOS --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small text-muted">
                            {{-- <i class="fa fa-star text-danger" style="font-size:8px;"></i> --}}
                            Teléfono casa
                        </label>
                        <input type="text" id="telefono_casa" class="form-control 
                        @error('telefono_casa') is-invalid @enderror" wire:model="telefono_casa">
                        @error('telefono_casa')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small text-muted">
                            <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                            Teléfono celular
                        </label>
                        <input type="text" id="telefono_movil" class="form-control 
                        @error('telefono_movil') is-invalid @enderror" wire:model="telefono_movil">
                        @error('telefono_movil')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
                </div>
            </div>
            {{-- COLUMNA DERECHA --}}
            <div class="col-md-12">
                {{-- LICENCIA --}}
                <div class="mb-3">
                    <label class="form-label small @error('id_tipo_licencia') text-danger @else text-muted @enderror">
                        <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                        Tipo de licencia
                    </label>
                    <select id="id_tipo_licencia" class="form-select select2" data-model="id_tipo_licencia" wire:ignore>
                        @foreach($licencias as $key=>$value)
                        <option value="{{ $key }}" @selected($id_tipo_licencia==$key)>
                            {{ $value }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_tipo_licencia')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                {{-- ETNIA --}}
                <div class="mb-3">
                    <label class="form-label small @error('id_etnia') text-danger @else text-muted @enderror">
                        <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                        Autoadscripción indígena
                    </label>
                    <select id="id_etnia" class="form-select select2" data-model="id_etnia" wire:ignore>
                        @foreach($etnias as $key=>$value)
                        <option value="{{ $key }}" @selected($id_etnia==$key)>
                            {{ $value }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_etnia')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                {{-- LENGUA --}}
                <div class="mb-3">
                    <label class="form-label small @error('id_idioma_predominante') text-danger @else text-muted @enderror">
                        <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                        Lengua predominante
                    </label>
                    <select id="id_idioma_predominante" class="form-select select2" data-model="id_idioma_predominante" wire:ignore>
                        @foreach($idiomas as $key=>$value)
                        <option value="{{ $key }}" @selected($id_idioma_predominante==$key)>
                            {{ $value }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_idioma_predominante')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                {{-- OTRA LENGUA --}}
                <div class="mb-3">
                    <label class="form-label small @error('id_otro_idioma') text-danger @else text-muted @enderror">
                        <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                        Otra lengua
                    </label>
                    <select id="id_otro_idioma" class="form-select select2" data-model="id_otro_idioma" wire:ignore>
                        @foreach($idiomas_otros as $key=>$value)
                        <option value="{{ $key }}" @selected($id_otro_idioma==$key)>
                            {{ $value }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_otro_idioma')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                @if($mostrar_otro_idioma)
                <div class="mb-3">
                    <label class="form-label small text-muted">
                        <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                        Escriba cual
                    </label>
                    <input id="especifique_idioma" type="text" class="form-control 
                    @error('especifique_idioma') is-invalid @enderror" wire:model="especifique_idioma">
                    @error('especifique_idioma')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                @endif
                {{-- OCUPACION --}}
                <div class="mb-3">
                    <label class="form-label small text-muted">
                        <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                        Ocupación actual
                    </label>
                    <input id="ocupacion_actual" type="text" class="form-control 
                    @error('ocupacion_actual') is-invalid @enderror" wire:model="ocupacion_actual">
                    @error('ocupacion_actual')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                {{-- CLAVE ELECTOR --}}
                <div class="mb-3">
                    <label class="form-label small text-muted">
                        <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                        Clave de elector
                    </label>
                    <input id="clave_elector" type="text" class="form-control text-uppercase
                    @error('clave_elector') is-invalid @enderror" wire:model.live.debounce.400ms="clave_elector">
                    @error('clave_elector')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                    @if($clave_elector_mensaje)
                    <small class="text-danger">
                        {{ $clave_elector_mensaje }}
                    </small>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label small @error('fecha_nacimiento') text-danger @enderror">
                            FECHA DE NACIMIENTO
                        </label>
                        <input type="text" id="fecha_nacimiento" class="form-control readonly-field @error('fecha_nacimiento') is-invalid @enderror" style="width:100%; text-transform: uppercase;" wire:model.defer="fecha_nacimiento" readonly>
                        @error('fecha_nacimiento')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label small @error('genero') text-danger @enderror">
                            SEXO
                        </label>
                        <input type="text" id="genero" class="form-control readonly-field @error('genero') is-invalid @enderror" style="width:100%; text-transform: uppercase;" wire:model.defer="genero" readonly>
                        @error('genero')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label small @error('edad') text-danger @enderror">
                            EDAD
                        </label>
                        <input type="text" id="edad" class="form-control readonly-field @error('edad') is-invalid @enderror" style="width:100%; text-transform: uppercase;" wire:model.defer="edad" readonly>
                        @error('edad')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        {{-- ================= STEP 3 ================= --}}
        <div class="col-12 mt-4">
            <div class="d-flex align-items-center border-bottom pb-2 mb-3" style="color:#d41f6e;">
                <span class="badge me-2" style="background:#ec4c92;">
                    3
                </span>
                <strong>
                    Domicilio particular
                </strong>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{-- MUNICIPIO --}}
                <div class="mb-3">
                    <label class="form-label small @error('id_municipio') text-danger @else text-muted @enderror">
                        <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                        Municipio
                    </label>
                    <select id="id_municipio" class="form-select select2" data-model="id_municipio" wire:ignore>
                        @foreach($municipios as $key=>$value)
                        <option value="{{ $key }}" @selected($id_otro_idioma==$key)>
                            {{ $value }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_municipio')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                {{-- COLONIA --}}
                <div class="mb-3">
                    <label class="form-label small text-muted">
                        <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                        Colonia
                    </label>
                    <input id="colonia" type="text" class="form-control 
                    @error('colonia') is-invalid @enderror" wire:model="colonia">
                    @error('colonia')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                {{-- CALLE --}}
                <div class="mb-3">
                    <label class="form-label small text-muted">
                        <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                        Calle
                    </label>
                    <input id="calle" type="text" class="form-control 
                    @error('calle') is-invalid @enderror" wire:model="calle">
                    @error('calle')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                {{-- NUMEROS --}}
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label small text-muted">
                            <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                            Número exterior
                        </label>
                        <input id="num_casa_exterior" type="text" class="form-control 
                        @error('num_casa_exterior') is-invalid @enderror" wire:model="num_casa_exterior">
                        @error('num_casa_exterior')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label small text-muted">
                            Número interior
                        </label>
                        <input id="num_casa_interior" type="text" class="form-control 
                        @error('num_casa_interior') is-invalid @enderror" wire:model="num_casa_interior">
                        @error('num_casa_interior')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
                </div>
                {{-- CP --}}
                <div class="mb-3">
                    <label class="form-label small text-muted">
                        <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                        Código postal
                    </label>
                    <input id="cp" type="text" class="form-control 
                        @error('cp') is-invalid @enderror" wire:model="cp">
                    @error('cp')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                {{-- ESTADO --}}
                {{--  
                <div class="mb-3">
                    <label class="form-label small @error('id_estado') text-danger @else text-muted @enderror">
                        <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                        Estado
                    </label>
                    <select id="id_estado" class="form-select select2" data-model="id_estado" wire:ignore>
                        @foreach($estados as $key=>$value)
                        <option value="{{ $key }}" @selected($id_estado==$key)>
                            {{ $value }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_estado')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                --}}
            </div>
        </div>
        {{-- BOTON --}}
        <div class="d-flex justify-content-between align-items-center mt-4">
          
            @if(auth()->user()->hasRole('Aspirante'))
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-md px-3 rounded-2">
                    <i class="fa fa-arrow-left me-1"></i>
                    Volver
                </a>
            @endif
            <button type="button" class="btn btn-guardar btn-md px-4 rounded-2" wire:click="storeGenerales" wire:loading.attr="disabled">
                <span wire:loading.remove>
                    <i class="fa fa-save me-1"></i>
                    Guardar
                </span>
                <span wire:loading>
                    <i class="fa fa-spinner fa-spin me-1"></i>
                    Guardando
                </span>
            </button>
        </div>
    </div> {{-- card-body --}}
</div> {{-- card --}}

@push('scripts')
<script>
    // ===============================
    // MENSAJES SWEETALERT
    // ===============================
    Livewire.on('swalDatosAcademicos', (data) => {
        Swal.fire({
            icon: data[0].icon
            , title: data[0].title
            , text: data[0].text
            , confirmButtonText: 'Aceptar'
        });
    });

    function validarRFC(rfc) {
        mostrarAdvertenciaRFC("");
        if (typeof rfc !== "string" || rfc.trim() === "") {
            mostrarAdvertenciaRFC("El RFC es obligatorio.");
            return false;
        }
        rfc = rfc.trim().toUpperCase().replace(/\s+/g, "");
        // RFC persona física sin homoclave (10 caracteres)
        const regexRFC = /^[A-ZÑ&]{4}\d{6}$/;
        if (rfc.length !== 10) {
            mostrarAdvertenciaRFC("El RFC debe tener exactamente 10 caracteres.");
            return false;
        }
        if (!regexRFC.test(rfc)) {
            mostrarAdvertenciaRFC("El RFC no tiene un formato válido sin homoclave.");
            return false;
        }
        // Validar fecha YYMMDD
        const anioCorto = parseInt(rfc.substring(4, 6), 10);
        const mes = parseInt(rfc.substring(6, 8), 10);
        const dia = parseInt(rfc.substring(8, 10), 10);
        // Determinar siglo
        const anio = anioCorto <= 30 ?
            2000 + anioCorto :
            1900 + anioCorto;
        const fecha = new Date(anio, mes - 1, dia);
        if (
            fecha.getFullYear() !== anio ||
            fecha.getMonth() !== mes - 1 ||
            fecha.getDate() !== dia
        ) {
            mostrarAdvertenciaRFC("La fecha incluida en el RFC no es válida.");
            return false;
        }
        ocultarAdvertenciaRFC();
        return true;
    }

    function mostrarAdvertenciaRFC(msg) {
        $("#rfc_error").text(msg).show();
        console.warn("⚠️ " + msg);
    }
    $(document).on('blur', '#rfc', function() {
        const rfc = $(this).val();
        if (rfc.length === 10) {
            validarRFC(rfc);
        } else {
            mostrarAdvertenciaRFC("El RFC debe tener exactamente 10 caracteres.");
        }
    });

    function validarCURP(curp) {
        mostrarAdvertencia("");
        curp = curp.trim().toUpperCase();
        // CURP formato oficial
        const regexCURP = /^[A-Z]{1}[AEIOUX]{1}[A-Z]{2}\d{2}(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01])[HM](AS|BC|BS|CC|CL|CM|CS|CH|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]\d$/;
        if (!regexCURP.test(curp)) {
            mostrarAdvertencia("La CURP no tiene un formato válido.");
            return false;
        }
        // Fecha nacimiento
        const anio = parseInt(curp.substring(4, 6));
        const mes = parseInt(curp.substring(6, 8));
        const dia = parseInt(curp.substring(8, 10));
        const siglo = anio <= 30 ? 2000 : 1900;
        const fecha = new Date(
            siglo + anio
            , mes - 1
            , dia
        );
        // Validar fecha real
        if (
            fecha.getFullYear() !== siglo + anio ||
            fecha.getMonth() + 1 !== mes ||
            fecha.getDate() !== dia
        ) {
            mostrarAdvertencia(
                "La fecha de nacimiento en la CURP no es válida."
            );
            return false;
        }
        return true;
    }
    // Mostrar mensaje
    function mostrarAdvertencia(msg) {
        $("#curp_error").text(msg).show();
        console.warn("⚠️ " + msg);
    }
    // Al salir del campo
    $(document).on('blur', '#curp', function() {
        const curp = $(this).val();
        if (curp.length === 18) {
            validarCURP(curp);
        } else {
            mostrarAdvertencia("La CURP debe tener 18 caracteres.");
        }
    });

    function iniciarSelect2() {
        $('.select2').each(function() {
            let select = $(this);
            if (select.hasClass('select2-hidden-accessible')) {
                select.select2('destroy');
            }
            select.select2({
                width: '100%'
                , allowClear: true
            });
            let valorActual = select.find('option:selected').val();
            if (valorActual) {
                select.val(valorActual)
                    .trigger('change.select2');
            }
            select.off('change')
                .on('change', function() {
                    let modelo = $(this).data('model');
                    let valor = $(this).val();
                    let wireId = $(this)
                        .closest('[wire\\:id]')
                        .attr('wire:id');
                    if (wireId && modelo) {
                        Livewire.find(wireId)
                            .set(modelo, valor);
                    }
                });
        });
    }

    /*$(document).on('blur', '#clave_elector', function () {
        const clave = $(this).val().trim().toUpperCase();

        if (clave.length !== 18) {
            $("#clave_elector_error")
                .text("La Clave de Elector debe tener exactamente 18 caracteres.")
                .show();
        } else {
            $("#clave_elector_error").hide();
        }
    });*/

    /*$(document).on('blur', '#clave_elector', function () {
        const clave = $(this).val().trim().toUpperCase();

        if (clave.length > 0 && clave.length !== 18) {
            Swal.fire({
                icon: 'warning',
                title: 'Clave de Elector inválida',
                text: 'La Clave de Elector debe contener exactamente 18 caracteres.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                $('#clave_elector').focus();
            });
        }
    });*/

    function iniciarValidaciones() {
        // SOLO NÚMEROS
        document.querySelectorAll('.solo-numeros')
            .forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value
                        .replace(/[^0-9]/g, '')
                        .slice(0, 10);
                });
            });
        // SOLO LETRAS
        document.querySelectorAll('.solo-letras')
            .forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value
                        .replace(/[^A-Za-zÁÉÍÓÚÑáéíóúñ\s]/g, '');
                });
            });
        // TELEFONOS
        ['telefono_movil', 'telefono_casa']
        .forEach(id => {
            const input = document.getElementById(id);
            if (input) {
                input.addEventListener('input', function() {
                    this.value = this.value
                        .replace(/[^0-9]/g, '')
                        .slice(0, 10);
                });
            }
        });
        // CURP
        const curp = document.getElementById('curp');
        if (curp) {
            curp.addEventListener('input', function() {
                this.value = this.value
                    .replace(/[^A-Za-z0-9]/g, '')
                    .toUpperCase()
                    .slice(0, 18);
            });
        }
        // RFC
        const rfc = document.getElementById('rfc');
        if (rfc) {
            rfc.addEventListener('input', function() {
                this.value = this.value
                    .replace(/[^A-Za-z0-9]/g, '')
                    .toUpperCase()
                    .slice(0, 10);
            });
        }
        // HOMOCLAVE
        const homoclave = document.getElementById('homoclave');
        if (homoclave) {
            homoclave.addEventListener('input', function() {
                this.value = this.value
                    .replace(/[^A-Za-z0-9]/g, '')
                    .toUpperCase()
                    .slice(0, 3);
            });
        }
        // CP
        const cp = document.getElementById('cp');
        if (cp) {
            cp.addEventListener('input', function() {
                this.value = this.value
                    .replace(/[^0-9]/g, '')
                    .slice(0, 5);
            });
        }

        // CLAVE DE ELECTOR
        const claveElector = document.getElementById('clave_elector');

        if (claveElector) {
            claveElector.addEventListener('input', function () {
                this.value = this.value
                    .replace(/[^A-Za-z0-9]/g, '') // Solo letras y números
                    .toUpperCase()
                    .slice(0, 18); // Máximo 18 caracteres
            });
        }

    }
    // INICIO
    document.addEventListener('livewire:init', () => {
        iniciarSelect2();
        iniciarValidaciones();
    });
    // CADA ACTUALIZACIÓN LIVEWIRE
    Livewire.hook('morphed', () => {
        iniciarSelect2();
        iniciarValidaciones();
    });
    // DESDE PHP $this->dispatch('refresh-select2')
    window.addEventListener('refresh-select2', () => {
        setTimeout(() => {
            iniciarSelect2();
        }, 100);
    });

</script>
@endpush
