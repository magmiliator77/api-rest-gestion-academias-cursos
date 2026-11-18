<?php

namespace App\Http\Controllers;

use App\Models\Academy;
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

    // POST /api/courses: crea un curso en una academia del usuario
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        // La academia existe (lo comprueba 'exists'), pero tiene que ser del usuario
        $academy = Academy::find($data['academy_id']);
        if ($academy->user_id != $request->user()->id) {
            return response()->json(['message' => 'Solo puedes crear cursos en tus academias'], 403);
        }

        $course = Course::create($data);

        return response()->json($course, 201);
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

    // Reglas de validación de un curso
    private function rules()
    {
        return [
            'academy_id' => 'required|integer|exists:academies,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'capacity' => 'required|integer|min:1',
        ];
    }
}
