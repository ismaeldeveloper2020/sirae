<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card-reset {
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

        .btn-reset {
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
            top: 18px;
            left: 15px;
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
            <div class="col-lg-10">
                <div class="card shadow-lg card-reset">
                    <div class="row g-0">
                        <div class="col-lg-5">
                            <div class="left-panel h-100">
                                <div class="logo-circle">
                                    <i class="fas fa-key"></i>
                                </div>
                                <h2 class="fw-bold">
                                    {{ config('app.name') }}
                                </h2>
                                <p class="lead">
                                    Restablecimiento seguro de contraseña.
                                </p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="right-panel">
                                <div class="text-center mb-4">
                                    <h3 class="fw-bold">
                                        Restablecer Contraseña
                                    </h3>
                                    <p class="text-muted">
                                        Ingrese una nueva contraseña para su cuenta.
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
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Correo Electrónico
                                        </label>
                                        <div class="form-icon">
                                            <i class="fas fa-envelope"></i>
                                            <input type="email" name="email" class="form-control" value="{{ old('email', $request->email) }}" required autofocus>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Nueva Contraseña
                                        </label>
                                        <div class="form-icon">
                                            <i class="fas fa-lock"></i>
                                            <input type="password" name="password" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">
                                            Confirmar Contraseña
                                        </label>
                                        <div class="form-icon">
                                            <i class="fas fa-lock"></i>
                                            <input type="password" name="password_confirmation" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-reset">
                                            <i class="fas fa-save"></i>
                                            Restablecer Contraseña
                                        </button>
                                    </div>
                                </form>
                                <div class="text-center mt-4">
                                    <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                                        Volver al Login
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
