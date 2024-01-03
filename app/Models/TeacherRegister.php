<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherRegister extends Model
{
    use HasFactory;

    protected $table = "teacher_register";
    protected $fillable = "note";
}
