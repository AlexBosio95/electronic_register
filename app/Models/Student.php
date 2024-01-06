<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name','surname','birthday','address','city'];

    public function class(){
        $this->belongsTo(Classe::class);
    }

    public function studentregister(){
        $this->belongsTo(StudentRegister::class);
    }

    public function reports(){
        $this->belongsTo(Report::class);
    }
}
