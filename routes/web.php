<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthorizedUsers\DashboardController;
use App\Http\Controllers\AuthorizedUsers\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!

*/

Route::get('/', function () {
    return view('welcomeTailwind');
});


//Rotte che serviranno SOLO agli utenti admin
Route::middleware('auth')->group(function () {
    //aggiungere i Controller
    Route::get('/teachers', [TeacherController::class, 'index']);
    //Route::resource('/students');
    //Route::resource('/classes');
    //Route::resource('/subjects');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
