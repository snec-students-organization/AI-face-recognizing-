<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => ['auth', 'verified', 'admin'], 'prefix' => 'admin'], function () {
    Route::get('/people', [AdminController::class, 'index'])->name('admin.person.index');
    Route::get('/person/create', [AdminController::class, 'create'])->name('admin.person.create');
    Route::post('/person/store', [AdminController::class, 'store'])->name('admin.person.store');
    Route::delete('/person/{person}', [AdminController::class, 'destroy'])->name('admin.person.destroy');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.person.index');
})->middleware(['auth', 'verified', 'admin'])->name('dashboard');

require __DIR__ . '/auth.php';
