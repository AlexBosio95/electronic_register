<?php

namespace App\Http\Controllers\AuthorizedUsers;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\AuthorizedUsers\ControllerTraits\WithPresenceTrait;

class JustificationsController extends CommonController
{
    use WithPresenceTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->commonIndex($request, 'Giustificazioni/Assenze');
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
        if(!is_numeric($id)){
            //return back()->withErrors("Parameter ID must be of type integer")->withInput();
            $message = 'Parameter ID must be of type integer';
            $result = false;
            $statusCode = 400;
            $responseData = [];
            return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
        }
        $rules = [
            'status' => 'required|in:approved'
        ];
        $messages = [
            'status.required' => 'Field Attendance is mandatory',
            'status.in' => 'Field Attendance MUST BE "approved"".'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            //return back()->withErrors($validator)->withInput();
            $message = 'Errore nella validazione dei dati di input, controllarli';
            $result = false;
            $statusCode = 400;
            $responseData = [];
            return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
        }
        try {
            $toMod = Absence::findOrFail($id);
            $res = Carbon::parse($toMod->date);
            $month = $res->format('m');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            $message = 'Assenza non trovato';
            $result = false;
            $statusCode = 404;
            $responseData = [];
            return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
        }
        $toMod->status = $request->input('status');
        $toMod->reason = $request->input('reason');
        $toMod->save();

        $result = true;
        $message = "Assenza giustificata con successo!";
        $statusCode = 200;
        $absences = Absence::whereMonth('date', $month)->orderBy('date')->get();
        // Restituisci i dati come una risposta JSON
        return $this->ajaxLogAndResponse($absences, $message, $result, $statusCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
