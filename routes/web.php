<?php

use App\Http\Controllers\AuthorizedUsers\ClassController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthorizedUsers\DashboardController;
use App\Http\Controllers\AuthorizedUsers\JustificationsController;
use App\Http\Controllers\AuthorizedUsers\MarksController;
use App\Http\Controllers\AuthorizedUsers\NotesController;
use App\Http\Controllers\AuthorizedUsers\PlanController;
use App\Http\Controllers\AuthorizedUsers\StudentController;
use App\Http\Controllers\AuthorizedUsers\SubjectsController;
use App\Http\Controllers\AuthorizedUsers\TeacherController;
use App\Http\Controllers\AuthorizedUsers\TimetableController;
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
Route::middleware(['auth','checkUser','verified'])->group(function () {
    //aggiungere i Controller
    Route::resource('/teachers', TeacherController::class);
    Route::resource('/students', StudentController::class);
    Route::resource('/classes', ClassController::class);
    Route::resource('/subjects', SubjectsController::class);
    Route::resource('/marks', MarksController::class);
    Route::resource('/notes', NotesController::class);
    Route::resource('/justifications', JustificationsController::class);
    Route::resource('/plan', PlanController::class);
    Route::resource('/timetable', TimetableController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
