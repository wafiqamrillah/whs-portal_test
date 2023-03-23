<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

// IAMI
Route::name('iami.')->group(function () {
    Route::prefix('iami/')->group(function () {
        Route::get('order', [\App\Http\Controllers\IAMI\OrderController::class, 'index'])->name('order')->middleware('auth');
        Route::get('order/{id}', [\App\Http\Controllers\IAMI\OrderController::class, 'show'])->name('order.details')->middleware('auth');
        Route::post('sendorder', [\App\Http\Controllers\IAMI\OrderController::class, 'store'])->name('sendorderpost')->middleware('auth');
        Route::get('order/delete/{id}', [\App\Http\Controllers\IAMI\OrderController::class, 'destroy'])->name('deleteOrder')->middleware('auth');
        Route::post('order/forcedelete', [\App\Http\Controllers\IAMI\OrderController::class, 'forcedeleteprocess'])->name('forcedelete.process')->middleware('auth');
    });
    Route::prefix('iami/')->group(function () {
        Route::get('sendorder', [\App\Http\Controllers\IAMI\OrderController::class, 'sendOrder'])->name('sendorder')->middleware('auth');
        Route::get('sendorder/{id}', [\App\Http\Controllers\IAMI\OrderController::class, 'sendOrderDetails'])->name('details')->middleware('auth');
        Route::post('sendprocess/{id}', [\App\Http\Controllers\IAMI\OrderController::class, 'sendProcess'])->name('sendprocess')->middleware('auth');
        // Route::get('sendAll/{id}', 'OrdertmminController@sendAll')->name('.all')->middleware('auth');
    });

    Route::prefix('iami/')->group(function () {
        Route::get('monitor', [\App\Http\Controllers\IAMI\OrderController::class, 'monitor'])->name('monitor')->middleware('auth');
        Route::get('monitor/{id}', [\App\Http\Controllers\IAMI\OrderController::class, 'monitorDetails'])->name('.details')->middleware('auth');
        Route::get('list/{id}', [\App\Http\Controllers\IAMI\OrderController::class, 'monitorList'])->name('list')->middleware('auth');
        Route::get('monitor/list/{id}', [\App\Http\Controllers\IAMI\OrderController::class, 'monitorList'])->name('monitorlist')->middleware('auth');
        Route::get('report/{id}', [\App\Http\Controllers\IAMI\OrderController::class, 'downloadReport'])->name('report')->middleware('auth');
        Route::get('report/excel/{id}', [\App\Http\Controllers\IAMI\OrderController::class, 'downloadReportExcel'])->name('report.excel')->middleware('auth');
    });
});
