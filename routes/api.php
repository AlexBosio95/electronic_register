<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorizedUsers\MarksController;

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


Route::get('/grades', [MarksController::class, 'getGrades']);
Route::delete('/marks/{id}', [MarksController::class, 'destroy']);
Route::get('/grade-options', [MarksController::class, 'getGradesOption']);
Route::get('/subject-options', [MarksController::class, 'getSubjectsOption']);
Route::post('/marks', [MarksController::class, 'store']);