<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotesStudentRegister extends Model
{
    use HasFactory;

    public $table = 'notes_student_register';
    public $fillable = ['student_id', 'teacher_id', 'data', 'note'];

    public function teachers(){
        $this->hasMany(Teacher::class);
    }

    public function students(){
        $this->hasMany(Student::class);
    }
}
