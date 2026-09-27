<div class="container-fluid py-4">



@push('styles')


<style>


.dt-container{

    padding:15px;

}



.dt-layout-row{

    display:flex;

    justify-content:space-between;

    align-items:center;

    flex-wrap:wrap;

    gap:15px;

    margin-bottom:15px;

}





/* BUSCADOR */

.dt-search{

    display:flex;

    align-items:center;

    gap:10px;

}



.dt-search label{

    font-weight:600;

    color:#495057;

    margin:0;

}



.dt-search input[type="search"]{

    width:260px !important;

    height:38px !important;

    padding:6px 14px !important;

    background:#fff !important;

    border:1px solid #ced4da !important;

    border-radius:8px !important;

    outline:none !important;

    box-shadow:none !important;

}



.dt-search input[type="search"]:focus{

    border-color:#86b7fe !important;

    box-shadow:0 0 0 .15rem rgba(13,110,253,.15) !important;

}







/* SELECT */

.dt-length{

    display:flex;

    align-items:center;

    gap:10px;

}


.dt-length label{

    font-weight:600;

    margin:0;

}



.dt-length select{

    height:38px !important;

    border-radius:8px !important;

    border:1px solid #ced4da !important;

}






/* TABLA */

table.dataTable thead th{

    background:#f8f9fa;

    font-weight:700;

    white-space:nowrap;

}



table.dataTable tbody tr:hover{

    background:#f8fbff !important;

}





/* PAGINACION */


.dt-paging .page-link{

    width:38px;

    height:38px;

    border-radius:50% !important;

    display:flex;

    justify-content:center;

    align-items:center;

    margin:0 3px;

}



.dt-paging .active .page-link{

    background:#0d6efd !important;

    border-color:#0d6efd !important;

}




@media(max-width:768px){


.dt-layout-row{

    flex-direction:column;

    align-items:flex-start;

}


.dt-search input[type="search"]{

    width:100% !important;

}


}



</style>


@endpush







@if(session('status'))


<div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3">


<i class="bi bi-check-circle-fill me-2"></i>


{{ session('status') }}


<button class="btn-close" data-bs-dismiss="alert"></button>


</div>


@endif








{{-- CREAR ORGANIZACIÓN --}}



<div class="card shadow border-0 rounded-4 mb-4">



<div class="card-header text-white rounded-top-4"
style="background:linear-gradient(135deg,#0d6efd,#4f8cff);">


<h5 class="mb-0">


<i class="bi bi-building-add me-2"></i>


Crear organización


</h5>


</div>






<form wire:submit.prevent="create">



<div class="card-body p-4">



<div class="row g-3">



<div class="col-md-12">



<label class="form-label fw-semibold">


<i class="bi bi-building me-1"></i>


Nombre de la organización


</label>




<input


type="text"


class="form-control form-control-lg rounded-3"


placeholder="Ejemplo: Empresa ABC"


wire:model.defer="nombre"


>



@error('nombre')


<small class="text-danger">


{{ $message }}


</small>


@enderror



</div>


</div>



</div>






<div class="card-footer bg-white border-0 text-center pb-4">


<button class="btn btn-primary px-5 py-2 rounded-pill shadow">


<i class="bi bi-save me-2"></i>


Guardar organización


</button>



</div>



</form>



</div>









{{-- TABLA ORGANIZACIONES --}}



<div class="card shadow border-0 rounded-4">



<div class="card-header d-flex justify-content-between align-items-center">



<h5 class="mb-0">


<i class="bi bi-buildings-fill me-2"></i>


Organizaciones registradas


</h5>



<span class="badge bg-primary rounded-pill px-3">


{{ count($organizaciones) }}


</span>



</div>







<div class="card-body">


<div class="table-responsive">



<table 

id="organizacionesTable"

class="table table-hover align-middle nowrap"

style="width:100%">



<thead class="table-light">


<tr>


<th>

#

</th>


<th>

Nombre

</th>


<th class="text-center">

Acción

</th>


</tr>


</thead>






<tbody>



@foreach($organizaciones as $org)



<tr>



<td class="fw-bold">


{{ $org->id }}


</td>







<td>



<div class="d-flex align-items-center">


<div 

class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-3"

style="width:42px;height:42px;">


<i class="bi bi-building"></i>


</div>




<strong>


{{ $org->nombre ?? '' }}


</strong>



</div>



</td>







<td class="text-center">


<button


wire:click="delete({{ $org->id }})"


onclick="return confirm('¿Eliminar organización?')"


class="btn btn-outline-danger btn-sm rounded-circle"


>


<i class="bi bi-trash"></i>


</button>


</td>




</tr>



@endforeach



</tbody>



</table>



</div>


</div>


</div>









@push('scripts')


<script>


document.addEventListener('livewire:init',()=>{


let table;



function cargarOrganizaciones(){



if(table){

table.destroy();

}




table = $('#organizacionesTable').DataTable({


responsive:true,


autoWidth:false,


pageLength:10,



lengthMenu:[

[5,10,25,50,-1],

[5,10,25,50,"Todos"]

],




language:{


search:"Buscar:",


lengthMenu:"Mostrar _MENU_ registros",


info:"Mostrando _START_ a _END_ de _TOTAL_",


zeroRecords:"No hay organizaciones registradas",



paginate:{


previous:"‹",

next:"›"


}


},



columnDefs:[


{

targets:2,

orderable:false

}


]


});



}



cargarOrganizaciones();





Livewire.hook('morph.updated',()=>{


cargarOrganizaciones();


});



});



</script>


@endpush



</div>