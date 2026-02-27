<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\InvitationController;
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

Route::get('/invitations/{token}', [InvitationController::class, 'show'])->name('invitations.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Colocations
    Route::get('/colocations', [ColocationController::class, 'index'])->name('colocations.index');
    Route::get('/colocations/{colocation}', [ColocationController::class, 'show'])->name('colocations.show');
    Route::post('/colocations', [ColocationController::class, 'store'])->name('colocations.store');
    Route::post('/colocations/{colocation}/leave', [ColocationController::class, 'leave'])->name('colocations.leave');
    Route::post('/colocations/{colocation}/cancel', [ColocationController::class, 'cancel'])->name('colocations.cancel');
    Route::post('/colocations/{colocation}/transfer', [ColocationController::class, 'transfer'])->name('colocations.transfer');
    Route::post('/colocations/{colocation}/kick/{user}', [ColocationController::class, 'kickMember'])->name('colocations.kick');
    // Invitations
    Route::post('/colocations/{colocation}/invitations', [InvitationController::class, 'store'])->name('invitations.store');
    Route::post('/invitations/accept/{token}', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::post('/invitations/decline/{token}', [InvitationController::class, 'decline'])->name('invitations.decline');
    Route::post('/colocations/{colocation}/generate-token',[InvitationController::class, 'generateTokenLink'])->name('invitations.generateToken');
    Route::get('/join/{token}', [InvitationController::class, 'join'])->name('invitations.join');
});

require __DIR__.'/auth.php';
