<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\WaController;

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
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // CRUD Customer
    Route::resource('customers', CustomerController::class);
});

Route::resource('devices', DeviceController::class)->only('index', 'update');

Route::get('messages/automessage', [MessageController::class, 'getAutoMessage'])->name('messages.automessage');
Route::resource('messages', MessageController::class);

Route::post('send', [WaController::class, 'send'])->name('send');
