<div>
    <style>
        .btn-guardar{
            background:linear-gradient(135deg,#673AB7,#512DA8);
            border:none;
            color:white;
            font-weight:600;
            box-shadow:0 4px 10px rgba(103,58,183,.35);
            transition:.25s ease;
        }
        .btn-guardar:hover{
            background:linear-gradient(135deg,#512DA8,#4527A0);
            color:white;
            transform:translateY(-2px);
            box-shadow:0 6px 14px rgba(103,58,183,.45);
        }
        /* cuando Livewire esta procesando */
        .btn-guardar:disabled{
            background:linear-gradient(135deg,#9575CD,#7E57C2);
            color:white;
            cursor:not-allowed;
            transform:none;
            box-shadow:none;
        }
    </style>
    @if(session()->has('mensaje'))
    <div class="alert alert-success">
        {{session('mensaje')}}
    </div>
    @endif
    <div class="row">
        <div class="col-md-12 mb-2">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="fw-bold mb-1">
                        <i class="fa-solid fa-list-check text-primary me-2"></i>
                        Datos por registrar
                    </h5>
                    <small class="text-muted">
                        Consulta y edita los registros capturados
                    </small>
                    <small class="text-muted d-block mt-1">
                        <i class="fa-solid fa-asterisk text-danger me-1"></i>
                        Campos obligatorios para completar el registro.
                    </small>
                    <small class="text-black d-block mt-2">
                        <i class="fa-solid fa-circle-info me-1"></i>
                        <strong>Opcional:</strong> si cuenta con esta información puede
                        registrarla, en caso contrario omita el módulo y
                        regrese al inicio. Si registra información, deberá
                        comprobarla en el módulo de Documentos.
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-4">
            <label class="form-label small text-muted">
                <i class="fa-solid fa-star text-danger" style="font-size:8px;"></i>
                Descripción de la experiencia docente
            </label>
            <textarea 
                id="descripcion_docente"
                rows="6"
                class="form-control @error('descripcion_docente') is-invalid @enderror"
                wire:model.blur="descripcion_docente"></textarea>
            @error('descripcion_docente')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-4">
        <a href="{{route('dashboard')}}"
        class="btn btn-outline-secondary btn-md px-3 rounded-2">
            <i class="fa-solid fa-arrow-left me-1"></i>
            Volver
        </a>
        <button 
            type="button" 
            class="btn btn-guardar btn-md px-4 rounded-2"
            wire:click="storeExperienciaDocente"
            wire:loading.attr="disabled">
            <span wire:loading.remove>
                <i class="fa-solid fa-floppy-disk me-1"></i>
                Guardar
            </span>
            <span wire:loading>
                <i class="fa-solid fa-spinner fa-spin me-1"></i>
                Guardando
            </span>
        </button>
    </div>
</div>

@script
<script>
// ===============================
// MENSAJES SWEETALERT
// ===============================
Livewire.on('swalExperienciasDocentes',(data)=>{
    Swal.fire({
        icon:data[0].icon,
        title:data[0].title,
        text:data[0].text,
        confirmButtonText:'Aceptar'
    });
});

</script>
@endscript