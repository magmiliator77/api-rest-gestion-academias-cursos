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

    // PUT /api/courses/{id}: modifica el curso, solo si es de una academia del usuario
    public function update(Request $request, string $id)
    {
        $course = Course::find($id);

        if (! $course) {
            return response()->json(['message' => 'Curso no encontrado'], 404);
        }

        // El dueño del curso es el dueño de su academia
        if ($course->academy->user_id != $request->user()->id) {
            return response()->json(['message' => 'No puedes modificar un curso de una academia que no es tuya'], 403);
        }

        $data = $request->validate($this->rules());

        // Si se cambia el curso de academia, la nueva también tiene que ser suya
        $newAcademy = Academy::find($data['academy_id']);
        if ($newAcademy->user_id != $request->user()->id) {
            return response()->json(['message' => 'Solo puedes pasar el curso a una de tus academias'], 403);
        }

        $course->update($data);

        return response()->json($course);
    }

    // DELETE /api/courses/{id}: borra el curso, solo si es de una academia del usuario
    public function destroy(Request $request, string $id)
    {
        $course = Course::find($id);

        if (! $course) {
            return response()->json(['message' => 'Curso no encontrado'], 404);
        }

        if ($course->academy->user_id != $request->user()->id) {
            return response()->json(['message' => 'No puedes borrar un curso de una academia que no es tuya'], 403);
        }

        $course->delete();

        return response()->json(['message' => 'Curso borrado']);
    }

    // GET /api/course/{id}/students: los estudiantes matriculados en un curso (con token)
    public function students(string $id)
    {
        $course = Course::find($id);

        if (! $course) {
            return response()->json(['message' => 'Curso no encontrado'], 404);
        }

        // $course->students usa la relación belongsToMany (N:N) a través de la tabla course_student.
        // Cada estudiante sale con "pivot", que trae la fecha de matrícula (enrolled_at)
        return response()->json($course->students);
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
