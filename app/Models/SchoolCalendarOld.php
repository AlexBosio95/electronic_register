<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolCalendarOld extends Model
{
    use HasFactory;

    protected $table = 'school_calendar_old';
    protected $fillable = ['day_of_week', 'time_start', 'time_end', 'subject_id', 'teacher_id', 'class_id', 'date_time_start', 'date_time_end', 'note'];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function teacher()
    {
        return $this->hasMany(Teacher::class);
    }

    public function classe()
    {
        return $this->hasMany(Classe::class, 'class_id');
    }
}
