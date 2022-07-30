<?php

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

Route::get('/', [\App\Http\Controllers\DeputadoController::class, "index"])->name("deputados");
Route::get("/deputados/{id}", [\App\Http\Controllers\DeputadoController::class, "show"])->name("deputado.detalhes")->where("id", "\d+");
Route::get("/despesas", [\App\Http\Controllers\DespesaController::class, "index"])->name("deputados.despesas");
