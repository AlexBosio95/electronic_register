<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = "report";
    protected $fillable = ['student_id', 'subject_id', 'outcome', 'period'];

    public function students(){
        $this->hasMany(Student::class);
    }

    public function subjects(){
        $this->hasMany(Subject::class);
    }
}
