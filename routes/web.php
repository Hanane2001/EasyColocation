<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');
    Route::post('/admin/ban/{user}', [AdminController::class, 'ban'])->name('admin.ban');
    Route::post('/admin/unban/{user}', [AdminController::class, 'unban'])->name('admin.unban');
});

Route::get('/colocations', function () {
    return view('colocations');
})->middleware(['auth', 'verified'])->name('colocations');
Route::get('/invitations', function () {
    return view('invitations');
})->middleware(['auth', 'verified'])->name('invitations');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
