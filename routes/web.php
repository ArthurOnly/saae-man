<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OperationController;
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

Route::get('/', DashboardController::class);
Route::get('/operation/register', [OperationController::class, "index"])->name("operation.register");
Route::get('/operation/finish/{OPN}', [OperationController::class, "finish"])->name("operation.finish");
Route::post('/operation/finish/{OPN}', [OperationController::class, "finishHandler"]);
Route::post('/operation/register', [OperationController::class, "create"]);
