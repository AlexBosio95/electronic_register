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

        if ($teacher) {
            $classes = $teacher->classes;

            if ($classes->isNotEmpty()) {
                $selectedClassId = $request->input('selected_class');

                if ($selectedClassId) {
                    $selectedClass = $classes->where('id', $selectedClassId)->first();

                    if ($selectedClass) {
                        $students = $selectedClass->students;
                    } else {
                        return view('teacher.presents')->withErrors(['message' => 'Invalid selected class.']);
                    }
                } else {
                    $students = $classes->first()->students;
                }

                return view('teacher.presents', compact('students', 'classes'));
            } else {
                return view('teacher.presents')->withErrors(['message' => 'No classes found for the teacher.']);
            }
        } else {
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
