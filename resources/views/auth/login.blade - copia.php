<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

```
<title>{{ config('app.name') }} - Iniciar Sesión</title>

 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet" integrity="sha384-nRgPTkuX86pH8yjPJUAFuASXQSSl2/bBUiNV47vSYpKFxHJhbcrGnmlYpYJMeD7a" crossorigin="anonymous">

<style>

    body{
        min-height:100vh;
        background: linear-gradient(135deg,#E22275,#E22275,#E22275);
        display:flex;
        align-items:center;
        justify-content:center;
        padding:20px;
    }

    .login-card{
        border:none;
        border-radius:25px;
        overflow:hidden;
        backdrop-filter: blur(10px);
        background:#fff;
    }

    .login-left{
        background:linear-gradient(135deg,#ffffff 0%, #f5f5f5 55%, #d9d9d9 100%);
        color:#222;
        padding:50px;
        height:100%;
    }


    .login-right{
        padding:50px;
    }

    .brand-logo{
        width:90px;
        height:90px;
        border-radius:50%;
        background:white;
        color:#2563eb;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:40px;
        margin-bottom:20px;
    }

    .form-control{
        height:55px;
        border-radius:12px;
    }

    .btn-login{
        height:55px;
        border-radius:12px;
        font-weight:600;
        background-color: #6209d6 !important;
        color: #ffffff !important;
    }

    .form-icon{
        position:relative;
    }

    .form-icon i{
        position:absolute;
        top:18px;
        left:15px;
        color:#6c757d;
    }

    .form-icon input{
        padding-left:45px;
    }

    .copyright{
        color:white;
        text-align:center;
        margin-top:20px;
    }

    @media(max-width:768px){

        .login-left{
            display:none;
        }

        .login-right{
            padding:30px;
        }

    }

</style>

</head>

<body>

<div class="container">

```
<div class="row justify-content-center">

    <div class="col-lg-10">

        <div class="card shadow-lg login-card">

            <div class="row g-0">

                <div class="col-lg-5">

                    <div class="login-left">

                        <div class="brand-logo">
                            <i class="fas fa-shield-alt"></i>
                        </div>

                        <h2 class="fw-bold mb-3">
                            {{ config('app.name') }}
                        </h2>

                        <p class="lead">
                            Plataforma Integral de Gestión.
                        </p>

                        <hr>

                        <div class="mt-4">

                            <p>
                                <i class="fas fa-check-circle"></i>
                                Acceso seguro
                            </p>

                            <p>
                                <i class="fas fa-check-circle"></i>
                                Roles y permisos
                            </p>

                            <p>
                                <i class="fas fa-check-circle"></i>
                                Multi organización
                            </p>

                            <p>
                                <i class="fas fa-check-circle"></i>
                                Administración centralizada
                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-lg-7">

                    <div class="login-right">

                        <div class="text-center mb-4">

                            <h3 class="fw-bold">
                                Bienvenido
                            </h3>

                            <p class="text-muted">
                                Ingrese sus credenciales para continuar
                            </p>

                        </div>

                        @if(session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">

                                <label class="form-label">
                                    Correo Electrónico
                                </label>

                                <div class="form-icon">

                                    <i class="fas fa-envelope"></i>

                                    <input
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        class="form-control"
                                        placeholder="correo@empresa.com"
                                        required
                                        autofocus>

                                </div>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">
                                    Contraseña
                                </label>

                                <div class="form-icon">

                                    <i class="fas fa-lock"></i>

                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control"
                                        placeholder="********"
                                        required>

                                </div>

                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">

                                <div class="form-check">

                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="remember"
                                        id="remember">

                                    <label class="form-check-label" for="remember">
                                        Recordarme
                                    </label>

                                </div>

                                @if(Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">
                                        ¿Olvidó su contraseña?
                                    </a>
                                @endif

                            </div>

                            <div class="d-grid mb-3">

                                <button
                                    type="submit"
                                    class="btn btn-primary btn-login">

                                    <i class="fas fa-sign-in-alt"></i>
                                    Iniciar Sesión

                                </button>

                            </div>

                        </form>

                        <div class="text-center">

                            <span class="text-muted">
                                ¿No tiene cuenta?
                            </span>

                            <a
                                href="{{ route('register') }}"
                                class="btn btn-outline-primary ms-2">

                                Registrarse

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
```

</div>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
</html>
