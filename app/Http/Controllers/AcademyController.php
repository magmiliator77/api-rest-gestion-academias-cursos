<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use Illuminate\Http\Request;

class AcademyController extends Controller
{
    // GET /api/academies: cualquier usuario con token puede ver todas las academias
    public function index()
    {
        $academies = Academy::all();

        return response()->json($academies);
    }

    // POST /api/academies: crea una academia del usuario que hace la petición
    public function store(Request $request)
    {
        // Si algo no es válido, Laravel devuelve un JSON con los errores y el código 422
        $data = $request->validate($this->rules());

        // El dueño es siempre el usuario del token, no se recibe en el JSON
        $data['user_id'] = $request->user()->id;

        $academy = Academy::create($data);

        // 201 Created porque se acaba de crear un recurso nuevo
        return response()->json($academy, 201);
    }

    // GET /api/academies/{id}: muestra una academia (404 si no existe)
    public function show(string $id)
    {
        $academy = Academy::find($id);

        // 404 Not Found si no hay ningún registro con ese id
        if (! $academy) {
            return response()->json(['message' => 'Academia no encontrada'], 404);
        }

        return response()->json($academy);
    }

    // PUT /api/academies/{id}: modifica la academia, solo si es del usuario
    public function update(Request $request, string $id)
    {
        $academy = Academy::find($id);

        if (! $academy) {
            return response()->json(['message' => 'Academia no encontrada'], 404);
        }

        // 403 Forbidden: el usuario tiene token pero la academia no es suya
        if ($academy->user_id != $request->user()->id) {
            return response()->json(['message' => 'No puedes modificar una academia que no es tuya'], 403);
        }

        $data = $request->validate($this->rules());
        $academy->update($data);

        return response()->json($academy);
    }

    // DELETE /api/academies/{id}: borra la academia, solo si es del usuario
    public function destroy(Request $request, string $id)
    {
        $academy = Academy::find($id);

        if (! $academy) {
            return response()->json(['message' => 'Academia no encontrada'], 404);
        }

        if ($academy->user_id != $request->user()->id) {
            return response()->json(['message' => 'No puedes borrar una academia que no es tuya'], 403);
        }

        // Al borrarla se borran también sus cursos (onDelete cascade en la migración)
        $academy->delete();

        return response()->json(['message' => 'Academia borrada']);
    }

    // Reglas de validación de una academia
    private function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ];
    }
}
