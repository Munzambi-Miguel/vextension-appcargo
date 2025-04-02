<?php

use App\Http\API\BeneficiarioExcelController;
use App\Http\API\ExpesciaPrestadorController;
use App\Http\API\ImageController;
use AppCargo\app\Http\Controllers\AppCargoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;



// Rotas para o módulo AppCargo
Route::prefix('appcargo')->group(function () {
    Route::get('index', [AppCargoController::class, 'index'])->name('AppCargo.index');
    Route::post('index', [AppCargoController::class, 'store'])->name('AppCargo.store');
})->middleware(['auth', 'verified']);

