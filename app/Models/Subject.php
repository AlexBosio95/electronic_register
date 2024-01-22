<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ["name"];

    public function gradestudentregister(){
        $this->belongsTo(GradesStudentRegister::class);
    }

    public function teacherregister(){
        $this->belongsTo(TeacherRegister::class);
    }

    public function reports(){
        $this->belongsTo(Report::class);
    }

    public function teachers(){
        return $this->belongsToMany(Subject::class, 'teacher_subjects', 'subject_id', 'teacher_id');
    }

    public function calendar(){
        return $this->belongsTo(SchoolCalendar::class);
    }

    public function oldcalendar(){
        return $this->belongsTo(SchoolCalendarOld::class);
    }
}
