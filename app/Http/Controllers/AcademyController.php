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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
}
