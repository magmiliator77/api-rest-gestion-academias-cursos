<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['academy_id', 'name', 'description', 'start_date', 'end_date', 'capacity'];

    // La academia que imparte el curso
    public function academy()
    {
        return $this->belongsTo(Academy::class);
    }

    // Los estudiantes matriculados, con la fecha de matrícula de la tabla pivote
    public function students()
    {
        return $this->belongsToMany(Student::class)
            ->withPivot('enrolled_at')
            ->withTimestamps();
    }
}
