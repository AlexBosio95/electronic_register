<?php

namespace App\Http\Controllers\AuthorizedUsers;

use App\Http\Controllers\Controller;
use App\Models\AttendStudentRegister;
use Illuminate\Http\Request;
use App\Models\StudentRegister;
use App\Models\Classe;
use App\Models\Teacher;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $user_role = $user->role;
        $students = [];
        $classes = [];
        $timetable = [];
        $page = 'Presenze';
        /*inizializzo current_date e current_day con giorno corrente e data corrente */
        $current_date = date("Y-m-d");
        $current_day = strftime('%A');
        if($request->input('current_date') !== null)
        {
            /*validazione campo classe*/
            $rules = [
                'current_date' => ['regex:/^\d{1,2}\s(?:January|February|March|April|May|June|July|August|September|October|November|December)\s\d{4}$/i'],
            ];
            $messages = [
                'current_date.regex' => 'Field :attribute MUST BE in this format: day, month in letter in English INGLESE and year.',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $current_date = $request->input('current_date');
            $current_date = \DateTime::createFromFormat('j F Y', $current_date)->format('Y-m-d');
            $current_day = date("l", strtotime($current_date));
        }

        $teacher = Teacher::where('user_id', $userId)->first();

        if ($teacher) {
            $classes = $teacher->classes;

            if ($classes->isNotEmpty()) {
                /*validazione campo classe*/
                $rules = [
                    'selected_class' => 'integer',
                ];
                $messages = [
                    'selected_class.integer' => 'Field :attribute MUST BE an id, an integer number',
                ];
                $validator = Validator::make($request->all(), $rules, $messages);
                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }
                $selectedClassId = $request->input('selected_class');

                if ($selectedClassId) {
                    $selectedClass = $classes->where('id', $selectedClassId)->first();                
                    if ($selectedClass) {
                        $students = $selectedClass->students;
                        $timetable = $selectedClass->calendar;
                    } else {
                        return view('teacher.presents', compact('students', 'classes', 'user_role', 'page', 'timetable','current_date','current_day'))->withErrors(['message' => 'Invalid selected class.']);
                    }
                } else {
                    $students = $classes->first()->students;
                    $timetable = $classes->first()->calendar;
                }

                return view('teacher.presents', compact('students', 'classes', 'user_role', 'page', 'timetable','current_date','current_day'));
            } else {
                return view('teacher.presents', compact('students', 'classes', 'user_role', 'page', 'timetable','current_date','current_day'))->withErrors(['message' => 'No classes found for the teacher.']);
            }
        } else {
            return view('teacher.presents', compact('students', 'classes', 'user_role', 'page', 'timetable','current_date','current_day'))->withErrors(['message' => 'Teacher not found.']);
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
        $student = $request->input('student_id');
        $hour = $request->input('hiddenHour');
        $userId = Auth::id();
        $teacher = Teacher::where('user_id', $userId)->first()->id; 
        $presence = $request->input('attendance');
        $date = $request->input('hiddenDate');  
        $convertedDate = \DateTime::createFromFormat('j F Y', $date)->format('Y-m-d');
        $record = new AttendStudentRegister();
        $record->student_id = $student;
        $record->teacher_id = $teacher;
        $record->presence = $presence;
        $record->data = $convertedDate;
        $record->hour = $hour;
        $record->note = "";
        $record->save();
        return redirect()->back()->with('success', 'Dati salvati con successo!');
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
        $presence = $request->input('attendance_mod');
        $toMod = AttendStudentRegister::findOrFail($id);
        $toMod->presence = $presence;
        $toMod->save();
        return redirect()->back()->with('success', 'Modifica effettuata con successo!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
