<?php
namespace App\Livewire\Aspirantes;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Aspirantes\Archivos as Documento;
use App\Models\Aspirantes\ArchivosSubidos;
class Archivos extends Component
{
    use WithFileUploads;
    public $id_user;
    public $archivos = [];
    public $archivosGuardados = [];
    public $reemplazo = null;
    public $subsanacion  = null;
    public $documentos = [];
    public $documentosConInformacion = [];
    public $moduloCompletado = false;
    //0 revision
    //1 requerido
    //2 subsanado
    //3 validado  todos segun el campo validado
    private function validarModulo()
    {
        if (auth()->user()->hasRole('Administrador')) {
            return;
        }

        $estatus = DB::table('padron_aspirantes_modulos')
            ->where('user_id', $this->id_user)
            ->value('modulo_registro');
        $mensajes = [
            1 => 'El proceso ya fue finalizado y se encuentra en revisión y validación de documentos. No puede realizar cambios por el momento.',
            //2 => 'Su registro tiene requerimientos pendientes de atender. Revise las observaciones y sustituya los documentos solicitados.',
            3 => 'Los documentos subsanados fueron enviados y se encuentran en revisión final. No puede realizar cambios por el momento.',
            //4 => 'Existen nuevos requerimientos pendientes de atender. Revise las observaciones y sustituya los documentos correspondientes.',
            5 => 'Su registro ha sido validado correctamente. Ya no es posible realizar modificaciones.',
        ];
        if (isset($mensajes[$estatus])) {
            session()->flash('error_modulo', $mensajes[$estatus]);
            return redirect()->route('dashboard');
        }
    }
    public function mount($user_id = null)
    {
        $this->id_user = $user_id ?? auth()->id();
        if (is_null($user_id)) {
            $this->validarModulo();
        }

        $this->cargarDocumentos();
        $this->cargarArchivos();
        $this->validarDocumentosOpcionales();
        $this->moduloCompletado =
        ArchivosSubidos::where('user_id',$this->id_user)
        ->where('modulo','EXPEDIENTE_DIGITAL')
        ->where('completado',1)
        ->exists();
    }
    public function validarDocumentosOpcionales()
    {
        $this->documentosConInformacion = [];
        $conocimiento = DB::table('padron_curriculum_conocimientos_electorales')
            ->where('user_id',$this->id_user)
            ->whereNull('deleted_at')
            ->count();
        if($conocimiento > 0){
            $this->documentosConInformacion[] =
            'Conocimiento electoral';
        }
        $experiencia = DB::table('padron_curriculum_experiencias_electorales')
            ->where('user_id',$this->id_user)
            ->whereNull('deleted_at')
            ->count();
        if($experiencia > 0){
            $this->documentosConInformacion[] =
            'Experiencia electoral';
        }
        $docencia = DB::table('padron_curriculum_experiencias_docentes')
            ->where('user_id',$this->id_user)
            ->whereNull('deleted_at')
            ->count();
        if($docencia > 0){
            $this->documentosConInformacion[] =
            'Experiencia docente';
        }
        $laborales = DB::table('padron_curriculum_experiencias_laborales')
            ->where('user_id',$this->id_user)
            ->whereNull('deleted_at')
            ->count();
        if($laborales > 0){
            $this->documentosConInformacion[] =
            'Experiencia laboral';
        }
        $laborales = DB::table('padron_curriculum_experiencias_laborales')
        ->where('user_id', $this->id_user)
        ->whereNull('deleted_at')
        ->count();
        // DATOS ACADEMICOS
        $academico = DB::table('padron_curriculum_datos_academicos')
            ->where('user_id',$this->id_user)
            ->whereNull('deleted_at')
            ->first();
        if($academico && $academico->id_nivel_estudios > 1){
            $this->documentosConInformacion[] =
            'Datos académicos';
        }
    }
    public function cargarDocumentos()
    {
        $this->documentos = DB::table('cat_documentos')
            ->where('activo',1)
            ->whereNull('deleted_at')
            ->orderBy('orden')
            ->get();
        $academico = DB::table('padron_curriculum_datos_academicos')
            ->where('user_id',$this->id_user)
            ->whereNull('deleted_at')
            ->first();
        foreach($this->documentos as $doc){
            // Documento académico
            if($doc->id == 2){
                if($academico && $academico->id_nivel_estudios > 1){
                    $doc->obligatorio = 1;
                }else{
                    $doc->obligatorio = 0;
                }
            }
        }
    }
    public function cargarArchivos()
    {
        $this->archivosGuardados=[];
        $data = Documento::where(
            'user_id',
            $this->id_user
        )->get();
        foreach($data as $item){
            $this->archivosGuardados[$item->documento_id]=$item;
        }
    }
    protected function rules()
    {
        return [
            'archivos.*'=>'nullable|file|mimes:pdf|max:5120'
        ];
    }
    public function seleccionarCambio($id)
    {
        $documento = Documento::where('user_id', $this->id_user)
            ->where('documento_id', $id)
            ->first();
        if (!$documento) {
            return;
        }
        $this->reemplazo = $id;
        $this->subsanacion = null;
    }
    public function seleccionarSubsanacion($id)
    {
        $documento = Documento::where('user_id', $this->id_user)->where('documento_id', $id)->first();
        if (!$this->moduloCompletado) {
            return;
        }
        if (!$documento || $documento->validado != 1 ||empty($documento->observacion)) {
            return;
        }
        $this->subsanacion = $id;
        $this->reemplazo = null;
    }
    public function subsanar($documento_id)
    {
        $this->validate();
        if(!isset($this->archivos[$documento_id])){
            return;
        }
        if(!$this->moduloCompletado){
            $this->dispatch(
                'alerta',
                tipo:'warning',
                titulo:'Acción no permitida',
                mensaje:'El expediente aún no ha sido finalizado.'
            );
            return;
        }
        $documento = Documento::where('user_id',$this->id_user)->where('documento_id', $documento_id)->first();
        if(!$documento){
            $this->dispatch(
                'alerta',
                tipo:'error',
                titulo:'Error',
                mensaje:'No se encontró el documento.'
            );
            return;
        }
        // Solo documentos requeridos pueden subsanarse
        if($documento->validado != 1){
            $this->dispatch(
                'alerta',
                tipo:'warning',
                titulo:'Acción no permitida',
                mensaje:'El documento no se encuentra en estado requerido.'
            );
            return;
        }
        $archivo = $this->archivos[$documento_id];
        // Eliminar archivo físico anterior
        if(
            $documento->ruta &&
            Storage::disk('public')->exists($documento->ruta)
        ){
            Storage::disk('public')->delete(
                $documento->ruta
            );
        }
        // Guardar nuevo PDF
        $ruta = $archivo->store(
            'aspirantes/documentos',
            'public'
        );
        // Actualizar el mismo registro
        $documento->update([
            'nombre' => $archivo->getClientOriginalName(),
            'ruta' => $ruta,
            'extension' => 'pdf',
            // SUBSANADO
            'validado'  => 2
        ]);
        $tieneRequerimientos = Documento::where('user_id', $this->id_user)->where('validado',1)->exists();
        $tieneSubsanados = Documento::where('user_id', $this->id_user)->where('validado',2)->exists();
        $modulo = null;
        if($tieneRequerimientos && $tieneSubsanados)
        {
            $modulo = 4;
        }
        elseif($tieneSubsanados)
        {
            $modulo = 3;
        }
        elseif($tieneSubsanados)
        {
            $modulo = 2;
        }
        if($modulo !== null){

            DB::table('padron_aspirantes_modulos')
                ->where('user_id',$this->id_user)
                ->update([
                    'modulo_registro'=>$modulo,
                    'deleted_at'=>null,
                    'updated_at'=>now()
                ]);
        }
        unset($this->archivos[$documento_id]);
        $this->subsanacion = null;
        $this->reemplazo = null;
        $this->cargarArchivos();
        $this->dispatch(
            'alerta',
            tipo:'success',
            titulo:'Documento subsanado',
            mensaje:'La documentación fue enviada nuevamente para revisión.'
        );
    }
    public function guardar($documento_id)
    {
        $this->validate();
        if(!isset($this->archivos[$documento_id])){
            return;
        }
        $archivo = $this->archivos[$documento_id];
        // Buscar archivo existente
        $anterior = Documento::where('user_id',$this->id_user)
            ->where('documento_id',$documento_id)
            ->first();
        // Eliminar archivo físico anterior
        if($anterior){
            if(
                $anterior->ruta &&
                Storage::disk('public')->exists($anterior->ruta)
            ){
                Storage::disk('public')->delete($anterior->ruta);
            }
        }
        // Guardar nuevo PDF
        $ruta = $archivo->store(
            'aspirantes/documentos',
            'public'
        );
        if($anterior){
            // Actualiza el mismo registro
            $anterior->update([
                'nombre'=>$archivo->getClientOriginalName(),
                'ruta'=>$ruta,
                'extension'=>'pdf',
                'validado'=>0,
                'observacion'=>null
            ]);
        }else{
            // Si no existe crea uno nuevo
            Documento::create([
                'user_id'=>$this->id_user,
                'documento_id'=>$documento_id,
                'nombre'=>$archivo->getClientOriginalName(),
                'ruta'=>$ruta,
                'extension'=>'pdf',
                'validado'=>0,
                'observacion'=>null
            ]);
        }
        unset($this->archivos[$documento_id]);
        $this->subsanacion = null;
        $this->reemplazo = null;
        $this->cargarArchivos();
        $this->dispatch(
            'alerta',
            tipo:'success',
            titulo:'Guardado',
            mensaje:'Documento actualizado correctamente y enviado a revisión'
        );
    }
    public function eliminar($documento_id)
    {
        $archivo = Documento::where('user_id',$this->id_user)
        ->where('documento_id',$documento_id)
        ->first();
        if($archivo){
            if(
                $archivo->ruta &&
                Storage::disk('public')->exists($archivo->ruta)
            ){
                Storage::disk('public')->delete($archivo->ruta);
            }
            $archivo->delete();
        }
        unset($this->archivosGuardados[$documento_id]);
        $this->dispatch(
            'alerta',
            tipo:'success',
            titulo:'Eliminado',
            mensaje:'Documento eliminado correctamente'
        );
    }
    public function finalizarModulo()
    {
        $academico = DB::table('padron_curriculum_datos_academicos')
        ->where('user_id',$this->id_user)
        ->whereNull('deleted_at')
        ->first();
        $obligatorios = DB::table('cat_documentos')
        ->where('activo',1)
        ->where('obligatorio',1)
        ->where('id','!=',2)
        ->get();
        foreach($obligatorios as $doc){
            $existe = Documento::where('user_id',$this->id_user)
            ->where('documento_id',$doc->id)
            ->exists();
            if(!$existe){
                $this->dispatch(
                    'alerta',
                    tipo:'warning',
                    titulo:'Expediente incompleto',
                    mensaje:'Falta cargar: '.$doc->nombre
                );
                return;
            }
        }
        if($academico && $academico->id_nivel_estudios > 1){
            $academicoDoc = Documento::where('user_id',$this->id_user)
            ->where('documento_id',2)
            ->exists();
            if(!$academicoDoc){
                $this->dispatch(
                    'alerta',
                    tipo:'warning',
                    titulo:'Expediente incompleto',
                    mensaje:'Falta cargar: Constancia de estudios, título y/o cédula profesional'
                );
                return;
            }
        }
        $especiales=[
            9=>[
                'nombre'=>'Conocimiento electoral',
                'tabla'=>'padron_curriculum_conocimientos_electorales'
            ],
            10=>[
                'nombre'=>'Experiencia electoral',
                'tabla'=>'padron_curriculum_experiencias_electorales'
            ],
            11=>[
                'nombre'=>'Experiencia docente',
                'tabla'=>'padron_curriculum_experiencias_docentes'
            ],
            12=>[
                'nombre'=>'Experiencia laboral',
                'tabla'=>'padron_curriculum_experiencias_laborales'
            ]
        ];
        foreach($especiales as $id=>$config){
            $tiene=DB::table($config['tabla'])
            ->where('user_id',$this->id_user)
            ->whereNull('deleted_at')
            ->exists();
            if($tiene){
                $doc=Documento::where('user_id',$this->id_user)
                ->where('documento_id',$id)
                ->exists();
                if(!$doc){
                    $this->dispatch(
                        'alerta',
                        tipo:'warning',
                        titulo:'Expediente incompleto',
                        mensaje:'Falta cargar: '.$config['nombre']
                    );
                    return;
                }
            }
        }
        ArchivosSubidos::updateOrCreate(
            [
                'user_id'=>$this->id_user,
                'modulo'=>'EXPEDIENTE_DIGITAL'
            ],
            [
                'completado'=>1,
                'fecha_completado'=>now(),
                'id_usuario_creo'=>$this->id_user
            ]
        );
        $this->dispatch(
            'alerta',
            tipo:'success',
            titulo:'Módulo completado',
            mensaje:'Expediente digital finalizado correctamente'
        );
    }
    public function render()
    {
        return view('livewire.aspirantes.archivos');
    }
}
