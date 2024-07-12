<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TaskController;
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
Route::get('/', function () {
    return redirect('/login');
});
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class,'login']);
Route::post('/logout',  [LoginController::class,'logout'])->name('logout');

// Dashboard Route...
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

// Project Routes...
Route::prefix('/projects')->group(function() {
    Route::group(['middleware' => ['permission:create.projects']], function() {
        Route::get('/new-project', [ProjectController::class, 'create'])->name('project.create');
        Route::post('/store', [ProjectController::class, 'store'])->name('project.store');
    });

    Route::group(['middleware' => ['permission:read.projects']], function() {
        Route::get('/', [ProjectController::class, 'index'])->name('project.index');
        Route::get('/show/{id}', [ProjectController::class, 'show'])->name('project.show');
        Route::get('/search-projects', [ProjectController::class, 'searchProject'])->name('project.search');
    });

    Route::group(['middleware' => ['permission:update.projects']], function() {
        Route::get('/edit/{id}', [ProjectController::class, 'edit'])->name('project.edit');
        Route::patch('/update/{id}', [ProjectController::class, 'update'])->name('project.update');
    });

    Route::group(['middleware' => ['permission:delete.projects']], function() {
        Route::delete('/delete/{id}', [ProjectController::class, 'destroy'])->name('project.delete');
    });

    // Task Routes...
    Route::prefix('/{projectId}/tasks')->group(function() {
        Route::group(['middleware' => ['permission:create.tasks']], function() {
            Route::get('/new-task', [TaskController::class, 'create'])->name('task.create');
            Route::post('/store', [TaskController::class, 'store'])->name('task.store');
        });

        Route::group(['middleware' => ['permission:read.tasks']], function() {
            Route::get('/', [TaskController::class, 'index'])->name('task.index');
            Route::get('/show/{taskId}', [TaskController::class, 'show'])->name('task.show');
            // Route::get('/search-tasks', [TaskController::class, 'searchTask'])->name('task.search');
        });

        Route::group(['middleware' => ['permission:update.tasks']], function() {
            Route::get('/edit/{taskId}', [TaskController::class, 'edit'])->name('task.edit');
            Route::patch('/update/{taskId}', [TaskController::class, 'update'])->name('task.update');
        });

        Route::group(['middleware' => ['permission:delete.tasks']], function() {
            Route::delete('/delete/{taskId}', [TaskController::class, 'destroy'])->name('task.delete');
        });
    });
});
