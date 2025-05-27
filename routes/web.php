<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatController;
use App\Http\Controllers\AdoptionApplicationController;


Route::get('/', [CatController::class, 'index'])->name('cats.not_adopted');

Route::get('/cats/adopted', [CatController::class, 'indexAdopted'])->name('cats.adopted');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/cats/create', [CatController::class, 'create']);
    Route::post('/cats/store', [CatController::class, 'store']);
    Route::post('/cats/show', [CatController::class, 'show']);
    Route::post('/cats/edit', [CatController::class, 'edit']);
    Route::post('/cats/update', [CatController::class, 'update']);
    Route::post('/cats/destroy', [CatController::class, 'destroy']);
    Route::post('/cats/guestAdoption', [CatController::class, 'guestAdoption']);
    Route::get('/adoption-application/index', [AdoptionApplicationController::class, 'index']);
    Route::put('/adoption-applications/{id}', [AdoptionApplicationController::class, 'update'])->name('adoption-applications.update');
    Route::post('/adoption-application/store', [AdoptionApplicationController::class, 'store']);


});

/* use App\Models\Cat;
Route::get('/probar-relacion-cat', function () {
    $cat = Cat::find(6); // Cat::first()
    dd($cat->adoptionApplications);
}); */

/* use App\Models\User;
Route::get('/probar-relacion-user-cats', function () {
    $user = User::find(3);
    dd($user->cats);
}); */

/* use App\Models\User;
Route::get('/probar-user-adoptions', function () {
    $user = User::find(3);
    dd($user->adoptionApplications);
}); */

require __DIR__ . '/auth.php';
