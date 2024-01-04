<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRegister extends Model
{
    use HasFactory;

    protected $table = "student_register";
    protected $fillable = "note";

    function students(){
        $this->hasMany(Student::class);
    }

    public function teachers(){
        $this->hasMany(Teacher::class);
    }

    public function subjects(){
        $this->hasMany(Subject::class);
    }

    public function events(){
        $this->hasMany(Event::class);
    }
}
