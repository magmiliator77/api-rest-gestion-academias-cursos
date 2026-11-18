<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Academy extends Model
{
    protected $fillable = ['user_id', 'name', 'description', 'address', 'phone', 'email'];

    // El usuario que ha creado la academia
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Los cursos que imparte la academia
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
