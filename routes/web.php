<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin utilities
Route::middleware([\App\Http\Middleware\AdminCheck::class, 'auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $users = \App\Models\User::paginate(10);
        $links = $users->links()->render();
        return Inertia::render('Dashboard', ['users' => $users, 'links' => $links]);
    })->name('dashboard');
    Route::put('/users/{user}/approve', [\App\Http\Controllers\AdminController::class, 'Approve']);
    Route::put(
        '/users/{user}/certificate/{certificate}/add',
        [\App\Http\Controllers\ProfileController::class, 'addCertificate']
    );
    Route::put(
        '/users/{user}/certificate/{certificate}/remove',
        [\App\Http\Controllers\ProfileController::class, 'removeCertificate']
    );
});

require __DIR__.'/auth.php';
