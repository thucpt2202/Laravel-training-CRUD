<?php

require __DIR__ . '/auth.php';

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

// Welcome route
Route::get('/welcome', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('welcome');;

// Dashboard route with middleware end user role
Route::middleware(['auth', 'role:nuser', 'verified'])->group(function () {
    Route::get('/end_user', function () {
        return view('endUserDashboard');
    })->name('end_user');
});

// Dashboard route with middleware admin role
Route::middleware(['auth', 'role:admin', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // Get all users
    Route::get('/', [UserController::class, 'index'])->name('dashboard');
    // Regist user route
    Route::get('/regist_user', function () {
        return view('user.registUser');
    })->name('regist_user');;
});


/**
 * Admin routes
 */

// Destroy user route
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
