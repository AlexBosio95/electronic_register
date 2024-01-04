<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherRegister extends Model
{
    use HasFactory;

    protected $table = "teacher_register";
    protected $fillable = "note";

    public function teachers(){
        $this->hasMany(Teacher::class);
    }

    public function subjects(){
        $this->hasMany(Subject::class);
    }

    public function classes(){
        $this->hasMany(Subject::class);
    }

}
