<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['name','surname','birthday','address','city'];

    public function classes(){
        return $this->belongsToMany(Classe::class, 'teacher_classes', 'teacher_id', 'class_id');
    }
}
