<?php

namespace App\Http\Controllers\AuthorizedUsers;

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
            // Validazione dei dati
            $validatedData = $request->validate([
                'student' => 'required|exists:students,id',
                'grade' => 'required|exists:grade_options,id',
                'subject' => 'required|exists:subjects,id',
                'date' => 'required'
            ]);
        } catch (\Exception $e) {
            // Log dell'eccezione di validazione
            Log::error('Validation error:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Validation error'], 422);
        }

        $userId = Auth::id();
        $teacher = Teacher::where('user_id', $userId)->first();

        if (!$teacher) {
            // Log errore se l'insegnante non è trovato
            Log::error('Teacher not found');
            return response()->json(['error' => 'Teacher not found'], 404);
        }

        $gradeName = GradeOption::findOrFail($validatedData['grade'])->name;

        try {
            $data = $validatedData['date'];
            $formattedDate = date('Y-m-d', strtotime($data));

            Log::info($formattedDate);

            $mark = GradesStudentRegister::create([
                'student_id' => $validatedData['student'],
                'teacher_id' => $teacher->id,
                'note' => $gradeName,
                'subject_id' => $validatedData['subject'],
                'type' => 'mark',
                'data' => $formattedDate,
            ]);
        } catch (\Exception $e) {
            // Log dell'eccezione durante la creazione del marchio
            Log::error('Error creating mark:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Error creating mark'], 500);
        }

        // Risposta con il marchio creato
        return response()->json($mark, 201);
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
            return response()->json(['message' => 'Voto non trovato.'], 404);
        }

        // Elimina il voto dal database
        $grade->delete();

        // Ritorna una risposta di successo
        return response()->json(['message' => 'Voto eliminato con successo.']);
    }

}
