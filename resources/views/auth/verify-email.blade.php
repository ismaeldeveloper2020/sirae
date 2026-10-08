<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Verificar correo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@7.3.1/css/all.min.css" rel="stylesheet" integrity="sha384-qrALq7+6jBOZIQsNnT6xGkMDru64qD6uTlDra39xrt2SoXl4pO3FX6Roz/RpR/BS" crossorigin="anonymous">
    <style>
        body {
            min-height: 100vh;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .verify-card {
            border: none;
            border-radius: 25px;
            overflow: hidden;
            background: white;
        }

        .left-panel {
            background: linear-gradient(135deg, #ffffff 0%, #f5f5f5 55%, #d9d9d9 100%);
            color: #222;
            padding: 40px;
            height: 100%;
        }

        .right-panel {
            padding: 50px;
        }

        .logo-circle {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: white;
            color: #6209d6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin-bottom: 20px;
        }

        .btn-main {
            height: 55px;
            border-radius: 12px;
            background: #6209d6;
            color: white;
            font-weight: 600;
        }

        .btn-main:hover {
            background: #4d07aa;
            color: white;
        }

        .btn-outline {
            border-radius: 12px;
        }

        @media(max-width:768px) {
            .left-panel {
                display: none;
            }

            .right-panel {
                padding: 30px;
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg verify-card">
                    <div class="row g-0">
                        <div class="col-lg-5">
                            <div class="left-panel h-100">
                                <div class="logo-circle">
                                    <i class="fas fa-envelope-circle-check"></i>
                                </div>
                                <h2 class="fw-bold">
                                    {{ config('app.name') }}
                                </h2>
                                <p class="lead">
                                    Confirmación de cuenta
                                </p>
                                <hr>
                                <p style="text-align:justify">
                                    <i class="fas fa-check-circle"></i>
                                    Para proteger tu cuenta necesitamos confirmar tu correo electrónico.
                                    Revisa tu bandeja de entrada y da clic en el enlace de activación
                                    que enviamos.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="right-panel">
                                <div class="text-center mb-4">
                                    <h3 class="fw-bold">
                                        Verifica tu correo
                                    </h3>
                                    <p class="text-muted">
                                        Antes de continuar confirma tu dirección de correo electrónico.
                                    </p>
                                </div>
                                @if (session('status') == 'verification-link-sent')
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i>
                                    Se envió un nuevo enlace de verificación a tu correo.
                                </div>
                                @endif
                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf
                                    <div class="d-grid mb-3">
                                        <button type="submit" class="btn btn-main">
                                            <i class="fas fa-paper-plane"></i>
                                            Reenviar correo de activación
                                        </button>
                                    </div>
                                </form>
                                <div class="text-center mt-4">
                                    {{--
                                <a href="{{ route('profile.show') }}"
                                    class="btn btn-outline-primary btn-outline">
                                    <i class="fas fa-user"></i>
                                    Editar perfil
                                    </a>
                                    --}}
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-outline ms-2">
                                            <i class="fas fa-right-from-bracket"></i>
                                            Cerrar sesión
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3 text-white">
                    {{ config('app.name') }} © {{ date('Y') }}
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
