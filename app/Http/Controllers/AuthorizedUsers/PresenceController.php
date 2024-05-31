<?php

namespace App\Http\Controllers\AuthorizedUsers;

use App\Http\Controllers\AuthorizedUsers\ControllerTraits\WithPresenceTrait;
use App\Http\Controllers\Controller;
use App\Models\AttendStudentRegister;
use Illuminate\Http\Request;
use App\Models\StudentRegister;
use App\Models\Classe;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class PresenceController extends CommonController
{
    use WithPresenceTrait;    
    
   
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->commonIndex($request, 'Presenze');
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
        Log::info($request);
        //Validazione dati
        $rules = [
            'student_id' => 'required|integer',
            'hiddenHour' => 'required|regex:/^\d{2}:\d{2}$/',
            'attendance' => 'required|in:P,A',
            'hiddenDate' => ['required', 'regex:/^\d{1,2}\s(?:January|February|March|April|May|June|July|August|September|October|November|December)\s\d{4}$/i'],
            'current_user' => 'required|integer'
        ];
        $messages = [
            'student_id.required' => 'Field Student ID is mandatory',
            'student_id.integer' => 'Field Student ID MUST BE an integer',
            'hiddenHour.required' => 'Field Hidden Hour is mandatory',
            'hiddenHour.regex' => 'Field Hidden Hour MUST BE in the format HH:MM.',
            'attendance.required' => 'Field Attendance is mandatory',
            'attendance.in' => 'Field Attendance MUST BE "P" o "A".',
            'hiddenDate.required' => 'Field Hidden Date is mandatory',
            'hiddenDate.regex' => 'Field Hidden Date MUST BE in the format day, month in letter in English and year.',
            'current_user.regex' => 'Field Id must be integer'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $student = $request->input('student_id');
        $hour = $request->input('hiddenHour');
        $userId = $request->input('current_user');
        $teacher = Teacher::where('user_id', $userId)->first()->id; 
        $presence = $request->input('attendance');
        $date = $request->input('hiddenDate');  
        $convertedDate = \DateTime::createFromFormat('j F Y', $date)->format('Y-m-d');     


        try {
            $stud = Student::findOrFail($student);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return back()->withErrors('Studente non trovato')->withInput();
        }
        $checkTeacherStudent = DB::table('teacher_classes')
                                    ->where('class_id', $stud->class_id)
                                    ->where('teacher_id', $teacher)
                                    ->get();
        if ($checkTeacherStudent->isEmpty()){
            return redirect()->back()->withErrors(['message' => 'Non è uno studente di quel prof']);
        }                       
        // Cerca un record con le stesse proprietà
        $checkExistingRecord = AttendStudentRegister::where([
            'student_id' => $student,
            'teacher_id' => $teacher,
            'presence' => $presence,
            'data' => $convertedDate,
            'hour' => $hour,
        ])->first();

        // Se esiste già un record corrispondente, ritorna un errore
        if ($checkExistingRecord) {
            return redirect()->back()->withErrors(['message' => 'Record già esistente']);
        }

        // Altrimenti, crea un nuovo record e lo salva nel database
        $record = new AttendStudentRegister();
        $record->student_id = $student;
        $record->teacher_id = $teacher;
        $record->presence = $presence;
        $record->data = $convertedDate;
        $record->hour = $hour;
        $record->note = "";
        $record->save();
        
        $newRecordId = $record->id;

        // Costruisci un array con i dati da restituire come JSON
        $responseData = [
            'success' => true,
            'message' => 'Dati salvati con successo!',
            'recordId' => $newRecordId,
        ];

        // Restituisci i dati come una risposta JSON
        return response()->json($responseData);
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
            return back()->withErrors("Parameter ID must be of type integer")->withInput();
        }
        $rules = [
            'attendance_mod' => 'required|in:P,A'
        ];
        $messages = [
            'attendance_mod.required' => 'Field Attendance is mandatory',
            'attendance_mod.in' => 'Field Attendance MUST BE "P" o "A".'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $presence = $request->input('attendance_mod');
        try{
            $toMod = AttendStudentRegister::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return back()->withErrors('Record della presenza non trovato')->withInput();
        }
        $toMod->presence = $presence;
        $toMod->save();
        // Costruisci un array con i dati da restituire come JSON
        $responseData = [
            'success' => true,
            'message' => 'Dati salvati con successo!'
        ];
        return $responseData;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $pres = AttendStudentRegister::findOrFail($id);   
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            Log::info($e);
        }
        $pres->delete();
        $responseData = [
            'success' => true,
            'message' => 'Dati salvati con successo!'
        ];
        return $responseData;
    }

}
