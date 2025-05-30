<?php

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Billing;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\ExampleLaravel\UserProfile;
use App\Http\Livewire\Notifications;
use App\Http\Livewire\Profile;
use App\Http\Livewire\RTL;
use App\Http\Livewire\StaticSignIn;
use App\Http\Livewire\StaticSignUp;
use App\Http\Livewire\Tables;
use App\Http\Livewire\VirtualReality;
use App\Http\Controllers\RfidSensorController;
use App\Http\Controllers\Co2StatusSensorController;
use App\Http\Controllers\SensorDataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RfidController;
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

// Redirect root to sign-in
Route::get('/', function () {
    return redirect('sign-in');
});

// Authentication Routes (Guest Middleware)
Route::middleware('guest')->group(function () {
    Route::get('forgot-password', ForgotPassword::class)->name('password.forgot');
    // The name for reset password is typically 'password.reset'
    Route::get('reset-password/{token}', ResetPassword::class)->name('password.reset');
    Route::get('sign-up', Register::class)->name('register');
    Route::get('sign-in', Login::class)->name('login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/dashboard', Dashboard::class)->name('dashboard');
Route::get('/rfid-search', [RfidController::class, 'search'])->name('rfid.search');


// Authenticated User Routes
    Route::middleware(['auth'])->group(function () {
    // Dashboard routes

     Route::get('/agent-dashboard', \App\Http\Livewire\Dashboard::class)->name('agent');
    Route::get('/technicien-dashboard', \App\Http\Livewire\Dashboard::class)->name('technicien');

    // User Profile (Livewire)
    Route::get('user-profile', UserProfile::class)->name('user-profile');
    Route::get('profile', Profile::class)->name('profile.livewire'); // Renamed to avoid conflict if ProfileController is also used

    // Other Livewire Components
    Route::get('billing', Billing::class)->name('billing');
    Route::get('tables', Tables::class)->name('tables');
    Route::get('notifications', Notifications::class)->name('notifications');
    Route::get('virtual-reality', VirtualReality::class)->name('virtual-reality');
    Route::get('static-sign-in', StaticSignIn::class)->name('static-sign-in');
    Route::get('static-sign-up', StaticSignUp::class)->name('static-sign-up');
    Route::get('rtl', RTL::class)->name('rtl');

    // Sensor-related views
    Route::view('/gaz', 'livewire.gaz')->name('gaz');
    Route::view('/temperature', 'livewire.temperature')->name('temperature');
    Route::view('/humidite', 'livewire.humidite')->name('humidite');

    // ---
    ## User Management Routes

    // Use Route::resource for standard CRUD operations.
    // By removing ->except(['create', 'show']), the 'users.create' route is now defined.
    Route::resource('users', UserController::class);

    // Alias for users.index if you prefer 'user-management' for the listing page
    Route::get('/user-management', [UserController::class, 'index'])->name('user-management');

    Route::get('/user-management', \App\Http\Livewire\ExampleLaravel\UserManagement::class)->name('user-management');

    ## Sensor Data & API Routes

    Route::get('/chart-data/temperature', [SensorDataController::class, 'temperature']);
    Route::get('/chart-data/humidity', [SensorDataController::class, 'humidity']);
    Route::get('/chart-data/gas', [SensorDataController::class, 'gas']);
    Route::post('/sensor-data', [SensorDataController::class, 'store']);

    // CO2 Status Sensor Routes
    Route::get('/co2-status/latest', [Co2StatusSensorController::class, 'latest']);
    Route::post('/store/co2', [Co2StatusSensorController::class, 'store']);

    // RFID Sensor Routes
    Route::get('/rfid/latest', [RfidSensorController::class, 'latest']);
    Route::get('/rfid/chart', [RfidSensorController::class, 'chartData']);
    Route::post('/rfid/store', [RfidSensorController::class, 'store']);

    // ---
    ## Role-Based & General Authenticated Routes

    // Routes for Normal users (assuming a 'role' middleware exists)
    Route::middleware('role:user')->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    });

    // Routes everyone authenticated can access
    Route::get('/profile-controller', [ProfileController::class, 'index'])->name('profile.controller');
});
