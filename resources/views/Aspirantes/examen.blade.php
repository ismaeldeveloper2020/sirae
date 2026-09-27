@extends('layouts.aspirante')

@section('title','Examen aspirante')

@section('content')

<div class="container-fluid">
    <!-- Tarjeta de usuario -->
    <!-- Contenido Livewire -->
    <div class="card border-0 shadow-sm mt-0 w-100">
        <div class="card-body p-4">
            <livewire:aspirantes.examen />
        </div>
    </div>
</div>

@endsection