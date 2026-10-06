<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Ciudadano</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" integrity="sha384-lQM68ivKBOfXgJDga3JtrfUEh8B2uRHapweBL5h4+Dz79cLzvpVQ5pDQbFa9Mlh4" crossorigin="anonymous" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-white">
        <div class="min-h-screen">
            <nav class="bg-blue-600 text-white p-4">
                <div class="max-w-7xl mx-auto flex items-center justify-between">
                    <a href="/" class="font-semibold">{{ config('app.name', 'Laravel') }}</a>
                    <div>
                        @auth
                            <span class="mr-4">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="underline">Salir</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </nav>

            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-2xl font-semibold text-gray-900">Área Ciudadano</h1>
                </div>
            </header>

            <main class="py-6">
                <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>

        @stack('modals')
        @livewireScripts
    </body>
</html>
