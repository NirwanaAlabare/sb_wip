<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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

Route::controller(LoginController::class)->prefix('login')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/', 'index')->name('login');
        Route::post('/authenticate', 'authenticate');
    });

    Route::post('/unauthenticate', 'unauthenticate')->middleware('auth');
});


Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('index');
    });

    Route::get('/production-panel', function () {
        return view('production-panel');
    });

    Route::get('/rft', function () {
        return view('rft');
    });

    Route::get('/defect', function () {
        return view('defect');
    });

    Route::get('/defect-history', function () {
        return view('defect-history');
    });

    Route::get('/reject', function () {
        return view('reject');
    });

    Route::get('/rework', function () {
        return view('rework');
    });
});
