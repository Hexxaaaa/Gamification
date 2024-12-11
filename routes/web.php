<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BadgesController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VouchersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
 */

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

Route::middleware(['auth'])->group(function () {
    // User Routes
    Route::prefix('user')->name('user.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

        // Task Management
        Route::get('/tasks', [MovieController::class, 'index'])->name('tasks.index');
        Route::get('/tasks/search', [MovieController::class, 'search'])->name('tasks.search');
        Route::get('/tasks/{taskId}/check', [UserController::class, 'checkTaskAvailability'])->name('tasks.check');
        Route::post('/tasks/{taskId}/take', [UserController::class, 'takeTask'])->name('tasks.take');
        Route::post('/tasks/{taskId}/start', [UserController::class, 'startTask'])->name('tasks.start');
        Route::get('/tasks/{userTaskId}', [UserController::class, 'showTask'])->name('tasks.show');
        Route::post('/tasks/{task}/interaction', [UserController::class, 'logInteraction'])->name('tasks.interaction');
        Route::post('/tasks/{userTask}/complete', [UserController::class, 'completeTask'])->name('tasks.complete');
        Route::post('/tasks/{userTask}/watched', [UserController::class, 'markVideoWatched'])->name('tasks.markWatched');

        // Voucher Redemption
        Route::get('/vouchers', [VouchersController::class, 'userIndex'])->name('vouchers.index');
        Route::post('/vouchers/{voucherId}/redeem', [UserController::class, 'redeemVoucher'])->name('vouchers.redeem');

        // Leaderboard
        Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

        // badges
        Route::post('/badges/{id}/claim', [BadgesController::class, 'claim'])->name('badges.claim');
        // Task Statistics
        Route::get('/tasks/statistics', [UserController::class, 'taskStatistics'])->name('tasks.statistics');

        //faq
        Route::get('/faq', [FAQController::class, 'index'])->name('faq.index');
        // Profile Management
        Route::get('/profile', [UserController::class, 'profile'])->name('profile.show');
        Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

        Route::post('/checkin', [UserController::class, 'checkIn'])->name('checkin');
        Route::get('/checkin-status', [UserController::class, 'checkInStatus'])->name('checkin.status');

    });

    Route::group([
        'middleware' => ['auth', 'admin'], // Add both middlewares
        'prefix' => 'admin',
        'as' => 'admin.',
    ], function () {
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

        // User Management
        Route::get('/users', [AdminController::class, 'indexUsers'])->name('users.index');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('users.show');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
        Route::post('/users/{id}/deactivate', [AdminController::class, 'deactivateUser'])->name('users.deactivate');

        // Activity Logs
        Route::get('/activities', [AdminController::class, 'viewActivities'])->name('activities');
    });
});

// ===========================
//        Home Route
// ===========================
Route::get('/', function () {
    return view('home');
})->name('home');