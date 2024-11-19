<?php

use App\Http\Controllers\SocialAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BadgesController;
use App\Http\Controllers\VouchersController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

 // ===========================
    //        Home Route
    // ===========================
    Route::get('/', function () {
        return view('home');
    })->name('home');

// ===========================
//        Authentication Routes
// ===========================

// Show Registration Form
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

// Handle Registration Submission
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Show Login Form
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
 // ===========================

// Handle Login Submission
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Handle Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/login/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('login/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('social.callback');
// ===========================
//        Protected Routes
// ===========================

// Apply 'auth' middleware to all protected routes
Route::middleware(['auth'])->group(function () {

    // User Routes
    Route::prefix('user')->name('user.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

        // Task Management
        Route::post('/tasks/{taskId}/start', [UserController::class, 'startTask'])->name('tasks.start');
        Route::post('/tasks/{taskId}/take', [UserController::class, 'takeTask'])->name('tasks.take');
        Route::post('/user-tasks/{userTaskId}/complete', [UserController::class, 'completeTask'])->name('userTasks.complete');

        // Voucher Redemption
        Route::post('/vouchers/{voucherId}/redeem', [UserController::class, 'redeemVoucher'])->name('vouchers.redeem');

        // Leaderboard
        Route::get('/leaderboard', [UserController::class, 'leaderboard'])->name('leaderboard');

        // Interaction Logging
        Route::post('/tasks/{task}/interaction', [UserController::class, 'logInteraction'])->name('tasks.interaction');

        // Task Statistics
        Route::get('/tasks/statistics', [UserController::class, 'taskStatistics'])->name('tasks.statistics');

        // Profile Management
        Route::get('/profile', [UserController::class, 'profile'])->name('profile.show');
        Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    });

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Task Management (Admin) - Explicit Routes
        Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index'); // List all tasks
        Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create'); // Show create task form
        Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store'); // Create a new task
        Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show'); // Show specific task
        Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit'); // Show edit form
        Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update'); // Update specific task
        Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy'); // Delete specific task

        // Additional Task Management Routes (if needed)
        Route::get('/tasks/statistics', [TaskController::class, 'taskStatistics'])->name('tasks.statistics'); // Task statistics
        Route::post('/tasks/{taskId}/interaction', [TaskController::class, 'logInteraction'])->name('tasks.interaction');

        // Voucher Management (Admin)
        Route::get('/vouchers', [VouchersController::class, 'index'])->name('vouchers.index');
        Route::get('/vouchers/create', [VouchersController::class, 'create'])->name('vouchers.create');
        Route::post('/vouchers', [VouchersController::class, 'store'])->name('vouchers.store');
        Route::get('/vouchers/{id}', [VouchersController::class, 'show'])->name('vouchers.show');
        Route::get('/vouchers/{id}/edit', [VouchersController::class, 'edit'])->name('vouchers.edit');
        Route::put('/vouchers/{id}', [VouchersController::class, 'update'])->name('vouchers.update');
        Route::delete('/vouchers/{id}', [VouchersController::class, 'destroy'])->name('vouchers.destroy');
        Route::get('/vouchers/{id}/redemption-history', [VouchersController::class, 'redemptionHistory'])->name('vouchers.redemptionHistory');

        // Badge Management (Admin)
        Route::get('/badges', [BadgesController::class, 'index'])->name('badges.index');
        Route::get('/badges/create', [BadgesController::class, 'create'])->name('badges.create');
        Route::post('/badges', [BadgesController::class, 'store'])->name('badges.store');
        Route::get('/badges/{id}', [BadgesController::class, 'show'])->name('badges.show');
        Route::get('/badges/{id}/edit', [BadgesController::class, 'edit'])->name('badges.edit');
        Route::put('/badges/{id}', [BadgesController::class, 'update'])->name('badges.update');
        Route::delete('/badges/{id}', [BadgesController::class, 'destroy'])->name('badges.destroy');

        // Activity Logs
        Route::get('/activities', [AdminController::class, 'viewActivities'])->name('activities');
    });

   
});