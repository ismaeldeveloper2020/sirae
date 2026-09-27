@extends('layouts.admin')

@section('title','Usuarios')

@section('content')

<div class="container-fluid">

    <div class="card card-primary card-outline shadow-lg border-0">

        <div class="card-header bg-white border-bottom">
            <div class="d-flex align-items-center">

                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                     style="width:45px;height:45px;">
                    <i class="bi bi-people-fill fs-4"></i>
                </div>

                <div>
                    <h3 class="card-title fw-bold mb-0">
                       Lista de usuarios
                    </h3>
                </div>

            </div>
        </div>


        <div class="card-body p-4">

            @livewire('usuarios.index')

        </div>


    </div>

</div>

@endsection