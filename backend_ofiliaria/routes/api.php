<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\StudentController;
use App\Http\Controllers\api\v1\GarantiaController;
use App\Http\Controllers\api\v1\PersonaController;
use App\Http\Controllers\api\v1\AutorizacionController;
use App\Http\Controllers\api\v1\CategoriaController;
use App\Http\Controllers\api\v1\UbicacionController;
use App\Http\Controllers\api\v1\ComodidadController;
use App\Http\Controllers\api\v1\DepartamentoController;
use App\Http\Controllers\api\v1\ZonaController;
use App\Http\Controllers\api\v1\InfocasasController;
use App\Enums\TokenAbility;
use App\Mail\MailNotify;
use Illuminate\Support\Facades\Auth;

/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/

Route::prefix("v1")->group(function () {
    Route::post('/registro', [AutorizacionController::class, 'registro']);
    Route::post('/login', [AutorizacionController::class, 'login']);
    Route::get('/infocasas/prueba', [InfocasasController::class, 'prueba']);

    Route::controller(CategoriaController::class)->prefix("categorias")->group(function () {
        Route::get("/", "index");
        Route::get("/show/{id}", "show");
        Route::get("/buscarCategoriaMeli/{identificadorMeli}", "buscarCategoriaMeli"); 
        // Route::get('/importarCategoriasMeli/{token}', "importarCategoriasMeli");
    }); 

    Route::controller(ComodidadController::class)->prefix("comodidads")->group(function () {
        Route::get("/", "index");
        Route::get("/show/{id}", "show");
        Route::post("/notificaciones", "notificaciones");
    }); 

    Route::controller(DepartamentoController::class)->prefix("departamentos")->group(function () {
        Route::get("/", "index");
        Route::get("/show/{id}", "show");
    }); 

    Route::controller(ZonaController::class)->prefix("zonas")->group(function () {
        Route::get("/", "index");
        Route::get("/show/{id}", "show");
    }); 

    Route::controller(UbicacionController::class)->prefix("ubicacions")->group(function () {
        Route::get("/", "index");
        Route::get("/show/{id}", "show");
        Route::get("/importarUbicacionesMeli/{token}", "importarUbicacionesMeli");
        Route::get("/zonasMeliInfocasas", "zonasMeliInfocasas");
    }); 

    // Route::get('/importarUbicacionesMeli/{token}', [UbicacionController::class, 'importarUbicacionesMeli']);
    
    Route::middleware('auth:sanctum', 'ability:' . TokenAbility::ISSUE_ACCESS_TOKEN->value)->group(function () {
        Route::post('/refrescar-token', [AutorizacionController::class, 'refrescarToken']);
    });

    Route::middleware('auth:sanctum', 'ability:' . TokenAbility::ACCESS_API->value)->group(function () {
        Route::post('/logout', [AutorizacionController::class, 'logout']);
    });

	Route::controller(InfocasasController::class)->prefix("infocasas")->middleware('auth:sanctum', 'ability:' . TokenAbility::ACCESS_API->value)->group(function () {
	// Middleware deshabilitado temporalmente para pruebas desde Postman
	// Route::controller(InfocasasController::class)->prefix("infocasas")->group(function () {
		Route::post('/guardar-xml', 'guardarXml');
	});
	

    Route::controller(GarantiaController::class)->prefix("garantias")->middleware('auth:sanctum', 'ability:' . TokenAbility::ACCESS_API->value)->group(function () {
        Route::get("/", "index");
        Route::post("/store", "store");
        Route::get("/show/{id}", "show");
        Route::post("/update/{id}", "update");
        Route::patch("/updatePartial/{id}", "updatePartial");
        Route::post("/guardarArchivos/{id}", "guardarArchivos");
        Route::post("/eliminarArchivo/{id}", "eliminarArchivo");
        Route::post("/fotoInventario/{id}", "fotoInventario");
        Route::post("/obtenerFotoInventario/{id}", "obtenerFotoInventario");
        Route::post("/destroy/{id}", "destroy");
    }); 
    Route::controller(PersonaController::class)->prefix("personas")->middleware('auth:sanctum', 'ability:' . TokenAbility::ACCESS_API->value)->group(function () {
        Route::get("/", "index");
        Route::post("/store", "store");
        Route::get("/show/{id}", "show");
        Route::post("/update/{id}", "update");
        Route::patch("/updatePartial/{id}", "updatePartial");
        Route::post("/destroy/{id}", "destroy");
        Route::post("/archivoBase64", "archivoBase64");
        Route::post("/guardarArchivos/{id}", "guardarArchivos");
        Route::post("/eliminarArchivo/{id}", "eliminarArchivo");
    }); 
    // Activar solo para crear el storage de los archivos, luego inactivar
    /*
    Route::get('/almacenamiento', function () {
        Artisan::call('storage:link');
    }); 
    */
});