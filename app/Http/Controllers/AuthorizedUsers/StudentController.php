<?php

namespace App\Http\Controllers\AuthorizedUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttendStudentRegister;
use Illuminate\Validation\Rule;
use App\Models\Teacher;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function update(Request $request, $studentId)
    {
        $request->validate([
            'presence' => ['required', Rule::in(['A', 'P'])],
            'student_id' => ['required', Rule::exists('students', 'id')],
        ]);

        $existingRecord = AttendStudentRegister::where('student_id', $studentId)
            ->whereDate('data', now()->toDateString())
            ->first();

        if ($existingRecord) {
            $existingRecord->update([
                'presence' => $request->input('presence'),
            ]);
        } else {
            $userId = Auth::id();
            $teacher = Teacher::where('user_id', $userId)->first();

            AttendStudentRegister::create([
                'student_id' => $studentId,
                'teacher_id' => $teacher->id,
                'presence' => $request->input('presence'),
                'note' => 'no note',
                'data' => now()->toDateString(),
            ]);
        }

        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
