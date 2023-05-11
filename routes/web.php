<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebPageController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
Route::post('/authenticate', [UserController::class, 'login'])->name('authenticate');
Route::get('/login', [WebPageController::class, 'login'])->name('login');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/profile', [UserController::class, 'show'])->name('profile');
Route::get('/dashboard/devices', [DeviceController::class, 'index'])->name('devices');
Route::get('/dashboard/devices/create', [DeviceController::class, 'create'])->name('devices.create');
Route::get('/dashboard/devices/{id}', [DeviceController::class, 'show'])->name('devices.show');
Route::get('/dashboard/devices/{id}/logs', [DeviceController::class, 'telemetryLogs'])->name('devices.logs');
Route::post('/dashboard/devices/{id}/update', [DeviceController::class, 'update'])->name('devices.update');
Route::post('/dashboard/devices/store', [DeviceController::class, 'store'])->name('devices.store');
Route::get('/register', [WebPageController::class, 'register'])->name('register');
