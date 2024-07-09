<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
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

// Login Routes...
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class,'login']);
Route::post('/logout',  [LoginController::class,'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Profile Routes...
Route::prefix('/profile')->group(function() {
    Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/update-profile', [ProfileController::class, 'updateProfile'])->name('profile.updateProfile');
    Route::put('/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});

// Staff Routes...
Route::prefix('/staffs')->group(function() {
    Route::group(['middleware' => ['permission:create.staffs']], function() {
        Route::get('/register', [StaffController::class, 'create'])->name('staff.register');
        Route::post('/store', [StaffController::class, 'store'])->name('staff.store');
    });

    Route::group(['middleware' => ['permission:read.staffs']], function() {
        Route::get('/', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/show/{id}', [StaffController::class, 'show'])->name('staff.show');
        Route::get('/search-staffs', [StaffController::class, 'searchStaff'])->name('staff.search');
    });

    Route::group(['middleware' => ['permission:update.staffs']], function() {
        Route::get('/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit');
        Route::patch('/update/{id}', [StaffController::class, 'update'])->name('staff.update');
        Route::put('/update-password/{id}', [StaffController::class, 'updatePassword'])->name('staff.update-password');
    });

    Route::group(['middleware' => ['permission:delete.staffs']], function() {
        Route::delete('/delete/{id}', [StaffController::class, 'destroy'])->name('staff.delete');
    });
});
