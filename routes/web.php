<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminCheck;
use App\Models\User;
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


Route::middleware('auth')->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::patch('/certificate/{user}/{certificate}', [ProfileController::class, 'addCertificate'])->name(
        'profile.certificate.add'
    );
    Route::delete('/certificate/{user}/{certificate}', [ProfileController::class, 'removeCertificate'])->name(
        'profile.certificate.remove'
    );
});


// Admin utilities
Route::middleware([AdminCheck::class, 'auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $users = User::paginate(10);
        $links = $users->links()->render();
        return Inertia::render('Dashboard', ['users' => $users, 'links' => $links]);
    })->name('dashboard');
    Route::put('/users/{user}/approve', [AdminController::class, 'Approve']);
    Route::put('/users/{user}/disapprove', [AdminController::class, 'Disapprove']);

    Route::prefix('reports')->group(function () {
        Route::get('/users', [\App\Http\Controllers\Reports::class, 'Users']);
        Route::get('/certificates', [\App\Http\Controllers\Reports::class, 'Certificates']);
    });
});

require __DIR__.'/auth.php';
