<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\AppointmentController;
use App\Http\Controllers\Authentication\SessionController;
use App\Http\Controllers\Authentication\RegisteredUserController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\User\OrderController;

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
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register/store', [RegisteredUserController::class, 'store'])->name('register.store');
    
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login/store', [SessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
   Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

   Route::prefix('admin')->middleware('role.admin')->group(function () {
       Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

       Route::prefix('appointment')->group(function () {
           Route::get('/', [AdminAppointmentController::class, 'index'])->name('admin.appointment.index');
            Route::patch('/update-status/{appointment}', [AdminAppointmentController::class, 'updateStatus'])->name('admin.appointment.update-status');

       });
   });

   Route::prefix('user')->middleware('role.user')->group(function () {
        Route::prefix('appointment')->group(function () {
            Route::get('/', [AppointmentController::class, 'index'])->name('user.appointment.index');
            Route::get('/fetch-appointments', [AppointmentController::class, 'getAllAppointments'])->name('user.appointment.fetch-appointments');
            Route::post('/store', [AppointmentController::class, 'store'])->name('user.appointment.store');
        });

        Route::prefix('order')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('user.order.index');
        });
   });

   
  
}); 
