<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $table = "classes";
    protected $fillable = ["name"];

    public function students(){
        return $this->hasMany(Student::class, 'class_id');
    }

    public function teachers(){
        return $this->belongsToMany(Classe::class, 'teacher_classes', 'class_id', 'teacher_id');
    }

    public function teacherregister(){
        return $this->belongsTo(TeacherRegister::class);
    }

    public function calendar(){
        return $this->belongsTo(SchoolCalendar::class);
    }

    public function oldcalendar(){
        return $this->belongsTo(SchoolCalendarOld::class);
    }
}
