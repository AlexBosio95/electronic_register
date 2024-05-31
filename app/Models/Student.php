<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name','surname','birthday','address','city'];

    public function class(){
        return $this->belongsTo(Classe::class, 'class_id');
    }

    public function grades(){
        return $this->belongsTo(GradesStudentRegister::class);
    }

    public function notes(){
        return $this->belongsTo(NotesStudentRegister::class);
    }

    public function presences(){
        return $this->hasMany(AttendStudentRegister::class, 'student_id');
    }

    public function absences(){
        return $this->belongsTo(Absence::class);
    }

    public function reports(){
        return $this->belongsTo(Report::class);
    }
}
