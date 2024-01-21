<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolCalendar extends Model
{
    use HasFactory;

    protected $table = 'school_calendar';
    protected $fillable = ['day_of_week', 'time_start', 'time_end', 'subject_id', 'teacher_id', 'class_id'];

    public function subjects()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'class_id');
    }
}
