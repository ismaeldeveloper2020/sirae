<div>
   
<style>

/* NAV TABS CONTENEDOR */
.nav-tabs {
    border-bottom: 1px solid #e0e0e0;
    background: #ffffff;
    padding: 6px;
    border-radius: 10px;
}

/* TAB BASE */
.nav-tabs .nav-link {
    border-radius: 8px;
    color: #555;
    font-weight: 600;
    padding: 12px 18px;
    margin: 0 4px;
    border: none;
    transition: all 0.25s ease-in-out;
}

/* HOVER */
.nav-tabs .nav-link:hover {
    background: rgba(103, 58, 183, 0.08); /* morado suave */
    color: #673AB7;
}

/* ACTIVO */
.nav-tabs .nav-link.active {
    background: #673AB7;
    color: #fff;
    box-shadow: 0 6px 16px rgba(103, 58, 183, 0.25);
}

/* FOCUS */
.nav-tabs .nav-link:focus {
    box-shadow: none;
}

/* OPCIONAL: efecto más limpio en responsive */
.nav-tabs.nav-fill .nav-link {
    text-align: center;
}
</style>

    <ul class="nav nav-tabs nav-fill">

        <li class="nav-item">
            <button
                class="nav-link active"
                data-bs-toggle="tab"
                data-bs-target="#generales"
                type="button">
                <i class="bi bi-person me-1"></i>
                Generales
            </button>
        </li>

        <li class="nav-item">
            <button
                id="curriculum-tab"
                class="nav-link"
                data-bs-toggle="tab"
                data-bs-target="#curriculum"
                type="button">
                <i class="bi bi-file-earmark-text me-1"></i>
                Currículum
            </button>
        </li>

        <li class="nav-item">
            <button
                id="archivos-tab"
                class="nav-link"
                data-bs-toggle="tab"
                data-bs-target="#archivos"
                type="button">
                <i class="bi bi-folder2-open me-1"></i>
                Archivos
            </button>
        </li>

    </ul>

   <div class="tab-content pt-3" wire:ignore.self>

        <div class="tab-pane fade show active" id="generales">
            <livewire:aspirantes.generales
                :user_id="$user_id"
                :key="'generales-editar-'.$user_id"/>
        </div>

        <div class="tab-pane fade" id="curriculum">

            @if($loadCurriculum)

                <livewire:aspirantes.curriculums
                    :user_id="$user_id"
                    :key="'curriculum-editar-'.$user_id"/>

            @endif

        </div>

        <div class="tab-pane fade" id="archivos">

            @if($loadArchivos)

                <livewire:aspirantes.archivos
                    :user_id="$user_id"
                    :key="'archivos-editar-'.$user_id"/>

            @endif

        </div>

    </div>

</div>

@push('scripts')
<script>

document.addEventListener('livewire:init', () => {

    let tabActivo = 'generales';

    document.getElementById('curriculum-tab')
        ?.addEventListener('shown.bs.tab', () => {

            tabActivo = 'curriculum';
            Livewire.dispatch('load-curriculum');

        });

    document.getElementById('archivos-tab')
        ?.addEventListener('shown.bs.tab', () => {

            tabActivo = 'archivos';
            Livewire.dispatch('load-archivos');

        });

    Livewire.hook('morphed', () => {

        const btn = document.querySelector(
            `[data-bs-target="#${tabActivo}"]`
        );

        if (btn) {
            bootstrap.Tab.getOrCreateInstance(btn).show();
        }

    });

});

</script>
@endpush