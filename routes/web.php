<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class)->name("home");

Route::get('/cliente/cadastrar', [ClientController::class, "create"])->name("cliente.cadastrar");
Route::post('/cliente/cadastrar', [ClientController::class, "store"])->name("cliente.cadastrar");

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name("dashboard");
    Route::get('/operation/register/{ID?}', [OperationController::class, "index"])->name("operation.register")->middleware('isAdm');
    Route::get('/operation/finish/{ID}', [OperationController::class, "finish"])->name("operation.finish");
    Route::post('/operation/finish/{ID}', [OperationController::class, "finishHandler"]);
    Route::post('/operation/register', [OperationController::class, "create"])->name("operation.create")->middleware('isAdm');
    Route::get('/operation/archived', [OperationController::class, "archived"])->name("operation.archived")->middleware('isAdm');
    Route::get('/operation/archive/{ID}', [OperationController::class, "archive"])->name("operation.archive")->middleware('isAdm');
    Route::get('/operation/unarchive/{ID}', [OperationController::class, "unarchive"])->name("operation.unarchive")->middleware('isAdm');
    Route::post('/operation/register/{ID}', [OperationController::class, "update"])->name("operation.edit")->middleware('isAdm');
    Route::get('/operation/delete/{ID}', [OperationController::class, "delete"])->name("operation.delete")->middleware('isAdm');

    Route::prefix('cliente')->group(function(){
        Route::get('/', [ClientController::class, 'index'])->name('client.index');
        Route::get('/{id}', [ClientController::class, 'edit'])->name('client.edit');
        Route::delete('/{id}', [ClientController::class, 'destroy'])->name('client.destroy');
        Route::put('/{id}', [ClientController::class, 'update'])->name('client.update');
    });
});


require __DIR__.'/auth.php';
