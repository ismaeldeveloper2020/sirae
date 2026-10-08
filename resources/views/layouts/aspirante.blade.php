<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="Plataforma para el registro, seguimiento y gestión de aspirantes en procesos electorales distritales y municipales." />
    <meta name="keywords" content="aspirantes electorales, registro electoral, elecciones distritales, elecciones municipales, proceso electoral, candidatos, capacitación, evaluación, registro de aspirantes, examen" />

    <title>
        @yield('title','Portal del Aspirante')
    </title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="{{asset('adminlte4/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@7.3.1/css/all.min.css" integrity="sha384-qrALq7+6jBOZIQsNnT6xGkMDru64qD6uTlDra39xrt2SoXl4pO3FX6Roz/RpR/BS" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" integrity="sha384-4Efkt0T8BZbTzoX4+i/jZFCAWVy1BuRte6F0L3awo3Ek6D1L98qwg7ZRe5bxSrF/" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@3.1.3/css/dataTables.bootstrap5.min.css" integrity="sha384-OZKa6QSlaaq/LGR1sBFkYhC0c/nacIFh1chsblhDUxggC9Zb0XLEEMs95i1Kydnt" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-responsive-bs5@4.1.1/css/responsive.bootstrap5.min.css" integrity="sha384-IccFVZxMebKzou2YAT+5kHCpRTtvbJKtU1WS6PmGGeO3LvfGhMNgmeDE5k59j9Qk" crossorigin="anonymous">

            @livewireStyles
            <style>
                :root {
                    --primary: #E22275;
                    --primary-dark: #b71859;
                    --soft: #fff0f6;
                    --bg: #f5f7fb;
                }
                * {
                    font-family: 'Segoe UI', system-ui, sans-serif;
                }
                body {
                    background: var(--bg);
                }
                .navbar-portal {
                    background: white;
                    padding: 15px 0;
                    box-shadow: 0 5px 20px rgba(0, 0, 0, .06);
                }
                .logo {
                    font-size: 1.5rem;
                    font-weight: 800;
                    color: var(--primary) !important;
                }
                .logo i {
                    background: var(--primary);
                    color: white;
                    padding: 10px;
                    border-radius: 12px;
                }
                /*
                .hero {
                    margin: 20px;
                    border-radius: 30px;
                    padding: 50px 15px;
                    background: linear-gradient(135deg, #E22275, #9d164c);
                    color: white;
                }
                .hero h1 {
                    font-size: 2.8rem;
                    font-weight: 900;
                }*/
                .hero {
            padding:25px 0;
        }
        .perfil-card {
            background:linear-gradient(
                135deg,
                #ffffff,
                #fafafa
            );

            border-radius:25px;
            padding:20px;
            display:flex;
            align-items:center;
            gap:25px;
            box-shadow:
            0 10px 30px rgba(0,0,0,.08);

            border-left:6px solid #E22275;

            position:relative;

            overflow:hidden;

        }
        .perfil-avatar{
            width:90px;
            height:90px;

            border-radius:50%;

            background: linear-gradient(135deg,#E22275,#8e1450);

            color:white;

            display:grid;
            place-items:center;

            font-size:38px;

            box-shadow: 0 8px 20px rgba(226,34,117,.35);

            aspect-ratio: 1 / 1;
        }
        .perfil-info h2 {

            margin:5px 0;

            font-size:30px;

            font-weight:800;

            color:#222;

        }
        .perfil-label {

            color:#E22275;

            font-size:14px;

            font-weight:700;

            text-transform:uppercase;

        }
        .perfil-folio {

            margin-top:12px;

            display:inline-flex;

            align-items:center;

            gap:8px;

            background:#f1f1f1;

            padding:8px 15px;

            border-radius:20px;

            color:#555;

        }
        .perfil-icon {

            margin-left:auto;

            font-size:80px;

            color:#E22275;

            opacity:.12;

        }
        .user-card {
            background: white;
            border-radius: 25px;
            padding: 25px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .08);
        }
        .avatar {
            width: 85px;
            height: 85px;
            border-radius: 50%;
            background: var(--soft);
            color: var(--primary);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 45px;
        }
        .progress {
            height: 20px;
            border-radius: 20px;
            overflow: hidden;
        }
        .progress-bar {
            background: var(--primary);
            font-weight: 700;
        }
        .module {
            background: white;
            border-radius: 25px;
            padding: 35px 25px;
            transition: .3s;
        }
        .module:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 45px rgba(226, 34, 117, .18);
        }
        .module.completed {
            border: 3px solid #28a745;
        }
        .module-icon {
            width: 80px;
            height: 80px;
            border-radius: 25px;
            background: var(--soft);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            margin: auto;
        }
        .btn-main {
            background: var(--primary);
            color: white;
            border-radius: 30px;
            padding: 12px 30px;
        }
        footer {
            margin-top: 60px;
            padding: 30px;
            background: white;
        }
        .readonly-field {
            background-color: #e9ecef !important;
            opacity: 1 !important;
            cursor: not-allowed !important;
        }
        /* ANCHO COMPLETO */
        .select2-container {
            width:100% !important;
        }
        /* SELECT NORMAL */
        .select2-container--default 
        .select2-selection--single {
            height:38px !important;
            border:1px solid #dee2e6 !important;
            border-radius:.375rem !important;
            background-color:#fff !important;
            transition:
            border-color .15s ease-in-out,
            box-shadow .15s ease-in-out;
        }
        /* TEXTO */
        .select2-container--default 
        .select2-selection--single 
        .select2-selection__rendered {
            line-height:38px !important;
            padding-left:.75rem !important;
            padding-right:65px !important;
            font-size:1rem !important;
            color:#212529 !important;
        }
        /* FLECHA */
        .select2-container--default 
        .select2-selection--single 
        .select2-selection__arrow {
            height:38px !important;
            right:8px !important;
        }
        /* FOCUS / ABIERTO ROSA */
        .select2-container--default.select2-container--focus 
        .select2-selection--single,
        .select2-container--default.select2-container--open 
        .select2-selection--single {
            border-color: #86b7fe !important;
            outline: 0 !important;
            box-shadow: 0 0 0 .25rem rgba(13,110,253,.25) !important;
        }
        /* ERROR */
        .select2-container.select2-error 
        .select2-selection--single {
            border-color:#dc3545 !important;
            box-shadow:
            0 0 0 .25rem rgba(220,53,69,.25) !important;
        }
        /* X LIMPIAR */
        .select2-container--default 
        .select2-selection--single 
        .select2-selection__clear {
            position:absolute !important;
            right:35px !important;
            top:50% !important;
            transform:translateY(-50%) !important;
            font-size:22px !important;
            color:#dc3545 !important;
            font-weight:bold !important;
            margin:0 !important;
            line-height:1 !important;
            cursor:pointer !important;
            z-index:20 !important;
        }
        .select2-container--default 
        .select2-selection--single 
        .select2-selection__clear:hover {
            color:#b02a37 !important;
        }
        /* OPCION SELECCIONADA */
        .select2-container--default 
        .select2-results__option[aria-selected="true"] {
            background-color:#E22275 !important;
            color:white !important;
        }
        /* HOVER OPCIONES */
        .select2-container--default 
        .select2-results__option--highlighted {
            background-color:#E22275 !important;
            color:white !important;
        }
        /* HOVER SOBRE SELECCIONADA */
        .select2-container--default 
        .select2-results__option[aria-selected="true"]:hover {
            background-color:#E22275 !important;
            color:white !important;
        }
        /* BUSCADOR */
        .select2-container--default 
        .select2-search--dropdown 
        .select2-search__field {
            border:1px solid #dee2e6 !important;
            border-radius:.375rem !important;
        }
        /* DESHABILITADO */
        .select2-container--default.select2-container--disabled 
        .select2-selection--single {
            background-color:#e9ecef !important;
            cursor:not-allowed !important;
        }
        /* OCULTAR X */
        .select2-selection__clear {
            display:none !important;
        }

        .wrapper{
            min-height:100vh;
            display:flex;
            flex-direction:column;
        }

        .content-page{
            flex:1;
        }

        footer{
            margin-top:auto;
        }




    </style>
</head>
<body>
    <div class="wrapper">
        
        <nav class="navbar navbar-expand-lg navbar-portal">
            <div class="container">
                <a class="navbar-brand logo" href="{{route('dashboard')}}">
                    <i class="fa-solid fa-user-graduate"></i>
                    Portal Aspirante
                </a>

                <form method="POST"
                    action="{{ route('logout') }}"
                    class="m-0 ms-auto"
                    id="logoutForm">

                    @csrf

                    <button type="submit"
                            class="btn btn-main"
                            id="logoutButton">

                        <i class="fas fa-sign-out-alt me-2" id="logoutIcon"></i>

                        <span id="logoutText">Salir</span>
                    </button>
                </form>
            </div>
        </nav>
        

        {{--  
        <nav class="navbar navbar-expand-lg navbar-portal">
            <div class="container">
                <a class="navbar-brand logo d-flex align-items-center gap-3" 
                href="{{route('dashboard')}}">
                    <img 
                        src="{{ asset('imagenes/logo.png') }}"
                        class="logo-img"
                        alt="Logo Portal Aspirante">
                    <div>
                        <span class="logo-title">
                            Portal Aspirante
                        </span>
                        <small class="d-block logo-subtitle">
                            Sistema de Registro
                        </small>
                    </div>
                </a>
                <form method="POST" action="{{route('logout')}}">
                    @csrf
                    <button class="btn btn-main">
                        <i class="fa-solid fa-power-off"></i>
                        Salir
                    </button>
                </form>
            </div>
        </nav>
        --}}
        <section class="hero">
            <div class="container">

                <div class="perfil-card">
                    <div class="perfil-avatar">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div class="perfil-info">
                        <span class="perfil-label">
                            Aspirante
                        </span>
                        <h2>
                            {{ auth()->user()->nombre }}
                            {{ auth()->user()->apaterno }}
                            {{ auth()->user()->amaterno }}
                        </h2>
                        <div class="perfil-folio">
                            <i class="fa-solid fa-id-card"></i>
                            Folio:
                            <strong id="folio-aspirante">
                                {{ \App\Models\Aspirantes\Generales::where('user_id',auth()->id())->value('folio') ?? '---' }}
                            </strong>
                        </div>
                    </div>
                    <div class="perfil-icon">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                </div>
            </div>
        </section>
        
        <div class="content-page container mt-0 mb-3">
            @yield('content')
        </div>
        <footer class="w-100 py-4 bg-white">
            <div class="text-center">
                <span class="text-muted">
                    {{ config('app.name') }} © {{ date('Y') }}
                </span>
            </div>
        </footer>
    </div>
<script src="https://cdn.jsdelivr.net/npm/jquery@4.0.0/dist/jquery.min.js" integrity="sha384-fgGyf7Mo7DURSOMnOy7ed+dkq5Job205Gnzu6QIg0BOHKaqt4D76Dt8VlDCzcMHV" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<script src="{{asset('adminlte4/js/adminlte.min.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js" integrity="sha384-O/ymMhrYXP5tgvTj27eAjKZODlpm7nIVeAkhRL7i9mdenmlJGAjstxMy/bKdklFZ" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.25/dist/sweetalert2.all.min.js" integrity="sha384-nLoOnA/BDh8A/jxqtckg4DumuCGOBYUnNJLZdQz/zfYNp3wcjGSoWTAzgko06G/2" crossorigin="anonymous"></script>


<script src="https://cdn.jsdelivr.net/npm/datatables.net@3.1.3/js/dataTables.min.js" integrity="sha384-2VkhZZqhleNsGIa6GcWWRJn09k3lpejTs0B2LzDbeU/YSNfr6nKAnRTgasXvxWc3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@3.1.3/js/dataTables.bootstrap5.min.js" integrity="sha384-4d8X9sr6Gnv9AgIQn6bv3lmQxj5fD+9bVAun0/XMmdy7oPRvT0adfiUUiiYpi4Ck" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-responsive@4.1.1/js/dataTables.responsive.min.js" integrity="sha384-PQkuArYpt1S0q5TqF/LnSkmadKwFyLBnPgdKgxfzpZy+h8UOk/jF3895MC6ZbHof" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-responsive-bs5@4.1.1/js/responsive.bootstrap5.min.js" integrity="sha384-knw38sH7qpV3KrjATT6pxZQbU/X2YxbvSTFx8RSBVmc5KndzK7iStdfQiNUs0nnd" crossorigin="anonymous"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('logoutForm');
    const button = document.getElementById('logoutButton');

    if (!form || !button) {
        return;
    }

    let enviando = false;

    form.addEventListener('submit', function (event) {

        // Si ya se está enviando, impedir otro envío
        if (enviando) {
            event.preventDefault();
            return false;
        }

        enviando = true;

        // Deshabilitar botón
        button.disabled = true;

        // Cambiar texto
        document.getElementById('logoutText').textContent = 'Saliendo...';

        // Cambiar icono
        const icon = document.getElementById('logoutIcon');
        icon.classList.remove('fa-sign-out-alt');
        icon.classList.add('fa-spinner', 'fa-spin');
    });

});
</script>

    
@livewireScripts
@stack('scripts')   
    
<script>
document.addEventListener('livewire:init', () => {
    Livewire.on('folio-generado', (event) => {
        document.getElementById('folio-aspirante').textContent = event.folio;
    });
});
</script>

</body>
</html>
