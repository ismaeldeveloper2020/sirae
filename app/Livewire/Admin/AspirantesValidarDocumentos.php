<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use App\Models\Aspirantes\Archivos as Documento;
use App\Models\Aspirantes\ArchivosSubidos;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Str;

#[Layout('layouts.admin')]
class AspirantesValidarDocumentos extends Component
{
    public $user_id;
    public $documento_id;
    public $observacion;
    public $mostrarModalRequerimiento = false;
    public $validacionCompleta = false;
    public function actualizarEstadoValidacion()
    {
        $this->validacionCompleta = Documento::where('user_id', $this->user_id)
            ->where('validado', '!=', 3)
            ->doesntExist();
    }
    public function mount($user_id)
    {
        $this->user_id = $user_id;
        $this->actualizarEstadoValidacion();
    }
    public function render()
    {
        $user = User::with('documentos')
            ->select(
                'users.*',
                'padron_generales.folio',
                'padron_generales.curp',
                'padron_generales.telefono_movil'
            )
            ->join(
                'padron_generales',
                'padron_generales.user_id',
                '=',
                'users.id'
            )
            ->where('users.id', $this->user_id)
            ->first();
        return view('livewire.admin.aspirantes-validar-documentos', [
            'user' => $user
        ]);
    }
    public function abrirRequerimiento($id)
    {
        $this->documento_id = $id;
        $this->observacion = '';
        $this->mostrarModalRequerimiento = true;
    }
    public function validarDocumento($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $documento = Documento::findOrFail($id);
                $documento->update([
                    'validado' => 3,
                    'id_usuario_valido' => Auth::id(),
                    'fecha_valido' => now()
                ]);
                $todosValidados = Documento::where('user_id', $this->user_id)
                    ->where('validado', '<>', 3)
                    ->doesntExist();
                /*if ($todosValidados) {
                    DB::table('padron_aspirantes_modulos')
                        ->where('user_id', $this->user_id)
                        ->update([
                            'modulo_registro' => 5,
                            'deleted_at' => null,
                            'updated_at' => now()
                        ]);
                }*/
            });
            $this->actualizarEstadoValidacion();
            session()->flash('status', 'Documento validado correctamente');
        } catch (\Exception $e) {
            \Log::error('Error validando documento: ' . $e->getMessage());
            session()->flash(
                'error',
                'Ocurrió un error al validar el documento'
            );
        }
    }
    public function quitarValidacion($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $documento = Documento::findOrFail($id);
                $documento->update([
                    'validado' => 0,
                    'id_usuario_modifico' => Auth::id()
                ]);
                $tieneRequerimientos = Documento::where('user_id', $this->user_id)
                    ->where('validado', 1)
                    ->exists();
                $tieneSubsanados = Documento::where('user_id', $this->user_id)
                    ->where('validado', 2)
                    ->exists();
                $todosValidados = Documento::where('user_id', $this->user_id)
                    ->where('validado', '!=', 3)
                    ->doesntExist();
                $modulo = null;
                if ($todosValidados) {
                    //$modulo = 5;
                } elseif ($tieneRequerimientos && $tieneSubsanados) {
                    $modulo = 4;
                } elseif ($tieneRequerimientos) {
                    $modulo = 2;
                } elseif ($tieneSubsanados) {
                    $modulo = 3;
                } else {
                    $modulo = 1;
                }
                DB::table('padron_aspirantes_modulos')
                    ->where('user_id', $this->user_id)
                    ->update([
                        'modulo_registro' => $modulo,
                        'deleted_at' => null,
                        'updated_at' => now()
                    ]);
            });
            $this->actualizarEstadoValidacion();
            session()->flash('status', 'Validación retirada');
        } catch (\Exception $e) {
            \Log::error('Error quitando validación: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al quitar la validación');
        }
    }
    public function guardarRequerimiento()
    {
        $this->validate([
            'observacion' => 'required|min:10'
        ]);
        try {
            DB::transaction(function () {
                $doc = Documento::findOrFail($this->documento_id);
                $doc->update([
                    'validado' => 1,
                    'observacion' => $this->observacion,
                    'id_usuario_requirio' => null,
                    'fecha_requirio' => null
                ]);
                $tieneRequerimientos = Documento::where('user_id', $this->user_id)
                    ->where('validado', 1)
                    ->exists();
                $tieneSubsanados = Documento::where('user_id', $this->user_id)
                    ->where('validado', 2)
                    ->exists();
                $todosValidados = Documento::where('user_id', $this->user_id)
                    ->where('validado', '!=', 3)
                    ->doesntExist();
                if ($tieneRequerimientos && $tieneSubsanados) {
                    $modulo = 4;
                } elseif ($tieneRequerimientos) {
                    $modulo = 2;
                } elseif ($tieneSubsanados) {
                    $modulo = 3;
                } else {
                    $modulo = 1;
                }
                DB::table('padron_aspirantes_modulos')
                    ->where('user_id', $this->user_id)
                    ->update([
                        'modulo_registro' => $modulo,
                        'deleted_at' => null,
                        'updated_at' => now()
                    ]);
            });
            $this->actualizarEstadoValidacion();
            $this->mostrarModalRequerimiento = false;
            $this->reset([
                'documento_id',
                'observacion'
            ]);
            session()->flash(
                'status',
                'Requerimiento guardado. Falta enviar el correo al aspirante.'
            );
        } catch (\Exception $e) {
            \Log::error(
                'Error guardando requerimiento: ' . $e->getMessage()
            );
            session()->flash(
                'error',
                'Ocurrió un error al guardar el requerimiento'
            );
        }
    }
    public function quitarRequerimiento($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $doc = Documento::findOrFail($id);
                $doc->update([
                    'validado' => 0,
                    'observacion' => null,
                    'id_usuario_modifico' => auth()->id()
                ]);
                $tieneRequerimientos = Documento::where('user_id', $this->user_id)
                    ->where('validado', 1)
                    ->exists();
                $tieneSubsanados = Documento::where('user_id', $this->user_id)
                    ->where('validado', 2)
                    ->exists();
                $todosValidados = Documento::where('user_id', $this->user_id)
                    ->where('validado', '!=', 3)
                    ->doesntExist();
                $modulo = null;
                if ($todosValidados) {
                    //$modulo = 5;
                } elseif ($tieneRequerimientos && $tieneSubsanados) {
                    $modulo = 4;
                } elseif ($tieneRequerimientos) {
                    $modulo = 2;
                } elseif ($tieneSubsanados) {
                    $modulo = 3;
                } else {
                    $modulo = 1;
                }
                DB::table('padron_aspirantes_modulos')
                    ->where('user_id', $this->user_id)
                    ->update([
                        'modulo_registro' => $modulo,
                        'deleted_at' => null,
                        'updated_at' => now()
                    ]);
            });
            $this->actualizarEstadoValidacion();
            session()->flash('status', 'Requerimiento eliminado');
        } catch (\Exception $e) {
            \Log::error('Error al quitar requerimiento: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al eliminar el requerimiento');
        }
    }
    public function validarTodos()
    {
        try {
            $validado = DB::transaction(function () {
                $tieneRequerimientos = Documento::where('user_id', $this->user_id)
                    ->where('validado', 1)
                    ->exists();
                if ($tieneRequerimientos) {
                    return false;
                }
                Documento::where('user_id', $this->user_id)
                    ->update([
                        'validado' => 3,
                        'observacion' => null,
                        'id_usuario_valido' => Auth::id(),
                        'fecha_valido' => now()
                    ]);
                /*DB::table('padron_aspirantes_modulos')
                    ->where('user_id', $this->user_id)
                    ->update([
                        'modulo_registro' => 5,
                        'deleted_at' => null,
                        'updated_at' => now()
                    ]);*/
                return true;
            });
            if (!$validado) {
                session()->flash(
                    'error',
                    'No se pueden validar todos los documentos. Existen documentos con requerimientos pendientes de revisión.'
                );
                return;
            }
            session()->flash(
                'status',
                'Todos los documentos fueron validados'
            );
            $this->actualizarEstadoValidacion();
        } catch (\Exception $e) {
            session()->flash(
                'error',
                'Ocurrió un error al validar los documentos: ' . $e->getMessage()
            );
            \Log::error(
                'Error validarTodos: ' . $e->getMessage()
            );
        }
    }

    public function finalizarValidacion($user_id)
    {
        DB::beginTransaction();

        try {

            DB::table('padron_aspirantes_modulos')
                ->where('user_id', $user_id)
                ->update([
                    'modulo_registro' => 5,
                    'deleted_at' => null,
                    'updated_at' => now(),
                    'id_usuario_valido' => Auth::id(),
                    'fecha_valido' => now()
                ]);

            // Genera o reemplaza la constancia
            $this->generarConstancia($user_id);

            DB::commit();

            session()->flash(
                'status',
                'Todos los documentos fueron validados.'
            );

        } catch (\Exception $e) {

            DB::rollBack();

            session()->flash(
                'error',
                'Ocurrió un error al finalizar las validaciones: ' .
                $e->getMessage()
            );

            \Log::error(
                'Error validarTodos: ' . $e->getMessage()
            );
        }
    }

    public function enviarRequerimiento($user_id)
    {
        DB::beginTransaction();
        try {
            $this->generarRequerimiento($user_id);

            $ids = DB::table('padron_documentos')
                ->where('user_id', $user_id)
                ->where('validado', 1)
                ->whereNotNull('observacion')
                ->whereNull('fecha_requirio')
                ->pluck('id');

            Documento::whereIn('id', $ids)
                ->update([
                    'id_usuario_requirio' => Auth::id(),
                    'fecha_requirio' => now(),
                ]);

            DB::commit();
            session()->flash(
                'status',
                'Requerimiento enviado correctamente por correo.'
            );
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash(
                'error',
                'Ocurrió un error al enviar requerimiento: ' . $e->getMessage()
            );
            \Log::error(
                'Error enviarRequerimiento: ' . $e->getMessage()
            );
        }
    }

    private function generarConstancia($user_id)
    {
        $datos = DB::table('users')
            ->join('padron_generales', 'users.id', '=', 'padron_generales.user_id')
            ->where('users.id', $user_id)
            ->whereNull('padron_generales.deleted_at')
            ->select(
                'users.nombre',
                'users.apaterno',
                'users.amaterno',
                'users.email',
                'padron_generales.folio',
                'padron_generales.id_tipo_cargo',
                'padron_generales.id_distrital',
                'padron_generales.id_municipal'
            )
            ->first();

        if (!$datos) {
            throw new \Exception('No existe información del aspirante');
        }

        $tipoConsejo = '';
        $descripcion_distrito_municipio = '';

        if ($datos->id_tipo_cargo == 1) {
            $tipoConsejo = 'DISTRITAL';

            $distrito = DB::table('cat_distritos_municipios')
                ->join(
                    'cat_municipios',
                    'cat_municipios.id_municipio',
                    '=',
                    'cat_distritos_municipios.id_municipio'
                )
                ->where('cat_distritos_municipios.id_distrito', $datos->id_distrital)
                ->where('cat_distritos_municipios.cabecera_distrital', 1)
                ->select(
                    'cat_distritos_municipios.id_distrito',
                    'cat_municipios.municipio_local'
                )
                ->first();

            if ($distrito) {
                $descripcion_distrito_municipio =
                    $distrito->id_distrito . ' ' . $distrito->municipio_local;
            }
        } else {
            $tipoConsejo = 'MUNICIPAL';

            $municipio = DB::table('cat_municipios')
                ->where('id_municipio', $datos->id_municipal)
                ->first();

            if ($municipio) {
                $descripcion_distrito_municipio = $municipio->municipio_local;
            }
        }

        $constancia = DB::table('padron_constancias')
            ->where('user_id', $user_id)
            ->whereNull('deleted_at')
            ->first();

        // Conservamos el mismo key si la constancia ya existe
        $verificationKey = $constancia
            ? $constancia->verification_key
            : Str::random(64);

        $datosConstancia = [
            'user_id' => $user_id,
            'verification_key' => $verificationKey,
            'folio' => $datos->folio,
            'estatus' => 1,
            'motivo' => null,
            'fecha_emision' => now(),
            'fecha_validacion' => now(),
            'nombre' => trim(
                $datos->nombre . ' ' .
                $datos->apaterno . ' ' .
                $datos->amaterno
            ),
            'tipo_enlace' => $tipoConsejo,
            'distrito_municipio' => $descripcion_distrito_municipio,
            'id_usuario_modifico' => Auth::id(),
            'updated_at' => now(),
        ];

        if ($constancia) {
            DB::table('padron_constancias')
                ->where('id', $constancia->id)
                ->update($datosConstancia);

            $idConstancia = $constancia->id;
        } else {
            $datosConstancia['id_usuario_creo'] = Auth::id();
            $datosConstancia['created_at'] = now();

            $idConstancia = DB::table('padron_constancias')->insertGetId($datosConstancia);
        }

        //$urlValidacion = url('/api/validar-constancia/' . $verificationKey);
        $urlValidacion = route('constancia.mostrar',['key' => $verificationKey]);

        $builder = new \Endroid\QrCode\Builder\Builder(
            writer: new \Endroid\QrCode\Writer\PngWriter(),
            data: $urlValidacion,
            size: 600,
            margin: 20,
            encoding: new \Endroid\QrCode\Encoding\Encoding('UTF-8')
        );

        $qr = $builder->build();

        $codigoQR ='data:image/png;base64,' .base64_encode($qr->getString());

        $fecha = now();

        $pdf = Pdf::loadView(
            'reportes.aspirantes.constancia',
            compact(
                'datos',
                'codigoQR',
                'tipoConsejo',
                'descripcion_distrito_municipio',
                'fecha'
            )
        );

        $pdf->setPaper('letter', 'portrait');

        $archivo = 'constancia_' . $datos->folio . '.pdf';

        $carpeta = storage_path('app/public/aspirantes/pdf/generados');

        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $rutaArchivo = $carpeta . '/' . $archivo;

        // Reemplaza el PDF anterior
        file_put_contents($rutaArchivo, $pdf->output());

        $rutaBD = 'aspirantes/pdf/generados/' . $archivo;

        DB::table('padron_constancias')
            ->where('id', $idConstancia)
            ->update([
                'ruta' => $rutaBD,
                'updated_at' => now()
            ]);

        Mail::send(
            'reportes.aspirantes.email_constancia',
            [
                'nombre' =>
                    $datos->nombre . ' ' .
                    $datos->apaterno . ' ' .
                    $datos->amaterno,
                'folio' => $datos->folio,
                'fecha' => now()->format('d/m/Y')
            ],
            function ($mail) use ($datos, $rutaArchivo, $archivo) {
                $mail->to($datos->email)
                    ->subject('Constancia de registro - Aspirante')
                    ->attach($rutaArchivo, [
                        'as' => $archivo,
                        'mime' => 'application/pdf'
                    ]);
            }
        );

        $this->dispatch(
            'descargar-constancia',
            archivo: $archivo
        );
    }

    private function generarRequerimiento($user_id)
    {
        // Datos aspirante
        $usuario = DB::table('users')
            ->where('id', $user_id)
            ->select(
                'nombre',
                'apaterno',
                'amaterno',
                'email'
            )
            ->first();
        if (!$usuario) {
            throw new \Exception('Aspirante no encontrado');
        }
        // Documentos con requerimiento
        $documentos = DB::table('padron_documentos')
            ->join(
                'cat_documentos',
                'cat_documentos.id',
                '=',
                'padron_documentos.documento_id'
            )
            ->where('padron_documentos.user_id', $user_id)
            ->where('padron_documentos.validado', 1)
            ->whereNotNull('padron_documentos.observacion')
            ->whereNull('padron_documentos.fecha_requirio')
            ->select(
                'cat_documentos.nombre as documento',
                'padron_documentos.observacion'
            )
            ->get();

        if ($documentos->count() == 0) {
            throw new \Exception(
                'No existen requerimientos para enviar'
            );
        }
        // Generar PDF
        $pdf = Pdf::loadView(
            'reportes.aspirantes.requerimiento',
            [
                'usuario' => $usuario,
                'documentos' => $documentos,
                'fecha' => now()
            ]
        );
        $pdf->setPaper(
            'letter',
            'portrait'
        );
        $archivo =
            'Requerimiento_' . $user_id . '.pdf';
        $carpeta =
            storage_path(
                'app/public/aspirantes/pdf/generados'
            );
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }
        $rutaArchivo =
            $carpeta . '/' . $archivo;
        file_put_contents(
            $rutaArchivo,
            $pdf->output()
        );
        // Enviar correo
        Mail::send(
            'reportes.aspirantes.email_requerimiento',
            [
                'nombre' =>
                    $usuario->nombre.' '.
                    $usuario->apaterno.' '.
                    $usuario->amaterno,

                'fecha' => now()->format('d/m/Y')
            ],
            function($mail) use(
                $usuario,
                $rutaArchivo,
                $archivo
            ){

                $mail->to($usuario->email)
                    ->subject(
                        'Requerimiento de documentación pendiente'
                    )
                    ->attach(
                        $rutaArchivo,
                        [
                            'as'=>$archivo,
                            'mime'=>'application/pdf'
                        ]
                    );

            }
        );

        $this->dispatch(
            'descargar-requerimiento',
            archivo: $archivo
        );
    }
}
