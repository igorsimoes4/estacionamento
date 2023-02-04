<?php

use App\Http\Controllers\CarsController;
use App\Http\Controllers\EstacionamentoController;
use App\Http\Controllers\PembayaranController;
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

Route::get('/', function () {
    return redirect('painel');
});

Route::prefix('painel')->group(function(){
    Route::get('/', [EstacionamentoController::class, 'index'])->name('home');

    Route::resource('/cars', CarsController::class);

    Route::post('/pembayaran/print', [PembayaranController::class, 'print'])->name('pembayaran.print');

    // Route::get('/settings', [SettingController::class, 'index'])->name('settings');

});
