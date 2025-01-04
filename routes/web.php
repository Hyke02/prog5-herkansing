<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('post', PostController::class)->except(['show']);

    ROute::get('/admin/users', function () {
        if (auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        $users = \App\Models\User::all();
        return view('admin/users', compact('users'));
    })->name('admin.users');
});

Route::get('post/{post}', [PostController::class, 'show'])->name('post.show');

require __DIR__.'/auth.php';
