<?php

use App\Http\Controllers\AuthorizedUsers\ApiController;
use App\Http\Controllers\AuthorizedUsers\JustificationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\AuthorizedUsers\MarksController;
use App\Http\Controllers\AuthorizedUsers\PresenceController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\AuthorizedUsers\NotesController;
use App\Http\Controllers\AuthorizedUsers\PlanController;
use App\Http\Controllers\AuthorizedUsers\TimetableController;

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


Route::middleware('checkApi')->group(function () {
    Route::post('/dashboard', [PresenceController::class, 'store']);
    Route::delete('/dashboard/{id}', [PresenceController::class, 'destroy']);
    Route::put('/dashboard/{id}', [PresenceController::class, 'update']);
    Route::delete('/marks/{id}', [MarksController::class, 'destroy']);
    Route::post('/marks', [MarksController::class, 'store']);
    Route::get('/grade-options', [ApiController::class, 'getGradesOption']);
    Route::get('/subject-options', [ApiController::class, 'getSubjectsOption']);
    Route::get('/grades', [ApiController::class, 'getGrades']);
    Route::get('/notes', [ApiController::class, 'getNotes']);
    Route::get('/students', [ApiController::class, 'getStudentsByClass']);
    Route::get('/timetable/{classId}/{dateParam}', [ApiController::class, 'getTimetable']);
    Route::post('/presences', [ApiController::class, 'getPresences']);
    Route::get('/absences/{month}/{type}', [ApiController::class, 'getJustifications']);
    Route::put('/justification/{id}', [JustificationsController::class, 'update']);
    Route::delete('/notes/{id}', [NotesController::class, 'destroy']);
    Route::put('/notes/{id}', [NotesController::class, 'update']);
    Route::post('/note-add', [NotesController::class, 'store']);
    Route::post('/salva-note', [PlanController::class, 'store']);
    Route::get('/vecchie-note', [PlanController::class, 'getOldNotes']);
    Route::get('/getTimetableByClass/{classe}',[ApiController::class, 'getTimetableByClass']);
    Route::get('/getTeacherPerClass/{classe}',[ApiController::class, 'getTeacherPerClass']);
    Route::get('/getTeacherSubjects/{teacher}', [ApiController::class, 'getTeacherSubjects']);
    Route::put('updateTimetable/{calendarId}/{subjectId}/{teacherId}', [ApiController::class, 'updateTimetable']);

});
