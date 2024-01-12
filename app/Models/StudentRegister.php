<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRegister extends Model
{
    use HasFactory;

    protected $table = "student_register";
    protected $fillable = ["note"];

    function students(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function teachers(){
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function subjects(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function events(){
        return $this->belongsTo(Event::class, 'event_id');
    }
}
