<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Aspirantes\Generales;
use App\Livewire\Aspirantes\Curriculum;
use App\Livewire\Aspirantes\Archivos;
use App\Http\Controllers\DashboardController;
use App\Livewire\Admin\AspirantesValidarDocumentos;
use App\Livewire\Admin\AspirantesEditar;

use App\Http\Controllers\ValidarConstanciasController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/borrar-cache', function () {

    Artisan::call('optimize:clear');

    
    //Artisan::call('view:clear');
    //Artisan::call('config:clear');
    //Artisan::call('cache:clear');

    return response()->json([
        'ok' => true,
        'mensaje' => 'Cache limpiada correctamente'
    ]);

});

Route::get('/livewire/livewire.js.map', function () {
    abort(404);
});


/*
|--------------------------------------------------------------------------
| VALIDACIÓN PÚBLICA DE CONSTANCIAS
|--------------------------------------------------------------------------
*/
Route::get('/validar-constancia/{key}',[ValidarConstanciasController::class, 'mostrar'])->name('constancia.mostrar');

/*
    Route::get('/salir', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->middleware('auth');
*/

/* Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
        Route::get('/dashboard', function () {
            $user = auth()->user();
            $roles = $user->roles->pluck('name')->map(fn($n) => strtolower($n));
            if ($user->hasRole('Aspirante') ||$roles->contains('Aspirante')) {
                return view('Aspirantes.dashboard');
            }
            return view('dashboard');
    })->name('dashboard');*/

/*Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {

        if (auth()->user()->hasRole('Aspirante')) {
            return view('Aspirantes.dashboard');
        }

        return view('dashboard');
    })->name('dashboard');
});*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

});


/*
    |--------------------------------------------------------------------------
    | MODULOS ASPIRANTE
    |--------------------------------------------------------------------------
    */
Route::middleware(['role:Aspirante'])->group(function () {

    Route::get('/aspirante/generales', [App\Http\Controllers\Aspirantes\AspirantesController::class, 'index_generales'])->name('aspirante.generales.listar');
    Route::get('/aspirante/curriculums', [App\Http\Controllers\Aspirantes\AspirantesController::class, 'index_curriculms'])->name('aspirante.curriculums.listar');
    Route::get('/aspirante/archivos', [App\Http\Controllers\Aspirantes\AspirantesController::class, 'index_archivos'])->name('aspirante.archivos.listar');

    Route::get('/aspirante/examen', [App\Http\Controllers\Aspirantes\AspirantesController::class, 'index_examen'])->name('aspirante.examen.listar');


    Route::get('/aspirante/cv/pdf',[App\Http\Controllers\Aspirantes\AspirantesController::class, 'generar_cv'])->name('aspirante.cv.pdf');
    Route::get('/aspirante/acuse/registro', [App\Http\Controllers\Aspirantes\AspirantesController::class, 'generar_acuse'])->name('aspirante.acuse.registro.pdf');
    Route::get('/aspirante/constancia/registro',[App\Http\Controllers\Aspirantes\AspirantesController::class, 'generar_constancia'])->name('aspirante.constancia.registro.pdf');
    Route::post('/aspirante/finalizar-registro',[App\Http\Controllers\Aspirantes\AspirantesController::class,'finalizarRegistro'])->name('aspirante.finalizar.registro');
    /*
            Route::get('/aspirante/generales', Generales::class)->name('aspirante.generales');
            Route::get('/aspirante/curriculum', Curriculum::class)->name('aspirante.curriculum');
            Route::get('/aspirante/archivos', Archivos::class)->name('aspirante.archivos');
    */
});
/*
    |--------------------------------------------------------------------------
    | REGISTRO ASPIRANTE
    |--------------------------------------------------------------------------
    */
Route::post('/aspirante/registro', [\App\Http\Controllers\CiudadanoController::class, 'store'])->name('aspirante.registro.store');
/*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:SuperAdmin|Admin|Editor'
])->group(function () {

    Route::get('/admin/users', function () {
        return view('Admin.users');
    })->name('admin.users');

    Route::get('/admin/users/perfiles', function () {
        return view('admin.perfiles');
    })->name('admin.users.perfiles');

    Route::get('/admin/roles', function () {
        return view('admin.roles');
    })->name('admin.roles');

    Route::get('/admin/organizaciones', function () {
        return view('admin.organizaciones');
    })->name('admin.organizaciones');

    Route::get('/admin/aspirantes', [App\Http\Controllers\Admin\AspirantesController::class, 'index_aspirantes'])->name('admin.aspirantes.listar');

    Route::get('/admin/aspirantes/validados', [App\Http\Controllers\Admin\AspirantesController::class, 'index_aspirantes_validados'])->name('admin.aspirantes.validados.listar');

    Route::get('/admin/aspirantes/requeridos', [App\Http\Controllers\Admin\AspirantesController::class, 'index_aspirantes_requeridos'])->name('admin.aspirantes.requeridos.listar');

    Route::get('/admin/aspirantes/editar/{user_id}', AspirantesEditar::class)->name('admin.aspirantes.editar');

    //Route::get('/admin/aspirantes/validar/documentos/{$user_id}', [App\Http\Controllers\Admin\AspirantesController::class, 'index_aspirantes_validar_documentos'])->name('admin.aspirantes.validar.documentos');

    Route::get('/admin/aspirantes/validar/documentos/{user_id}', AspirantesValidarDocumentos::class)->name('admin.aspirantes.validar.documentos');

    Route::get('/admin/aspirante/{user}/examen', \App\Livewire\Admin\VerExamenAspirante::class)
    ->name('admin.aspirante.examen');

});
