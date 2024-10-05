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
/* Rutas genericas */

Route::get('/', function () {
    return view('auth.login');
});
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

/* Rutas Resources */
Route::resource('dashboard', 'App\Http\Controllers\DashboardController');
Route::resource('pedidos', 'App\Http\Controllers\PedidoController');


/* Rutas Helpers */
Route::get('pedidos/getDataPedidos', 'App\Http\Controllers\PedidoController@getDataPedidos')->name('pedidos.getDataPedidos');
