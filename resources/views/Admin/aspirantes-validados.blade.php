@extends('layouts.admin')

@section('title','Aspirantes con validación')

@section('content')

<div class="container-fluid m-0 p-0">

    <div class="card card-primary card-outline shadow-lg border-0">

        <div class="card-header bg-white border-bottom">
            <div class="d-flex align-items-center">

                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="width:45px;height:45px;">
                    <i class="bi bi-card-checklist fs-4"></i>
                </div>

                <div>
                    <h3 class="card-title fw-bold mb-0">
                        Aspirantes con validación
                    </h3>
                    <br>
                    <small class="text-muted">
                        Consulte y administre la información de los aspirantes con validación.
                    </small>
                </div>

            </div>
        </div>

        <div class="card-body p-0">

            @livewire('admin.index-aspirantes-validados')

        </div>


    </div>

</div>

@endsection