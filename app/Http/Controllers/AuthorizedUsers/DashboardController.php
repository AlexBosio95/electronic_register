<?php

namespace App\Http\Controllers\AuthorizedUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentRegister;
use App\Models\Classe;
use App\Models\Teacher;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        $teacher = Teacher::where('user_id', $userId)->first();

        // Verifica se l'insegnante è stato trovato
        if ($teacher) {
            // Ottenere le classi associate all'insegnante
            $classes = $teacher->classes;

            // Verifica se almeno una classe è associata all'insegnante
            if ($classes->isNotEmpty()) {
                $selectedClassId = $request->input('selected_class');

                // Verifica se è stata selezionata una classe specifica
                if ($selectedClassId) {
                    // Ottieni la classe selezionata
                    $selectedClass = $classes->where('id', $selectedClassId)->first();

                    // Verifica se la classe selezionata è valida
                    if ($selectedClass) {
                        // Ottieni gli studenti della classe selezionata
                        $students = $selectedClass->students;
                    } else {
                        return view('teacher.presents')->withErrors(['message' => 'Invalid selected class.']);
                    }
                } else {
                    // Supponendo che si vogliano gli studenti della prima classe trovata
                    $students = $classes->first()->students;
                }

                return view('teacher.presents', compact('students', 'classes'));
            } else {
                return view('teacher.presents')->withErrors(['message' => 'No classes found for the teacher.']);
            }
        } else {
            // Gestire il caso in cui l'insegnante non è stato trovato
            return view('teacher.presents')->withErrors(['message' => 'Teacher not found.']);
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
        //
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
        //
    }
}
