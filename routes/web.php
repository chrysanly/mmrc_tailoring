<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\AppointmentController;
use App\Http\Controllers\Authentication\SessionController;
use App\Http\Controllers\Authentication\RegisteredUserController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\Settings\PaymentController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\User\OrderController;
use App\Models\Settings;

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
       Route::prefix('settings')->group(function () {
            Route::prefix('appointment-limit')->group(function () {
                Route::get('/', [SettingsController::class, 'viewAppointmentLimit'])->name('admin.settings.appointment-limit');
                Route::post('/', [SettingsController::class, 'storeAppointmentLimit'])->name('admin.settings.appointment-limit.store');
               
            });
            Route::prefix('payment-option')->group(function () {
                Route::get('/', [PaymentController::class, 'index'])->name('admin.settings.payment-option');
                
                Route::prefix('api')->group(function () {
                    Route::get('/get-all', [PaymentController::class, 'getAllPaymentOption'])->name('admin.settings.payment-option.get-all');
                    Route::post('/store', [PaymentController::class, 'store'])->name('admin.settings.payment-option.store');
                    Route::get('/edit/{paymentOption}', [PaymentController::class, 'edit'])->name('admin.settings.payment-option.edit');
                    Route::patch('/update/{paymentOption}', [PaymentController::class, 'update'])->name('admin.settings.payment-option.update');
                    Route::delete('/destroy/{paymentOptions}', [PaymentController::class, 'destroy'])->name('admin.settings.payment-option.destroy');
                });
            });
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
            Route::get('/payment', [OrderController::class, 'payment'])->name('user.order.payment');
            Route::post('/store', [OrderController::class, 'store'])->name('user.order.store');
        });
   });

   
  
}); 
