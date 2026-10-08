<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Registro</title>
    
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

        .register-card {
            border: none;
            border-radius: 25px;
            overflow: hidden;
            background: #fff;
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
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin-bottom: 20px;
        }

        .form-control {
            height: 55px;
            border-radius: 12px;
        }

        .btn-register {
            height: 55px;
            border-radius: 12px;
            font-weight: 600;
            background-color: #6209d6 !important;
            color: #ffffff !important;
        }

        .form-icon {
            position: relative;
        }

        .form-icon i {
            position: absolute;
            left: 15px;
            top: 18px;
            color: #6c757d;
        }

        .form-icon input {
            padding-left: 45px;
        }

        .copyright {
            color: white;
            text-align: center;
            margin-top: 20px;
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
            <div class="col-lg-11">
                <div class="card shadow-lg register-card">
                    <div class="row g-0">
                        <div class="col-lg-5">
                            <div class="left-panel h-100">
                                <div class="logo-circle">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <h2 class="fw-bold">
                                    {{ config('app.name') }}
                                </h2>
                                <p class="lead">
                                    Cree una cuenta para acceder al sistema.
                                </p>
                                <hr>
                                <p style="text-align: justify;"><i class="fas fa-check-circle"></i>
                                    Cree su cuenta en el SIRAE para iniciar su proceso
                                    de registro como aspirante y acceder a la
                                    convocatoria para participar como enlace distrital o
                                    municipal. A través de esta plataforma podrá
                                    completar su información personal, gestionar su
                                    postulación, consultar los procesos habilitados y
                                    dar seguimiento a las etapas correspondientes de
                                    manera segura, sencilla y organizada. Su registro le
                                    permitirá formar parte del proceso de selección.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="right-panel">
                                <div class="text-center mb-4">
                                    <h3 class="fw-bold">
                                        Crear cuenta
                                    </h3>
                                    <p class="text-muted">
                                        Complete la información para registrarse
                                    </p>
                                </div>
                                @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <div class="form-icon">
                                            <i class="fas fa-user"></i>
                                            <input type="text" name="nombre" placeholder="Nombre(s) completo" class="form-control" value="{{ old('nombre') }}" required autofocus>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-icon">
                                            <i class="fas fa-user"></i>
                                            <input type="text" name="apaterno" placeholder="Primer apellido" class="form-control" value="{{ old('apaterno') }}" required autofocus>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-icon">
                                            <i class="fas fa-user"></i>
                                            <input type="text" name="amaterno" placeholder="Segundo apellido" class="form-control" value="{{ old('amaterno') }}" required autofocus>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-icon">
                                            <i class="fas fa-envelope"></i>
                                            <input type="email" name="email" placeholder="correo@gmail.com" class="form-control" value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-icon">
                                            <i class="fas fa-lock"></i>
                                            <input type="password" name="password" placeholder="Contraseña" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-icon">
                                            <i class="fas fa-lock"></i>
                                            <input type="password" placeholder="Confirmar contraseña" name="password_confirmation" class="form-control" required>
                                        </div>
                                    </div>
                                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                        <label class="form-check-label" for="terms">
                                            Acepto los
                                            <a target="_blank" href="{{ route('terms.show') }}">
                                                Términos de Servicio
                                            </a>
                                            y la
                                            <a target="_blank" href="{{ route('policy.show') }}">
                                                Política de Privacidad
                                            </a>
                                        </label>
                                    </div>
                                    @endif
                                    <div class="d-grid mb-3">
                                        <button type="submit" class="btn btn-primary btn-register">
                                            <i class="fas fa-user-plus"></i>
                                            Crear Cuenta
                                        </button>
                                    </div>
                                </form>
                                <div class="text-center">
                                    <span class="text-muted">
                                        ¿Ya tiene una cuenta?
                                    </span>
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary ms-2">
                                        Iniciar Sesión
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="copyright">
                    {{ config('app.name') }} © {{ date('Y') }}
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
