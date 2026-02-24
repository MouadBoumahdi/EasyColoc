<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserNotBanned;

Route::get('/', function () {
    return view('welcome');
});

 

Route::middleware(['auth',EnsureUserNotBanned::class])->group(function () {

    Route::get('/dashboard',function(){
        if(auth()->user()->is_global_admin){
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/users/{user}/toggleban',[AdminController::class, 'toggleBan']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




require __DIR__.'/auth.php';
