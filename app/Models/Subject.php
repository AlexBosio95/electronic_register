<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ["name"];

    public function studentregister(){
        $this->belongsTo(StudentRegister::class);
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
}
