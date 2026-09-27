@php
    use App\Models\Configuraciones;
    use Carbon\Carbon;
    $configRegistro = Configuraciones::whereHas('proceso', function($q){
            $q->where('nombre','REGISTRO');
        })
        ->where('activo',1)
        ->first();
    $registroActivo = false;
    $estadoRegistro = '';
    $mensajeRegistro = '';
    if($configRegistro){
        $inicio = Carbon::parse($configRegistro->fecha_inicio)
            ->setTimeFromTimeString($configRegistro->hora_inicio);
        $fin = Carbon::parse($configRegistro->fecha_termino)
            ->setTimeFromTimeString($configRegistro->hora_termino);
        if(now()->between($inicio, $fin)){
            $registroActivo = true;
            $estadoRegistro = 'activo';
            $mensajeRegistro =
            'El periodo de registro está habilitado desde el '.$inicio->format('d/m/Y').
            ' a las '.$inicio->format('H:i:s').
            ' horas y estará disponible hasta el '.$fin->format('d/m/Y').
            ' a las '.$fin->format('H:i:s').' horas.';
        }elseif(now()->lt($inicio)){
            $estadoRegistro = 'pendiente';
            $mensajeRegistro =
            'El registro iniciará el '.$inicio->format('d/m/Y').
            ' a las '.$inicio->format('H:i:s').
            ' horas y estará disponible hasta el '.$fin->format('d/m/Y').
            ' a las '.$fin->format('H:i:s').' horas.';
        }else{
            $estadoRegistro = 'finalizado';
            $mensajeRegistro =
            'El periodo de registro finalizó el '.$fin->format('d/m/Y').
            ' a las '.$fin->format('H:i:s').' horas.';
        }
    }else{
        $estadoRegistro = 'finalizado';
        $mensajeRegistro = 'El periodo de registro no está configurado.';
    }
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Iniciar Sesión</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            min-height: 100vh;
            background:#ffffff;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:25px;
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        /* TARJETA PRINCIPAL */
        .login-card {
            border:none;
            border-radius:30px;
            overflow:hidden;
            background:#ffffff;
            box-shadow:
                0 20px 50px rgba(0,0,0,.15),
                0 5px 15px rgba(98,9,214,.10);
            transition:.3s;
        }
        .login-card:hover {
            transform:translateY(-3px);
            box-shadow:
                0 30px 70px rgba(0,0,0,.18);
        }
        /* PANEL IZQUIERDO */
        .login-left {
            height:100%;
            padding:45px;
            color:#222;
            background:#f7f7f7;
            position:relative;
        }
        .login-left:before {
            display:none;
            /*content:"";
            position:absolute;
            width:220px;
            height:220px;
            background:#6209d6;
            opacity:.08;
            border-radius:50%;
            top:-70px;
            right:-70px;*/
        }
        .login-left h2 {
            color:#6209d6;
            font-size:30px;
            letter-spacing:.5px;
        }
        .login-left p {
            color:#555;
        }
        /* LOGO */
        .logo-img {
            width:100%;
            max-width:270px;
            display:block;
            margin:auto;
            filter:
            drop-shadow(0 8px 15px rgba(0,0,0,.18));
        }
        /* ICONOS LISTA */
        .login-left .fa-check-circle {
            color:#6209d6!important;
        }
        /* PANEL DERECHO */
        .login-right {
            padding:45px;
            background:#ffffff;
        }
        /* TITULO */
        .login-right h1 {
            font-size:40px;
            font-weight:700;
            background:
            linear-gradient(
                90deg,
                #6209d6,
                #e22275
            );
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
        }
        /* INPUTS */
        .form-control {
            height:58px;
            border-radius:16px;
            border:1px solid #ddd;
            font-size:15px;
            transition:.3s;
        }
        .form-control:hover {
            border-color:#6209d6;
        }
        .form-control:focus {
            border-color:#6209d6;
            box-shadow:
            0 0 0 .25rem rgba(98,9,214,.15);
        }
        .form-icon {
            position:relative;
        }
        .form-icon i {
            position:absolute;
            top:20px;
            left:18px;
            color:#777;
        }
        .form-icon input {
            padding-left:50px;
        }
        .btn-login {

            height:58px;

            border-radius:18px!important;

            font-weight:700;

            border:none!important;

            background:#E22275!important;

            color:white!important;

            box-shadow:
            0 8px 20px rgba(226,34,117,.25);

            transition:.3s;

        }


        .btn-login:hover {

            background:#c91b65!important;

            transform:translateY(-2px);

            box-shadow:
            0 12px 25px rgba(226,34,117,.35);

        }
        /* ALERTAS */
        .alert {
            border-radius:18px!important;
            border:none;
            box-shadow:
            0 5px 15px rgba(0,0,0,.08);
        }
        /* BOTONES SECUNDARIOS */
        .btn-outline-primary {
            border-radius:18px!important;
            border-width:2px;
            transition:.3s;
        }
        .btn-outline-primary:hover {
            background:#6209d6;
            border-color:#6209d6;
        }
        .btn-outline-success {
            border-radius:15px!important;
            font-size:13px;
            transition:.3s;
        }
        .btn-outline-success:hover {
            transform:translateY(-2px);
        }
        /* CHECKBOX */
        .check-grande {
            width:1.4rem;
            height:1.4rem;
            cursor:pointer;
            border-color:#555;
        }
        .check-grande:checked {
            background-color:#e22275;
            border-color:#e22275;
        }
        /* COPYRIGHT */
        .copyright {
            color:#555;
            text-align:center;
            margin-top:20px;
            font-size:13px;
        }
        /* RESPONSIVE */
        @media(max-width:768px){
            body{
                padding:10px;
            }
            .login-left {
                display:none;
            }
            .login-right {
                padding:30px 20px;
            }
            .login-right h1 {
                font-size:32px;
            }
        }
        /* ==============================
        ANIMACIÓN GENERAL
        ============================== */
        .login-card {
            animation: aparecer .7s ease forwards;
        }
        @keyframes aparecer {
            from {
                opacity:0;
                transform:translateY(25px) scale(.98);
            }
            to {
                opacity:1;
                transform:translateY(0) scale(1);
            }
        }
        /* ==============================
        EFECTO VIDRIO
        ============================== */
        .login-card {
            background:rgba(255,255,255,.85);
            backdrop-filter:blur(15px);
        }
        /* ==============================
        DIVISIÓN ENTRE PANELES
        ============================== */
        .login-left {
            border-right:1px solid rgba(0,0,0,.08);
        }
        /* ==============================
        TITULO APP
        ============================== */
        .login-left h2 {
            font-weight:800;
            text-transform:uppercase;
            letter-spacing:1px;
        }
        /* ==============================
        TEXTO DE INSTRUCCIONES
        ============================== */
        .login-left strong {
            color:#6209d6;
        }
        .login-left p {
            line-height:1.7;
        }
        /* ==============================
        ICONOS DE PASOS
        ============================== */
        .login-left .fa-check-circle {
            background:#eee5ff;
            padding:7px;
            border-radius:50%;
            margin-right:5px;
        }
        /* ==============================
        CABECERA LOGIN
        ============================== */
        .login-right h1 {
            letter-spacing:1px;
        }
        .login-right h5 {
            font-weight:400;
            font-size:15px;
        }
        /* ==============================
        CAMPOS INPUT MODERNOS
        ============================== */
        .form-control {
            background:#fafafa;
        }
        .form-control::placeholder {
            color:#aaa;
        }
        .form-control:focus {
            background:white;
        }
        /* ==============================
        BOTONES INFORMACIÓN
        ============================== */
        .btn-outline-success {
            background:#fff;
            box-shadow:
            0 5px 15px rgba(0,0,0,.06);
        }
        .btn-outline-success:hover {
            color:white!important;
        }
        /* ==============================
        BOTONES INFERIORES
        ============================== */
        .border-top {
            border-color:#eee!important;
        }
        /* ==============================
        CHECKBOX MODERNO
        ============================== */
        .form-check-label {
            cursor:pointer;
            line-height:1.4;
        }
        /* ==============================
        ALERTAS DE ESTADO
        ============================== */
        .alert-success {
            background:
            linear-gradient(
                135deg,
                #e9fff1,
                #ffffff
            );
        }
        .alert-warning {
            background:
            linear-gradient(
                135deg,
                #fff8e5,
                #ffffff
            );
        }
        .alert-danger {
            background:
            linear-gradient(
                135deg,
                #ffecec,
                #ffffff
            );
        }
        /* ==============================
        SOMBRA AL LOGO
        ============================== */
        .logo-img {
            animation:flotar 4s ease-in-out infinite;
        }
        @keyframes flotar {
            0%,100%{
                transform:translateY(0);
            }
            50%{
                transform:translateY(-8px);
            }
        }
        /* ==============================
        RESPONSIVE EXTRA
        ============================== */
        @media(min-width:1200px){
            .login-card {
                min-height:650px;
            }
            .login-left,
            .login-right {
                display:flex;
                flex-direction:column;
                justify-content:center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="card shadow-lg login-card">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="login-left">
                                <div class="text-center">
                                    <img src="{{ asset('imagenes/iepc2.png') }}" class="logo-img">
                                </div>
                                <h2 class="fw-bold text-center">
                                    {{ config('app.name') }}
                                </h2>
                                <p class="text-center">
                                    <b>
                                        Sistema de Registro de Aspirantes a Enlaces Distritales y Municipales
                                    </b>
                                </p>
                                <hr>
                                <div style="font-size:14px;text-align:justify;">
                                    <p>
                                        <i class="fas fa-check-circle text-primary"></i>
                                        <strong>1. Crear cuenta:</strong>
                                        Registre sus datos para acceder a la plataforma.
                                        <br><br>
                                        <i class="fas fa-check-circle text-primary"></i>
                                        <strong>2. Activar cuenta:</strong>
                                        Recibirá un correo con un enlace de activación.
                                        <br><br>
                                        <i class="fas fa-check-circle text-primary"></i>
                                        <strong>3. Iniciar sesión:</strong>
                                        Ingrese con su correo y contraseña.
                                        <br><br>
                                        <i class="fas fa-check-circle text-primary"></i>
                                        <strong>4. Completar registro:</strong>
                                        Capture los módulos de
                                        <strong>Datos Generales, Currículum y Documentos</strong>
                                        para finalizar su registro y descargar sus archivos.
                                    </p>
                                </div>
                                <div class="mt-4">
                                    @if($estadoRegistro == 'activo')
                                        <div class="alert alert-success d-flex align-items-center justify-content-center gap-3 shadow-sm rounded-3 border-0 py-3">
                                            <div class="fs-3">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </div>
                                            <div class="text-center">
                                                <strong class="d-block">Periodo de registro activo</strong>
                                                <span>{{ $mensajeRegistro }}</span>
                                            </div>
                                        </div>
                                    @elseif($estadoRegistro == 'pendiente')
                                        <div class="alert alert-warning d-flex align-items-center justify-content-center gap-3 shadow-sm rounded-3 border-0 py-3">
                                            <div class="fs-3">
                                                <i class="bi bi-clock-history"></i>
                                            </div>
                                            <div class="text-center">
                                                <strong class="d-block">El registro aún no inicia</strong>
                                                <span>{{ $mensajeRegistro }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-danger d-flex align-items-center justify-content-center gap-3 shadow-sm rounded-3 border-0 py-3">
                                            <div class="fs-3">
                                                <i class="bi bi-x-circle-fill"></i>
                                            </div>
                                            <div class="text-center">
                                                <strong class="d-block">Periodo de registro finalizado</strong>
                                                <span>{{ $mensajeRegistro }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="login-right">
                                <div class="text-center mb-6">
                                    <h1 class="fw-bold text-secondary">
                                        ¡Le damos la bienvenida!
                                    </h1>
                                    <p class="text-muted">
                                        <h5 class="text-muted">Ingrese su correo electrónico y contraseña para acceder.</h5>
                                    </p>
                                </div>
                                @if(session('status'))
                                <div class="alert alert-success rounded-3">
                                    <i class="fas fa-check-circle me-1"></i>
                                    {{ session('status') }}
                                </div>
                                @endif
                                @if($errors->any())
                                <div class="alert alert-danger rounded-3">
                                    <ul class="mb-0 ps-3">
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3 mt-5">
                                        <div class="form-icon">
                                            <i class="fas fa-envelope"></i>
                                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="correo@empresa.com" required autofocus>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-icon">
                                            <i class="fas fa-lock"></i>
                                            <input type="password" name="password" class="form-control" placeholder="********" required>
                                        </div>
                                    </div>
                                    <div class="d-grid mb-3">
                                        <button type="submit" class="btn btn-primary btn-login rounded-pill" style="background-color: #E22275 !important;">
                                            <i class="fas fa-sign-in-alt me-2"></i>
                                            Iniciar Sesión
                                        </button>
                                    </div>
                                </form>
                                <div class="text-center mt-3">
                                    <div class="mt-3 p-1">
                                        <div class="mb-1">
                                            <a href="#" style="font-size: 13px;" class="text-primary fw-semibold text-decoration-none" data-bs-toggle="modal" data-bs-target="#privacidadModal">
                                                <i class="fas fa-file-contract me-2"></i>
                                                Consultar políticas de privacidad y manejo de datos personales
                                            </a>
                                        </div>
                                        <p class="text-muted small mb-2 mt-2" style="font-size: 13px;">
                                            Para crear una cuenta, primero debe leer y aceptar las políticas de privacidad y manejo de datos personales. Una vez aceptadas, se habilitará el botón <strong>Crear cuenta</strong>.
                                        </p>
                                        <div class="form-check d-flex align-items-center mt-2">
                                            <label class="form-check-label fw-semibold text-dark" style="font-size: 13px;" for="aceptoPoliticas">
                                                He leído y acepto las políticas de privacidad y manejo de datos personales.
                                            </label>
                                            <input class="form-check-input check-grande ms-3" type="checkbox" id="aceptoPoliticas">
                                        </div>
                                    </div>
                                    <div class="border-top pt-3 mt-3">
                                        <div class="row">
                                            <div class="col-6 mb-2">
                                                @if(Route::has('password.request'))
                                                <a href="{{ route('password.request') }}" class="btn btn-outline-primary w-100 rounded-pill">
                                                    <i class="bi bi-key me-1"></i>
                                                    ¿Olvidó su contraseña?
                                                </a>
                                                @endif
                                            </div>
                                            <div class="col-6">
                                                <a  href="{{ $registroActivo ? route('register') : '#' }}"  id="btnCrearCuenta"  class="btn btn-outline-primary w-100 rounded-pill {{ !$registroActivo ? 'disabled' : '' }}">
                                                    <i class="bi bi-person-plus me-1"></i>
                                                    Crear cuenta
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                                                    <!-- BOTONES INFORMATIVOS -->
                                <div class="mt-4">
                                    <div class="d-flex gap-2 w-100">
                                        <button class="btn btn-outline-success btn-sm rounded-pill flex-fill" data-bs-toggle="modal" data-bs-target="#requisitosModal">
                                            <i class="fas fa-file-alt me-1"></i>
                                            Requisitos
                                        </button>
                                        <button class="btn btn-outline-success btn-sm rounded-pill flex-fill" data-bs-toggle="modal" data-bs-target="#soporteModal">
                                            <i class="fas fa-bullhorn me-1"></i>
                                            ¿Necesitas ayuda?
                                        </button>
                                        <button class="btn btn-outline-success btn-sm rounded-pill flex-fill" data-bs-toggle="modal" data-bs-target="#manualModal">
                                            <i class="fas fa-book me-1"></i>
                                            Manual
                                        </button>
                                        <button class="btn btn-outline-success btn-sm rounded-pill flex-fill" data-bs-toggle="modal" data-bs-target="#videotutorialModal">
                                            <i class="fas fa-video me-1"></i>
                                            Video tutorial
                                        </button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="copyright text-center text-dark">
                    © {{ date('Y') }} {{ config('app.name') }} - Sistema de Registro de Aspirantes a Enlaces Distritales y Municipales.
                </div>
            </div>
        </div>
    </div>
    <!-- ================== Requisitos ================== -->
    <div class="modal fade" id="requisitosModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="requisitosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="requisitosModalLabel">
                        <i class="bi bi-list-check me-2"></i>
                       Requisitos para el Registro de Aspirantes
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar">
                    </button>
                </div>
                <div class="modal-body bg-light">
                    <!-- Información -->
                    <div class="alert alert-primary d-flex">
                        <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                        <div>
                            <strong>Antes de iniciar tu registro</strong>, asegúrate de contar
                            con un <strong>correo electrónico personal</strong> y tener listos
                            los siguientes documentos <strong>en formato PDF</strong>, con un
                            tamaño máximo de <strong>2 MB por archivo</strong>.
                        </div>
                    </div>
                    <!-- Documentos -->
                    <div class="card mb-3">
                        <div class="card-header bg-white fw-semibold">
                            <i class="fa-solid fa-folder-open text-primary me-2"></i>
                            Documentación requerida
                        </div>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex">
                                <i class="fa-solid fa-file-pdf text-danger fs-5 me-3 mt-1"></i>
                                <span>Acta de nacimiento.</span>
                            </div>
                            <div class="list-group-item d-flex">
                                <i class="fa-solid fa-file-pdf text-danger fs-5 me-3 mt-1"></i>
                                <span>Credencial para votar vigente (ambos lados).</span>
                            </div>
                            <div class="list-group-item d-flex">
                                <i class="fa-solid fa-file-pdf text-danger fs-5 me-3 mt-1"></i>
                                <span>Comprobante de domicilio con vigencia no mayor de tres meses.</span>
                            </div>
                            <div class="list-group-item d-flex">
                                <i class="fa-solid fa-file-pdf text-danger fs-5 me-3 mt-1"></i>
                                <span>Certificado o constancia del último grado de estudios.</span>
                            </div>
                            <div class="list-group-item d-flex">
                                <i class="fa-solid fa-file-pdf text-danger fs-5 me-3 mt-1"></i>
                                <span>CURP.</span>
                            </div>
                            <div class="list-group-item d-flex">
                                <i class="fa-solid fa-file-pdf text-danger fs-5 me-3 mt-1"></i>
                                <span>Declaración bajo protesta de decir verdad.</span>
                            </div>
                            <div class="list-group-item d-flex">
                                <i class="fa-solid fa-file-pdf text-danger fs-5 me-3 mt-1"></i>
                                <span>Carta compromiso para presentar la Constancia de Situación Fiscal.</span>
                            </div>
                            <div class="list-group-item d-flex">
                                <i class="fa-solid fa-file-pdf text-danger fs-5 me-3 mt-1"></i>
                                <span>
                                    Documentos con valor curricular que acrediten experiencia como docente,
                                    manejo de grupos de personas o participación en procesos electorales.
                                    Si cuentas con experiencia electoral puedes integrar en un solo PDF:
                                    nombramientos, gafetes, constancias, diplomas o reconocimientos.
                                    Si cuentas con conocimientos en materia electoral puedes integrar en un solo PDF:
                                    cursos, diplomados, especialidades, talleres, foros o congresos.
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Notas -->
                    <div class="alert alert-warning">
                        <h6 class="fw-bold mb-3">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i>
                            Importante
                        </h6>
                        <div class="d-flex mb-2">
                            <i class="fa-solid fa-file-circle-check text-primary me-3 mt-1"></i>
                            <span>
                                El currículum vitae será generado automáticamente por el sistema al finalizar tu registro.
                            </span>
                        </div>
                        <div class="d-flex">
                            <i class="fa-solid fa-user-lock text-danger me-3 mt-1"></i>
                            <span>
                                <strong>Solo podrás registrarte como aspirante a un cargo Distrital o Municipal.</strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- ================== Manual ================== -->
    <div class="modal fade" id="manualModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="manualModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="manualModalLabel">
                        <i class="bi bi-list-check me-2"></i>
                        Manual de Registro para Aspirantes
                    </h5>
                    <button type="button" 
                            class="btn-close btn-close-white" 
                            data-bs-dismiss="modal" 
                            aria-label="Cerrar">
                    </button>
                </div>
                <div class="modal-body p-2 bg-light">
                    <iframe
                        src="{{ asset('manuales/manual2027.pdf') }}"
                        class="w-100 rounded border"
                        style="height:75vh;"
                        title="Manual de Registro para Aspirantes">
                    </iframe>
                </div>
                <div class="modal-footer">
                    <a href="{{ asset('manuales/manual2027.pdf') }}" 
                    target="_blank"
                    class="btn btn-outline-primary">
                        <i class="bi bi-file-earmark-pdf me-1"></i>
                        Abrir PDF
                    </a>
                    <button type="button" 
                            class="btn btn-outline-secondary" 
                            data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- ================== Video tutorial ================== -->
    <div class="modal fade" id="videotutorialModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-play-circle me-2"></i>
                        Video Tutorial de Registro para Aspirantes
                    </h5>
                    <button type="button" 
                            class="btn-close btn-close-white" 
                            data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body p-2 bg-light">
                    <video 
                        class="w-100 rounded border"
                        style="max-height:75vh;"
                        controls
                        preload="metadata">
                        <source src="{{ asset('manuales/videotutorial2027.mp4') }}" type="video/mp4">
                        Tu navegador no soporta reproducción de video.
                    </video>
                </div>
                <div class="modal-footer">
                    <a href="{{ asset('manuales/videotutorial2027.mp4') }}" 
                    target="_blank"
                    class="btn btn-outline-primary">
                        <i class="bi bi-download me-1"></i>
                        Abrir video
                    </a>
                    <button type="button" 
                            class="btn btn-outline-secondary" 
                            data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- ================== Privacidad ================== -->
    <div class="modal fade" id="privacidadModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="privacidadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="privacidadModalLabel">
                        <i class="bi bi-list-check me-2"></i>
                        Políticas de Privacidad y Manejo de Datos Personales
                    </h5>
                    <button type="button" 
                            class="btn-close btn-close-white" 
                            data-bs-dismiss="modal" 
                            aria-label="Cerrar">
                    </button>
                </div>
                <div class="modal-body p-2 bg-light">
                    <iframe
                        src="{{ asset('manuales/avisoprivacidad2027.pdf') }}"
                        class="w-100 rounded border"
                        style="height:75vh;"
                        title="Manual de Registro para Aspirantes">
                    </iframe>
                </div>
                <div class="modal-footer">
                    <a href="{{ asset('manuales/avisoprivacidad2027.pdf') }}" 
                    target="_blank"
                    class="btn btn-outline-primary">
                        <i class="bi bi-file-earmark-pdf me-1"></i>
                        Abrir PDF
                    </a>
                    <button type="button" 
                            class="btn btn-outline-secondary" 
                            data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- ================== Requisitos ================== -->
    <div class="modal fade" id="soporteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="soporteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="soporteModalLabel">
                        <i class="bi bi-list-check me-2"></i>
                      Soporte de registro
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar">
                    </button>
                </div>
                <div class="modal-body bg-light text">
                    <!-- Contacto -->
                    <div class="alert alert-primary d-flex align-items-center">
                        <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                        <div>
                            <strong>¿Tienes dudas o necesitas soporte?</strong><br>
                            Comunícate con nuestro equipo de atención.
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header bg-white fw-semibold">
                            <i class="fa-solid fa-headset text-primary me-2"></i>
                            Contacto de soporte
                        </div>
                        <div class="card-body">
                            <div class="d-flex mb-3">
                                <i class="fa-solid fa-phone text-success fs-5 me-3"></i>
                                <span>
                                    <strong>Teléfonos:</strong><br>
                                    (961) 26 400 20, 26 400 21, 26 400 22, 26 400 23<br>
                                    Extensión 1271
                                </span>
                            </div>
                            <div class="d-flex">
                                <i class="fa-solid fa-envelope text-primary fs-5 me-3"></i>
                                <span>
                                    <strong>Correo electrónico:</strong><br>
                                    capacitacion@iepc-chiapas.org.mx
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Importante -->
                    <div class="alert alert-warning">
                        <h6 class="fw-bold mb-2">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i>
                            Importante
                        </h6>
                        <p class="mb-0">
                            Antes de iniciar tu registro debes contar con un
                            <strong>correo electrónico de uso personal</strong> para recibir
                            avisos y notificaciones.
                            La cuenta que crearás en el sistema es únicamente para el
                            <strong>registro en línea</strong>, no corresponde a la creación
                            de un correo electrónico personal.
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const periodoActivo = @json($registroActivo);
            const checkbox = document.getElementById('aceptoPoliticas');
            const boton = document.getElementById('btnCrearCuenta');
            function validar(){
                if(!periodoActivo){
                    boton.classList.add('disabled');
                    boton.href="#";
                    return;
                }
                if(checkbox.checked){
                    boton.classList.remove('disabled');
                    boton.href="{{ route('register') }}";
                }else{
                    boton.classList.add('disabled');
                    boton.href="#";
                }
            }
            checkbox.addEventListener('change',validar);
            validar();
        });
    </script>
</body>
</html>
