<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['name','surname','birthday','address','city'];

    public function classes(){
        return $this->belongsToMany(Classe::class, 'teacher_classes', 'teacher_id', 'class_id');
    }

    public function subjects(){
        return $this->belongsToMany(Subject::class, 'teacher_subjects', 'teacher_id', 'subject_id');
    }

    public function studentregister(){
        $this->belongsTo(GradesStudentRegister::class);
    }

    public function notesregister(){
        $this->belongsTo(NotesStudentRegister::class);
    }

    public function attendregister(){
        $this->belongsTo(AttendStudentRegister::class);
    }

    public function teacherregister(){
        $this->belongsTo(TeacherRegister::class);
    }

    public function calendar(){
        return $this->belongsTo(SchoolCalendar::class);
    }

    public function oldcalendar(){
        return $this->belongsTo(SchoolCalendarOld::class);
    }
}
