<div class="card border-0 shadow-sm">
    <style>
        .nav-pills .nav-link {
            color: #6c757d;
            background: #f8f9fa;
            border-radius: 12px;
            padding: 10px 12px;
            font-weight: 600;
            transition: .3s;
        }
        .nav-pills .nav-link:hover {
            background: #495057;
            color: white;
            transform: translateY(-2px);
        }
        .nav-pills .nav-link.active {
            background: #343a40;
            color: white;
        }
        .nav-pills .nav-link.completo {
            background: linear-gradient(135deg, #E22275, #b71859);
            color: white;
        }
        .check-completo {
            color: white;
            margin-left: 8px;
        }
    </style>
    <div class="card-header bg-white border-0 pt-1">
        <ul class="nav nav-pills nav-fill gap-1">
            <li class="nav-item">
                <button wire:click="cambiarTab('academico')" class="nav-link 
                    {{ $tabActivo=='academico'?'active':'' }}
                    {{ $checkAcademicos?'completo':'' }}">
                    <i class="fa-solid fa-graduation-cap me-2"></i>
                    Académico
                    @if($checkAcademicos)
                    <i class="fa-solid fa-circle-check check-completo"></i>
                    @endif
                </button>
            </li>
            <li class="nav-item">
                <button wire:click="cambiarTab('laboral')" class="nav-link
                {{ $tabActivo=='laboral'?'active':'' }}
                {{ $checkLaborales?'completo':'' }}">
                    <i class="fa-solid fa-briefcase me-2"></i>
                    Experiencia laboral
                    @if($checkLaborales)
                    <i class="fa-solid fa-circle-check check-completo"></i>
                    @endif
                </button>
            </li>
            <li class="nav-item">
                <button wire:click="cambiarTab('docente')" class="nav-link
                {{ $tabActivo=='docente'?'active':'' }}
                {{ $checkDocentes?'completo':'' }}">
                    <i class="fa-solid fa-chalkboard-user me-2"></i>
                    Experiencia docente
                    @if($checkDocentes)
                    <i class="fa-solid fa-circle-check check-completo"></i>
                    @endif
                </button>
            </li>
            <li class="nav-item">
                <button wire:click="cambiarTab('experiencia')" class="nav-link
                {{ $tabActivo=='experiencia'?'active':'' }}
                {{ $checkElectorales?'completo':'' }}">
                    <i class="fa-solid fa-book me-2"></i>
                    Experiencia electoral
                    @if($checkElectorales)
                    <i class="fa-solid fa-circle-check check-completo"></i>
                    @endif
                </button>
            </li>
            <li class="nav-item">
                <button wire:click="cambiarTab('conocimiento')" class="nav-link
                {{ $tabActivo=='conocimiento'?'active':'' }}
                {{ $checkConocimientos?'completo':'' }}">
                    <i class="fa-solid fa-landmark me-2"></i>
                    Conocimiento electoral
                    @if($checkConocimientos)
                    <i class="fa-solid fa-circle-check check-completo"></i>
                    @endif
                </button>
            </li>
        </ul>
    </div>
    <div class="card-body p-4">
        @if($tabActivo=='academico')
            <livewire:aspirantes.curriculum-datos-academicos :key="'academico'" />
        @endif
        @if($tabActivo=='laboral')
            <livewire:aspirantes.curriculum-experiencias-laborales :key="'laboral'" />
        @endif
        @if($tabActivo=='docente')
            <livewire:aspirantes.curriculum-experiencias-docentes :key="'docente'" />
        @endif
        @if($tabActivo=='experiencia')
            <livewire:aspirantes.curriculum-experiencias-electorales :key="'experiencia'" />
        @endif
        @if($tabActivo=='conocimiento')
            <livewire:aspirantes.curriculum-conocimientos-electorales :key="'conocimiento'" />
        @endif
    </div>
</div>
