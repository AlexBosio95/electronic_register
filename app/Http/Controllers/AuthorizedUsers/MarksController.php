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

class MarksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $user = Auth::user();
        $user_role = $user->role;
        $students = [];
        $classes = [];
        $page = 'Voti';

        $teacher = Teacher::where('user_id', $userId)->first();

        if ($teacher) {
            $classes = $teacher->classes;

            $grades = GradesStudentRegister::where('teacher_id', $teacher->id)
                                            ->where('type', 'mark')
                                            ->get();

            if ($classes->isNotEmpty()) {
                $selectedClassId = $request->input('selected_class');

                if ($selectedClassId) {
                    $selectedClass = $classes->where('id', $selectedClassId)->first();

                    if ($selectedClass) {
                        $students = $selectedClass->students;
                    } else {
                        return view('teacher.marks', compact('students', 'classes', 'user_role', 'page'))->withErrors(['message' => 'Invalid selected class.']);
                    }
                } else {
                    $students = $classes->first()->students;
                }

                return view('teacher.marks', compact('students', 'classes', 'user_role', 'page', 'grades'));
            } else {
                return view('teacher.marks', compact('students', 'classes', 'user_role', 'page'))->withErrors(['message' => 'No classes found for the teacher.']);
            }
        } else {
            return view('teacher.marks', compact('students', 'classes', 'user_role', 'page'))->withErrors(['message' => 'Teacher not found.']);
        }
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
            ]);
        } catch (\Exception $e) {
            // Log dell'eccezione di validazione
            \Log::error('Validation error:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Validation error'], 422);
        }

        $userId = Auth::id();
        $teacher = Teacher::where('user_id', $userId)->first();

        if (!$teacher) {
            // Log errore se l'insegnante non è trovato
            \Log::error('Teacher not found');
            return response()->json(['error' => 'Teacher not found'], 404);
        }

        $gradeName = GradeOption::findOrFail($validatedData['grade'])->name;

        try {
            $mark = GradesStudentRegister::create([
                'student_id' => $validatedData['student'],
                'teacher_id' => $teacher->id,
                'note' => $gradeName,
                'subject_id' => $validatedData['subject'],
                'type' => 'mark',
                'data' => now(),
            ]);
        } catch (\Exception $e) {
            // Log dell'eccezione durante la creazione del marchio
            \Log::error('Error creating mark:', ['message' => $e->getMessage()]);
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

    /**
     * Recupera i voti per quella classe
     */

    public function getGrades(Request $request)
    {
        // Verifica se è stata fornita una query string per la materia
        if ($request->has('subject')) {
            // Recupera i voti in base alla materia selezionata
            $subjectId = $request->input('subject');
            $grades = GradesStudentRegister::where('type', 'mark')
                                            ->where('subject_id', $subjectId)
                                            ->get();
        } else {
            $grades = [];
        }
    
        return response()->json($grades);
    }

    /**
     * Recupera le opzioni voti
     */

    public function getGradesOption()
    {
        $gradeOptions = GradeOption::all();
        return response()->json($gradeOptions);
    }

    /**
     * Recupera le opzioni materie
     */

    public function getSubjectsOption()
    {
        $subjectOption = Subject::all();
        return response()->json($subjectOption);
    }

    /**
     * Recupera gli studenti di quella classe
     */

    public function getStudentsByClass(Request $request)
    {
        if ($request->has('class')) {
            $classeId = $request->input('class');
            $classe = Classe::find($classeId);
            
            if ($classe) {
                $students = Student::where('class_id', $classeId)->get();
                return response()->json($students);
            } else {
                return response()->json(['message' => 'Classe non trovata'], 404);
            }
        } else {
            return response()->json(['message' => 'Parametro "class" mancante'], 400);
        }
    }

}
