<?php

namespace App\Http\Controllers\AuthorizedUsers;

use App\Http\Controllers\AuthorizedUsers\ControllerTraits\WithPresenceTrait;
use App\Http\Controllers\Controller;
use App\Models\Absence;
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
use Symfony\Component\HttpKernel\DataCollector\AjaxDataCollector;

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
            $message = 'Errore nella validazione dei dati, controllarli';
            $result = false;
            $statusCode = 400;
            $responseData = [];
            return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
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
            $message = 'Studente non trovato';
            $result = false;
            $statusCode = 404;
            $responseData = [];
            return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
        }
        $checkTeacherStudent = DB::table('teacher_classes')
                                    ->where('class_id', $stud->class_id)
                                    ->where('teacher_id', $teacher)
                                    ->get();
        if ($checkTeacherStudent->isEmpty()){
            $message = 'Non è uno studente di quel prof';
            $result = false;
            $statusCode = 400;
            $responseData = [];
            return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
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
            $message = 'Record già esistente';
            $result = false;
            $statusCode = 400;
            $responseData = [];
            return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
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

        if ($newRecordId){
            //se c'è già per quel giorno la aggiorno
            if ($presence == 'A'){
                try{
                    $absence = Absence::where('date', $convertedDate)
                                        ->where('student_id', $student)
                                        ->get();
                    if ($absence->count() == 1){
                        $toUdate = $absence->first();
                        $toUdate->hours += 1;
                        $toUdate->save();
                    } else {
                        $absenceRecord = new Absence();
                        $absenceRecord->student_id = $student;
                        $absenceRecord->date = $convertedDate;
                        $absenceRecord->status = 'pending';
                        $absenceRecord->reason = '';
                        $absenceRecord->save();
                    }
                } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
                    //return back()->withErrors('Record della presenza non trovato')->withInput();
                    $message = 'Record della presenza non trovato';
                    $result = false;
                    $statusCode = 404;
                    $responseData = [];
                    return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
                }
            }    
        }

        // Costruisci un array con i dati da restituire come JSON
        $responseData = [
            'recordId' => $newRecordId
        ];
        $result = true;
        $message = "Dato inserito con successo!";
        $statusCode = 200;
        // Restituisci i dati come una risposta JSON
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
        if(!is_numeric($id)){
            //return back()->withErrors("Parameter ID must be of type integer")->withInput();
            $message = 'Parameter ID must be of type integer';
            $result = false;
            $statusCode = 400;
            $responseData = [];
            return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
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
            //return back()->withErrors($validator)->withInput();
            $message = 'Errore nella validazione dei dati di input, controllarli';
            $result = false;
            $statusCode = 400;
            $responseData = [];
            return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
        }
        $presence = $request->input('attendance_mod');
        $toMod = AttendStudentRegister::findOrFail($id);
        //cerco l'assenza da aggiornare
        if($presence != $toMod->presence){
            if ($presence == 'A'){
                try{
                    $absence = Absence::where('date', $toMod->data)
                                        ->where('student_id', $toMod->student_id)
                                        ->get();
                    if ($absence->count() == 1){
                        $toUdate = $absence->first();
                        $toUdate->hours += 1;
                        $toUdate->save();
                    }
                } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
                    //return back()->withErrors('Record della presenza non trovato')->withInput();
                    $message = 'Record della presenza non trovato';
                    $result = false;
                    $statusCode = 404;
                    $responseData = [];
                    return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
                }
            } elseif ($presence == 'P') {
                $absence = Absence::where('date', $toMod->data)
                                    ->where('student_id', $toMod->student_id)
                                    ->get();
                if ($absence->count() == 1 && $absence->first()->hours > 1){
                    $toUdate = $absence->first();
                    $toUdate->hours -= 1;
                    $toUdate->save();
                } elseif ($absence->count() == 1 && $absence->first()->hours <= 1) {
                    $toUdate = $absence->first();
                    $toUdate->delete();
                }
            }
            $toMod->presence = $presence;
            $toMod->save();
        }

        // Costruisci un array con i dati da restituire come JSON
        $responseData = [];
        $result = true;
        $message = 'Dati salvati con successo!';
        $statusCode = 200;
        //return $responseData;
        return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $pres = AttendStudentRegister::findOrFail($id);   
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            $message = $e;
            $result = false;
            $statusCode = 404;
            $responseData = [];
            return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
        }
        
        //cancella l'assenza
        $absence = Absence::where('date', $pres->data)
                            ->where('student_id', $pres->student_id)
                            ->get();
        if ($absence->count() == 1 && $absence->first()->hours > 1){
            $toUdate = $absence->first();
            $toUdate->hours -= 1;
            $toUdate->save();
        } elseif ($absence->count() == 1 && $absence->first()->hours <= 1) {
            $toUdate = $absence->first();
            $toUdate->delete();
        }
        $pres->delete();
        $result = true;
        $message = 'Dati salvati con successo!';
        $statusCode = 200;
        $responseData = [];
        return $this->ajaxLogAndResponse($responseData, $message, $result, $statusCode);
    }

}
