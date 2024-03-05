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

class PresenceController extends Controller
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
        $timetable = [];
        $page = 'Presenze';

        $teacher = Teacher::where('user_id', $userId)->first();

        if ($teacher) {
            $classes = $teacher->classes;

            if ($classes->isNotEmpty()) {
                $selectedClassId = $request->input('selected_class');

                if ($selectedClassId) {
                    $selectedClass = $classes->where('id', $selectedClassId)->first();
                    $timetable = $selectedClass->calendar;

                    if ($selectedClass) {
                        $students = $selectedClass->students;
                    } else {
                        return view('teacher.presents', compact('students', 'classes', 'user_role', 'page', 'timetable'))->withErrors(['message' => 'Invalid selected class.']);
                    }
                } else {
                    $students = $classes->first()->students;
                    $timetable = $classes->first()->calendar;
                    
                    foreach($students as $student){
                        Log::info($student->id. " " .$student->presences);
                    }
                }

                return view('teacher.presents', compact('students', 'classes', 'user_role', 'page', 'timetable'));
            } else {
                return view('teacher.presents', compact('students', 'classes', 'user_role', 'page', 'timetable'))->withErrors(['message' => 'No classes found for the teacher.']);
            }
        } else {
            return view('teacher.presents', compact('students', 'classes', 'user_role', 'page', 'timetable'))->withErrors(['message' => 'Teacher not found.']);
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
