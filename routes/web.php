<?php

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Billing;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\ExampleLaravel\UserManagement;
use App\Http\Livewire\ExampleLaravel\UserProfile;
use App\Http\Livewire\Notifications;
use App\Http\Livewire\Profile;
use App\Http\Livewire\RTL;
use App\Http\Livewire\StaticSignIn;
use App\Http\Livewire\StaticSignUp;
use App\Http\Livewire\Tables;
use App\Http\Livewire\VirtualReality;
use GuzzleHttp\Middleware;
use App\Http\Controllers\TemperatureSensorController;
use App\Http\Controllers\HumiditeSensorController;
use App\Http\Controllers\GasSensorController;
use App\Http\Controllers\RfidSensorController;
use App\Http\Controllers\Co2StatusSensorController;

use App\Http\Controllers\SensorDataController;


Route::get('/', function(){
    return redirect('sign-in');
});

Route::get('forgot-password', ForgotPassword::class)->middleware('guest')->name('password.forgot');
Route::get('reset-password/{id}', ResetPassword::class)->middleware('signed')->name('reset-password');



Route::get('sign-up', Register::class)->middleware('guest')->name('register');
Route::get('sign-in', Login::class)->middleware('guest')->name('login');


Route::get('user-profile', UserProfile::class)->middleware('auth')->name('user-profile');
Route::get('user-management', UserManagement::class)->middleware('auth')->name('user-management');


Route::group(['middleware' => 'auth'], function () {
Route::get('dashboard', Dashboard::class)->name('dashboard');
Route::get('billing', Billing::class)->name('billing');
Route::get('profile', Profile::class)->name('profile');
Route::get('tables', Tables::class)->name('tables');
Route::get('notifications', Notifications::class)->name("notifications");
Route::get('virtual-reality', VirtualReality::class)->name('virtual-reality');
Route::get('static-sign-in', StaticSignIn::class)->name('static-sign-in');
Route::get('static-sign-up', StaticSignUp::class)->name('static-sign-up');
Route::get('rtl', RTL::class)->name('rtl');
});


Route::get('/temperature/latest', [TemperatureSensorController::class, 'latest']);
Route::post('/store/temperature', [TemperatureSensorController::class, 'store']);

Route::get('/chart-data/temperature', [SensorDataController::class, 'temperature']);
Route::get('/chart-data/humidity', [SensorDataController::class, 'humidity']);
Route::get('/chart-data/gas', [SensorDataController::class, 'gas']);



Route::get('/humidity/latest', [HumiditySensorController::class, 'latest']);
Route::post('/store/humidity', [HumiditySensorController::class, 'store']);



Route::get('/co2-status/latest', [Co2StatusSensorController::class, 'latest']);

Route::post('/store/co2', [Co2StatusSensorController::class, 'store']);

Route::get('/rfid/latest', [RfidSensorController::class, 'latest']);
Route::get('/rfid/chart', [RfidSensorController::class, 'chartData']);
Route::post('/rfid/store', [RfidSensorController::class, 'store']);



Route::get('dashboard', Dashboard::class)->name('dashboard');

Route::post('/sensor-data', [SensorDataController::class, 'store']);

// Routes for Admin only
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/admin/manage-users', [AdminController::class, 'manageUsers']);
});

// Routes for Normal users
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard']);
});

// Routes everyone authenticated can access
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index']);
});


