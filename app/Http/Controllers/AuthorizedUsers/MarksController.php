<?php

namespace App\Http\Controllers\AuthorizedUsers;

use App\Http\Controllers\AuthorizedUsers\ControllerTraits\WithPresenceTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentRegister;
use App\Models\Classe;
use App\Models\Teacher;
use App\Models\GradesStudentRegister;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\GradeOption;
use App\Models\Subject;
use App\Models\Student;

class MarksController extends CommonController
{
    use WithPresenceTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->commonIndex($request, 'Voti');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'student' => 'required|exists:students,id',
                'grade' => 'required|exists:grade_options,id',
                'subject' => 'required|exists:subjects,id',
                'date' => 'required',
                'user' => 'required'
            ]);
        } catch (\Exception $e) {
            Log::error('Validation error:', ['message' => $e->getMessage()]);
            $result = false;
            $message = 'Validation error';
            $statusCode = 422;
            $responseData = [];
            return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
        }

        $userId = $validatedData['user'];

        if (!$userId) {
            Log::error('User ID is null');
            $result = false;
            $message = 'User ID is null';
            $statusCode = 500;
            $responseData = [];
            return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
        }

        $teacher = Teacher::where('user_id', $userId)->first();

        if (!$teacher) {
            Log::error('Teacher not found', ['userId' => $userId]);
            $result = false;
            $message = 'Teacher not found';
            $statusCode = 404;
            $responseData = [];
            return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
        }

        Log::info('Teacher found', ['teacher' => $teacher]);

        try {
            $gradeOption = GradeOption::findOrFail($validatedData['grade']);
            $gradeName = $gradeOption->name;
            Log::info('Grade option found', ['gradeName' => $gradeName]);
        } catch (\Exception $e) {
            Log::error('Grade option error:', ['message' => $e->getMessage()]);
            $result = false;
            $message = 'Grade option error';
            $statusCode = 500;
            $responseData = [];
            return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
        }

        try {
            $data = $validatedData['date'];
            $formattedDate = date('Y-m-d', strtotime($data));
            Log::info('Date formatted', ['formattedDate' => $formattedDate]);

            $mark = GradesStudentRegister::create([
                'student_id' => $validatedData['student'],
                'teacher_id' => $teacher->id,
                'note' => $gradeName,
                'subject_id' => $validatedData['subject'],
                'type' => 'mark',
                'data' => $formattedDate,
            ]);
        } catch (\Exception $e) {
            $result = false;
            $message = 'Validation error';
            $statusCode = 500;
            $responseData = [];
            return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
        }
        $result = true;
        $statusCode = 201;
        $message = 'Voto creato con successo';
        $responseData = [];
        return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Trova il voto da eliminare
        $grade = GradesStudentRegister::find($id);

        // Verifica se il voto esiste
        if (!$grade) {
            //return response()->json(['message' => 'Voto non trovato.'], 404);
            $result = false;
            $statusCode = 404;
            $message = 'Voto non trovato';
            $responseData = [];
            return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
        }

        // Elimina il voto dal database
        $grade->delete();

        $result = true;
        $statusCode = 200;
        $message = 'Voto cancellato con successo';
        $responseData = [];
        // Ritorna una risposta di successo
        //return response()->json(['message' => 'Voto eliminato con successo.']);
        return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
    }

}
