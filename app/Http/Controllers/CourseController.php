<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // GET /api/courses: cualquier usuario con token puede ver todos los cursos
    public function index()
    {
        $courses = Course::all();

        return response()->json($courses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    // GET /api/courses/{id}: muestra un curso (404 si no existe)
    public function show(string $id)
    {
        $course = Course::find($id);

        if (! $course) {
            return response()->json(['message' => 'Curso no encontrado'], 404);
        }

        return response()->json($course);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
