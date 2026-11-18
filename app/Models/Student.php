<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'surname', 'email', 'phone', 'date_of_birth'];

    // Los cursos en los que está matriculado el estudiante
    public function courses()
    {
        return $this->belongsToMany(Course::class)
            ->withPivot('enrolled_at')
            ->withTimestamps();
    }
}
