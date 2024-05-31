<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradesStudentRegister extends Model
{
    use HasFactory;

    public $table = "grade_student_register";

    public $fillable = ['subject_id', 'student_id', 'teacher_id', 'data', 'note', 'type'];

    public function teachers(){
        $this->hasMany(Teacher::class);
    }

    public function subjects(){
        $this->hasMany(Subject::class);
    }

    public function students(){
        $this->hasMany(Student::class);
    }
}
