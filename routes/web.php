<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\AppointmentController;
use App\Http\Controllers\Authentication\SessionController;
use App\Http\Controllers\Authentication\RegisteredUserController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\Settings\AppointmentLimitController;
use App\Http\Controllers\Admin\Settings\PaymentController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UniformPriceController;
use App\Http\Controllers\Admin\UserController;
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
           Route::get('/get-measurement/{appointment}', [AdminAppointmentController::class, 'getMeasurement'])->name('admin.appointment.get-measurement');
           Route::get('/view-measurement/{appointment}', [AdminAppointmentController::class, 'viewMeasurement'])->name('admin.appointment.view-measurement');
           Route::post('/store-measurement/{appointment}', [AdminAppointmentController::class, 'storeMeasurement'])->name('admin.appointment.store-measurement');
            Route::patch('/update-status/{appointment}', [AdminAppointmentController::class, 'updateStatus'])->name('admin.appointment.update-status');

       });
       Route::prefix('order')->group(function () {
           Route::get('/', [AdminOrderController::class, 'index'])->name('admin.order.index');
           Route::patch('/update-status/{order}', [AdminOrderController::class, 'updateStatus'])->name('admin.order.update-status');
            Route::prefix('api')->group(function () {
                Route::get('/view/{order}', [AdminOrderController::class, 'viewOrder'])->name('admin.order.view');
                Route::post('/payment/verified/{orderPayment}', [AdminOrderController::class, 'paymentVerified'])->name('admin.order.payment.verified');
                Route::patch('/invoice/discount/{orderInvoice}', [AdminOrderController::class, 'discount'])->name('admin.order.discount');
            });
       });
       Route::prefix('uniform-prices')->middleware('role.superadmin')->group(function () {
           Route::get('/', [UniformPriceController::class, 'index'])->name('admin.uniform-price.index');
            Route::prefix('api')->group(function () {
                Route::get('/get-all', [UniformPriceController::class, 'fetchUniforms'])->name('admin.uniform-price.fetch-uniform');
                Route::get('/get-all/price-lists/{uniform}', [UniformPriceController::class, 'fetchUniformsPrice'])->name('admin.uniform-price.fetch-uniform.price-lists');
                Route::get('/edit-uniform/{uniform}', [UniformPriceController::class, 'editUniform'])->name('admin.uniform-price.edit-uniform');
                Route::get('/edit-uniform/price-list/{uniformPriceItem}', [UniformPriceController::class, 'editUniformPriceList'])->name('admin.uniform-price.edit-uniform.price-list');
                Route::post('/store-uniform', [UniformPriceController::class, 'storeUniform'])->name('admin.uniform-price.store-uniform');
                Route::post('/store-uniform-price-list/{uniform}', [UniformPriceController::class, 'storeUniformPriceList'])->name('admin.uniform-price.store-uniform-price-list');
                Route::patch('/update-uniform/{uniform}', [UniformPriceController::class, 'updateUniform'])->name('admin.uniform-price.update-uniform');
                Route::patch('/update-uniform-price-list/{uniform}/{uniformPriceItem}', [UniformPriceController::class, 'updateUniformPriceList'])->name('admin.uniform-price.update-uniform-price-list');
                Route::delete('/destroy-uniform/{uniform}', [UniformPriceController::class, 'destroyUniform'])->name('admin.uniform-price.destroy-uniform');
                Route::delete('/destroy-uniform/price-list/{uniformPriceItem}', [UniformPriceController::class, 'destroyUniformPriceList'])->name('admin.uniform-price.destroy-uniform.price-list');
            });
       });

       Route::prefix('admin-users')->middleware('role.superadmin')->group(function () {
           Route::get('/', [UserController::class, 'index'])->name('admin.admin-users.index');
           Route::get('/create', [UserController::class, 'create'])->name('admin.admin-users.create');
           Route::get('/{user}', [UserController::class, 'edit'])->name('admin.admin-users.edit');
           Route::post('/', [UserController::class, 'store'])->name('admin.admin-users.store');
       });
       Route::prefix('settings')->middleware('role.superadmin')->group(function () {
            Route::prefix('appointment-limit')->group(function () {
                Route::get('/', [AppointmentLimitController::class, 'view'])->name('admin.settings.appointment-limit');
                Route::post('/', [AppointmentLimitController::class, 'store'])->name('admin.settings.appointment-limit.store');
               
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
            Route::get('/my-appointment', [AppointmentController::class, 'viewMyAppointment'])->name('user.appointment.my-appointment');
            Route::get('/fetch-appointments', [AppointmentController::class, 'getAllAppointments'])->name('user.appointment.fetch-appointments');
            Route::post('/store', [AppointmentController::class, 'store'])->name('user.appointment.store');
        });


        Route::prefix('order')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('user.order.index');
            Route::get('/my-orders', [OrderController::class, 'orders'])->name('user.order.my-orders');
            Route::get('/payment/{form_type}/{order}', [OrderController::class, 'payment'])->name('user.order.payment');
            Route::get('/success', [OrderController::class, 'success'])->name('user.order.success');
            Route::post('/store', [OrderController::class, 'store'])->name('user.order.store');
            Route::post('/store/ready-made', [OrderController::class, 'storeReadyMade'])->name('user.order.store.ready-made');
            Route::post('/store/payment/{order}', [OrderController::class, 'storePayment'])->name('user.order.store-payment');
        });
   });

   
  
}); 
