<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatController;

Route::get('/', [CatController::class, 'index'])->name('cats.not_adopted');

Route::get('/cats/adopted', [CatController::class, 'indexAdopted'])->name('cats.adopted');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/cats/create', [CatController::class, 'create']);
Route::post('/cats/store', [CatController::class, 'store']);

require __DIR__.'/auth.php';
