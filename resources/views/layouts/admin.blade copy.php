<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Panel Administrativo')</title>

    <link rel="stylesheet" href="{{ asset('adminlte4/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha384-nRgPTkuX86pH8yjPJUAFuASXQSSl2/bBUiNV47vSYpKFxHJhbcrGnmlYpYJMeD7a" crossorigin="anonymous">

    @livewireStyles

    <style>
        body {
            background-color: #f4f6f9;
        }

        .app-content {
            padding: 1rem;
        }

        .page-title {
            font-weight: 600;
            margin-bottom: 0;
        }

        .card {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, .075);
        }

        .brand-text {
            font-weight: 600;
        }

        .breadcrumb {
            margin-bottom: 0;
        }
    </style>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    {{-- Navbar --}}
    @include('layouts.partials.navbar')

    {{-- Sidebar --}}
    @include('layouts.partials.sidebar')

    {{-- Main --}}
    <main class="app-main">

        {{-- Encabezado --}}
        <div class="app-content-header">
            <div class="container-fluid">

                <div class="row align-items-center mb-3">

                    <div class="col-sm-6">
                        <h1 class="page-title">
                            @yield('title', 'Dashboard')
                        </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Inicio
                                </a>
                            </li>

                            <li class="breadcrumb-item active">
                                @yield('title', 'Dashboard')
                            </li>
                        </ol>
                    </div>

                </div>

            </div>
        </div>

        {{-- Contenido --}}
        <div class="app-content">
            <div class="container-fluid">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert">
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert">
                        </button>
                    </div>
                @endif

                @yield('content')

            </div>
        </div>

    </main>

    {{-- Footer --}}
    @include('layouts.partials.footer')

</div>

<script src="{{ asset('adminlte4/js/adminlte.min.js') }}"></script>

@livewireScripts

@stack('scripts')

</body>
</html>
