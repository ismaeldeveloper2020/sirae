@extends('layouts.admin')
@section('title','Dashboard')
@section('content')
<div class="container-fluid">
    {{-- HEADER --}}
    <div class="card shadow border-0 rounded-4 mb-4 overflow-hidden">
        <div class="card-body p-4 text-white" style="background:linear-gradient(135deg,#884188,#884188)">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <h2 class="fw-bold">
                        <i class="bi bi-speedometer2 me-2"></i>
                        Panel Principal
                    </h2>

                    <h5>
                        Bienvenido al <strong>SIRAE</strong> (Sistema de Registro de Aspirantes a Enlaces Distritales y Municipales).
                    </h5>

                    <p class="opacity-75 mb-0" style="text-align: justify;">
                        Desde este panel podrá administrar y dar seguimiento a todo el proceso de registro de los aspirantes, consultar su información, validar la documentación presentada, realizar requerimientos, generar su Currículum Vitae (CV), el acuse de registro y la constancia de validación. Además, podrá monitorear el avance de los registros por distrito y municipio mediante las herramientas de seguimiento y control del sistema.
                    </p>
                </div>
            </div>
        </div>
    </div>
    {{-- TARJETAS --}}
    <div class="row g-4 mb-4">
        {{-- TOTAL --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100">
                <div class="card-body">
                    <div class="rounded-circle bg-primary-subtle mx-auto d-flex align-items-center justify-content-center" style="width:75px;height:75px">
                        <i class="fa fa-users text-primary fa-2x"></i>
                    </div>
                    <h1 class="fw-bold mt-3 text-primary">
                        {{$total}}
                    </h1>
                    <p class="text-muted mb-0">
                        Total registros
                    </p>
                </div>
            </div>
        </div>
        {{-- HOMBRES --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100">
                <div class="card-body">
                    <div class="rounded-circle bg-info-subtle mx-auto d-flex align-items-center justify-content-center" style="width:75px;height:75px">
                        <i class="fa fa-mars text-info fa-2x"></i>
                    </div>
                    <h1 class="fw-bold mt-3 text-info">
                         {{$hombres}}
                    </h1>
                    <p class="text-muted mb-0">
                        Hombres
                    </p>
                </div>
            </div>
        </div>
        {{-- MUJERES --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100">
                <div class="card-body">
                    <div class="rounded-circle bg-danger-subtle mx-auto d-flex align-items-center justify-content-center" style="width:75px;height:75px">
                        <i class="fa fa-venus text-danger fa-2x"></i>
                    </div>
                    <h1 class="fw-bold mt-3 text-danger">
                         {{$mujeres}}
                    </h1>
                    <p class="text-muted mb-0">
                        Mujeres
                    </p>
                </div>
            </div>
        </div>
        {{-- NO BINARIO --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100">
                <div class="card-body">
                    <div class="rounded-circle bg-warning-subtle mx-auto d-flex align-items-center justify-content-center" style="width:75px;height:75px">
                        <i class="fa fa-transgender text-warning fa-2x"></i>
                    </div>
                    <h1 class="fw-bold mt-3 text-warning">
                         {{$noBinario}}
                    </h1>
                    <p class="text-muted mb-0">
                        No binario
                    </p>
                </div>
            </div>
        </div>
    </div>
    {{-- ESTADOS --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow border-0 rounded-4 text-center">
                <div class="card-body">
                    <h6>
                        Validados
                    </h6>
                    <h2 class="fw-bold">
                        {{ $validadosTotal ?? 0}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow border-0 rounded-4 text-center">
                <div class="card-body">
                    <h6>
                        Designados
                    </h6>
                    <h2 class="fw-bold">
                        {{ $designadosTotal ?? 0}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow border-0 rounded-4 text-center">
                <div class="card-body">
                    <h6>
                        Con requerimiento
                    </h6>
                    <h2 class="fw-bold">
                        {{ $conRequerimientoTotal ?? 0}}
                    </h2>
                </div>
            </div>
        </div>

    </div>
    {{-- GRAFICAS PRINCIPALES --}}
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header fw-bold">
                    <i class="fa fa-chart-pie text-primary"></i>
                    Estados
                </div>
                <div class="card-body">
                    <div id="graficaEstados"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header fw-bold">
                    <i class="fa fa-venus-mars"></i>
                    Sexo
                </div>
                <div class="card-body">
                    <div id="graficaSexo"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4 mt-1">
        <div class="col-md-12">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header fw-bold">
                    <i class="fa fa-map"></i>
                    Registros por distrito
                </div>
                <div class="card-body">
                    <div id="graficaDistritos"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header fw-bold">
                    <i class="fa fa-city"></i>
                    Registros por municipio
                </div>
                <div class="card-body">
                    <div id="graficaMunicipios"></div>
                </div>
            </div>
        </div>
    </div>
    {{-- TABLAS --}}
    <div class="row g-4 mt-2">
        <div class="col-md-12">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header text-white" style="background:#E22275">
                    Distritos
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover table-sm align-middle">
                        <thead>
                            <tr>
                                <th>Distrito</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">H</th>
                                <th class="text-center">M</th>
                                <th class="text-center">NB</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($distritos as $d)
                            <tr>
                                <td>{{ $d->id_distrito }} - {{ $d->municipio_local }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $d->total }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">{{ $d->hombres }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger">{{ $d->mujeres }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $d->no_binarios }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header text-white" style="background:#E22275">
                    Municipios
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover table-sm align-middle">
                        <thead>
                            <tr>
                                <th>Municipio</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">H</th>
                                <th class="text-center">M</th>
                                <th class="text-center">NB</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($municipios as $m)
                            <tr>
                                <td>{{ $m->id_municipio }} {{ $m->municipio_local }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $m->total }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">{{ $m->hombres }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger">{{ $m->mujeres }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $m->no_binarios }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', () => {

    const distritos = @json($distritos);
    const municipios = @json($municipios);

    const distritosEl = document.querySelector("#graficaDistritos");
    const municipiosEl = document.querySelector("#graficaMunicipios");

    // =========================
    // DISTRITOS
    // =========================
    if (distritosEl && distritos.length) {

        new ApexCharts(distritosEl, {
            chart: {
                type: 'bar'
                //height: Math.max(400, distritos.length * 30)
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    barHeight: '60%'
                }
            },
            series: [{
                name: 'Registros',
                data: distritos.map(d => Number(d.total ?? 0))
            }],
            xaxis: {
                categories: distritos.map(d =>
                    `${d.id_distrito} - ${d.municipio_local}`
                )
            },
            grid: {
                padding: { left: 180 }
            },
            dataLabels: { enabled: false }
        }).render();
    }

    // =========================
    // MUNICIPIOS
    // =========================
    if (municipiosEl && municipios.length) {

        new ApexCharts(municipiosEl, {
            chart: {
                type: 'bar',
                height: Math.max(400, municipios.length * 28)
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    barHeight: '45%'
                }
            },
            series: [{
                name: 'Registros',
                data: municipios.map(m => Number(m.total ?? 0))
            }],
            xaxis: {
                categories: municipios.map(m =>
                    `[${m.id_municipio}] ${m.municipio_local}`
                )
            },
            grid: {
                padding: { left: 120, bottom: 30 }
            },
            dataLabels: { enabled: false }
        }).render();
    }

});
</script>
@endpush