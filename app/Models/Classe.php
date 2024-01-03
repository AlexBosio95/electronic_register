<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $table = "classes";
    protected $fillable = "name";

    public function students(){
        $this->hasMany(Student::class);
    }

    public function teachers(){
        return $this->belongsToMany(Classe::class, 'teacher_classes', 'class_id', 'teacher_id');
    }
}
