<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\StudentController;
use App\Http\Controllers\api\v1\GarantiaController;
use App\Http\Controllers\api\v1\PersonaController;
/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/

Route::prefix("v1")->group(function () {
    Route::post('/login', [App\Http\Controllers\api\v1\AutorizacionController::class, 'login']);

    Route::controller(GarantiaController::class)->prefix("garantias")->middleware('auth:sanctum')->group(function () {
        Route::get("/", "index");
        Route::post("/store", "store");
        Route::get("/show/{id}", "show");
        Route::post("/update/{id}", "update");
        Route::patch("/updatePartial/{id}", "updatePartial");
        Route::patch("/destroy/{id}", "destroy");
    }); 
    Route::controller(PersonaController::class)->prefix("personas")->group(function () {
        Route::get("/", "index");
        Route::post("/store", "store");
        Route::get("/show/{id}", "show");
        Route::post("/update/{id}", "update");
        Route::patch("/updatePartial/{id}", "updatePartial");
        Route::patch("/destroy/{id}", "destroy");
        Route::post("/archivoBase64", "archivoBase64");
    }); 
    // Activar solo para crear el storage de los archivos, luego inactivar
    /*
    Route::get('/almacenamiento', function () {
        Artisan::call('storage:link');
    }); 
    */

    Route::middleware('auth:sanctum')->group(function () 
    {
        Route::post('/logout', [App\Http\Controllers\api\v1\AutorizacionController::class, 'logout']);
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });
});