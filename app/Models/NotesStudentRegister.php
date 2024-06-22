<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotesStudentRegister extends Model
{
    use HasFactory;

    public $table = 'notes_student_register';
    public $fillable = ['student_id', 'teacher_id', 'data', 'note'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
