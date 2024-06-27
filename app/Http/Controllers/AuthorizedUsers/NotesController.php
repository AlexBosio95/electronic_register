<?php

namespace App\Http\Controllers\AuthorizedUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotesStudentRegister;
use App\Http\Controllers\AuthorizedUsers\ControllerTraits\WithPresenceTrait;
use App\Models\Teacher;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class NotesController extends CommonController
{
    use WithPresenceTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->commonIndex($request, 'Note');
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
                'noteMessage' => 'required',
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

        try {
            $data = $validatedData['date'];
            $formattedDate = date('Y-m-d', strtotime($data));
            Log::info('Date formatted', ['formattedDate' => $formattedDate]);

            $note = NotesStudentRegister::create([
                'student_id' => $validatedData['student'],
                'teacher_id' => $teacher->id,
                'data' => $formattedDate,
                'note' => $validatedData['noteMessage'],
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            $result = false;
            $message = 'Validation error';
            $statusCode = 500;
            $responseData = [];
            return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
        }
        $result = true;
        $statusCode = 201;
        $message = 'Nota creata con successo';
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
    public function update(Request $request, $id)
    {
        // Validazione dei dati in arrivo
        $validatedData = $request->validate([
            'note' => 'required|string|max:255',
        ]);

        // Trova la nota da aggiornare
        $note = NotesStudentRegister::find($id);

        // Verifica se la nota esiste
        if (!$note) {
            $result = false;
            $statusCode = 404;
            $message = 'Nota non trovata';
            $responseData = [];
            return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
        }

        // Aggiorna la nota
        $note->note = $validatedData['note'];
        $note->save();

        $result = true;
        $statusCode = 200;
        $message = 'Nota modificata con successo';
        $responseData = $note;

        return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Trova il nota da eliminare
        $note = NotesStudentRegister::find($id);

        // Verifica se il nota esiste
        if (!$note) {
            $result = false;
            $statusCode = 404;
            $message = 'nota non trovata';
            $responseData = [];
            return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
        }

        // Elimina il nota dal database
        $note->delete();

        $result = true;
        $statusCode = 200;
        $message = 'Nota cancellata con successo';
        $responseData = [];
        return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
    }
}
