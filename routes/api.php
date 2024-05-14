<?php

use App\Http\Controllers\AuthorizedUsers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorizedUsers\MarksController;
use App\Http\Controllers\AuthorizedUsers\PresenceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Route::middleware('checkApi')->group(function () {
    Route::get('/grades', [ApiController::class, 'getGrades']);
    Route::delete('/marks/{id}', [MarksController::class, 'destroy']);
    Route::get('/grade-options', [ApiController::class, 'getGradesOption']);
    Route::get('/subject-options', [ApiController::class, 'getSubjectsOption']);
    Route::post('/marks', [MarksController::class, 'store']);
    Route::get('/students', [ApiController::class, 'getStudentsByClass']);
    Route::get('/timetable/{classId}/{dateParam}', [ApiController::class, 'getTimetable']);
    Route::post('/presences', [ApiController::class, 'getPresences']);
//});