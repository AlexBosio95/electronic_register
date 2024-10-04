<?php

namespace App\Http\Controllers\AuthorizedUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeacherRegister;
use App\Http\Controllers\AuthorizedUsers\ControllerTraits\WithPresenceTrait;

class PlanController extends CommonController
{
    use WithPresenceTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->commonIndex($request, 'RegistroProfessori');
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
        // Validazione dell'input
        $validatedData = $request->validate([
            'teacher_id'  => 'required|exists:teachers,id',
            'class_id'    => 'required|exists:classes,id',
            'subject_id'    => 'required|exists:subject,id',
            'note'        => 'required|string|max:500',
            'datetime'    => 'required|date_format:Y-m-d\TH:i', 
        ]);
    
        try {
            $note = TeacherRegister::create([
                'teacher_id' => $validatedData['teacher_id'],
                'class_id'   => $validatedData['class_id'],
                'subject_id' => $validatedData['subject_id'],
                'note'       => $validatedData['note'],
                'datetime'   => $validatedData['datetime'],
            ]);
    
            return $this->ajaxLogAndResponse($note, 'Nota salvata con successo', true, 200);
        } catch (\Exception $e) {
            return $this->ajaxLogAndResponse(null, 'Errore durante il salvataggio: ' . $e->getMessage(), false, 500);
        }
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

    public function getOldNotes(Request $request)
    {
        $validatedData = $request->validate([
            'teacher_id'  => 'required|exists:teachers,id',
            'class_id'    => 'required|exists:classes,id',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
        ]);

        try {
            $notes = TeacherRegister::where('teacher_id', $validatedData['teacher_id'])
                ->where('class_id', $validatedData['class_id'])
                ->whereDate('datetime', '>=', $validatedData['start_date'])
                ->whereDate('datetime', '<=', $validatedData['end_date'])
                ->orderBy('datetime', 'asc')
                ->get();

            if ($notes->isEmpty()) {
                return $this->ajaxLogAndResponse([], 'Nessuna nota trovata nel periodo selezionato', true, 200);
            }

            return $this->ajaxLogAndResponse($notes, 'Note recuperate con successo', true, 200);
        } catch (\Exception $e) {
            return $this->ajaxLogAndResponse(null, 'Errore durante il recupero delle note: ' . $e->getMessage(), false, 500);
        }
    }

}
