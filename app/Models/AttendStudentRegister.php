<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendStudentRegister extends Model
{
    use HasFactory;

    public $table = 'attend_student_register';
    public $fillable = ['student_id', 'teacher_id', 'data', 'presence', 'note'];

    public function teachers(){
        return $this->hasMany(Teacher::class, 'teacher_id');
    }

    public function students(){
        return $this->belongsTo(Student::class);
    }
}
