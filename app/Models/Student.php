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

    public function studentregister(){
        return $this->belongsTo(StudentRegister::class);
    }

    public function reports(){
        return $this->belongsTo(Report::class);
    }
}
