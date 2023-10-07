<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\LoginController;

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
Route::middleware(['auth:admin'])->group(function () {
    // Start User
    Route::get('/api/users', [UserController::class, 'index']);
    Route::post('/api/users', [UserController::class, 'store']);
    Route::put('/api/users/{id}', [UserController::class, 'update']);
    Route::delete('/api/users/{id}', [UserController::class, 'destory']);
    Route::patch('/api/users/{id}/change-role', [UserController::class, 'changeRole']);
    // Route::get('/api/users/search', [UserController::class, 'search']);
    Route::delete('/api/users', [UserController::class, 'MultipleDelete']);
    // End User
    // Start Appoinment
    Route::get('/api/appointments', [AppointmentController::class, 'index']);
    Route::get('/api/appointment-status', [AppointmentController::class, 'getStatusWithCount']);
    Route::post('/api/appointments/create', [AppointmentController::class, 'store']);
    Route::get('/api/appointments/{appointment}/edit', [AppointmentController::class, 'edit']);
    Route::put('/api/appointments/{id}/edit', [AppointmentController::class, 'update']);
    Route::delete('/api/appointments/{id}', [AppointmentController::class, 'destroy']);
    // End Appoinment

    // Start Client
    Route::get('/api/clients', [ClientController::class, 'index']);
    // End Client

    // Start Dashboard
    Route::get('/api/stats/appointments', [DashboardController::class, 'appointments']);
    Route::get('/api/stats/users', [DashboardController::class, 'users']);
    // End Dashbaord
});
Route::post('/api/login', [LoginController::class, 'login']);
Route::get('admin/login', [LoginController::class, 'index']);

Route::get('{view}', DashboardController::class)->where('view', '(.*)')->middleware('auth:admin');
