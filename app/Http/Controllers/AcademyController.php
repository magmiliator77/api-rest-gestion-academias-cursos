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
