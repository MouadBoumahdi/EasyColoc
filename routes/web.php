<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserNotBanned;

Route::get('/', function () {
    return view('welcome');
});

 

Route::middleware(['auth',EnsureUserNotBanned::class])->group(function () {

    Route::get('/category',[CategoryController::class, 'index'])
        ->name('category');

  
    //admin 
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/users/{user}/toggleban',[AdminController::class, 'toggleBan']);

    // colocation
    Route::get('/colocations/create', [ColocationController::class,'create'])->name('colocations.create');
    Route::post('/colocations/store', [ColocationController::class,'store'])->name('colocations.store');
    Route::post('/colocations/leave', [ColocationController::class,'leave'])->name('colocations.leave');
    Route::post('/colocation/delete/{user_id}', [ColocationController::class,'removeMember'])->name('colocation.remove');

    // Invitations
    Route::post('/invitations/send', [\App\Http\Controllers\InvitationController::class, 'store'])
        ->name('invitations.send');
    Route::get('/invitations/choose/{token}', [\App\Http\Controllers\InvitationController::class, 'choose'])
        ->name('invitations.choose');
    Route::get('/invitations/accept/{token}', [\App\Http\Controllers\InvitationController::class, 'accept'])
        ->name('invitations.accept');
    Route::get('/invitations/refuse/{token}', [\App\Http\Controllers\InvitationController::class, 'refuse'])
        ->name('invitations.refuse');

    // categories
    Route::post('/categories/store', [CategoryController::class, 'store'])
        ->name('categories.store');
    Route::get('/categories/show', [CategoryController::class, 'show']);

    // expense
    Route::get('/dashboard',[ExpenseController::class, 'index'])->name('dashboard');
    Route::post('/expense/store',[ExpenseController::class, 'store'])->name('expense.store');
    Route::delete('/expense/{expense}',[ExpenseController::class, 'destroy'])->name('expense.destroy');

    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/expense/settle', [ExpenseController::class, 'settle'])
    ->name('expense.settle');
});




require __DIR__.'/auth.php';
