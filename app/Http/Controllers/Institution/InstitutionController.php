<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institucion; // Asegúrate de tener un modelo llamado Institucion

class InstitutionController extends Controller
{

    /**
     * Create a new Institucion.
     *
     * This method validates the incoming request data, creates a new Institucion
     * record in the database, and returns a JSON response with the created data.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request containing
     *                                          the data for the new Institucion.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing a success message
     *                                        and the created Institucion data.
     *
     * @throws \Illuminate\Validation\ValidationException If the validation of the request
     *                                                    data fails.
     */
    public function create(Request $request)
    {
        $user = $request->user();

        if (!$user || !$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|in:publico,privado',
            'capacidad' => 'nullable|integer',
            'imagen_perfil' => 'nullable|string',
        ]);

        // Asignar el user_id del usuario autenticado
        $validatedData['user_id'] = $user->id;

        $institucion = Institucion::create($validatedData);

        return response()->json(['message' => 'Institucion created successfully', 'data' => $institucion], 201);
    }
    // Método para buscar por ID
    public function findById($id)
    {
        $institucion = Institucion::find($id);

        if (!$institucion) {
            return response()->json(['message' => 'Institucion not found'], 404);
        }

        return response()->json($institucion, 200);
    }

    // Método para buscar todos con filtros y paginación
    public function findAll(Request $request)
    {
        $query = Institucion::query();

        // Filtrar por título si se proporciona
        if ($request->has('titulo')) {
            $query->where('titulo', 'like', '%' . $request->input('titulo') . '%');
        }

        // Aplicar paginación si se proporcionan limit y offset
        if ($request->has('limit')) {
            $limit = (int) $request->input('limit');
            $offset = (int) $request->input('offset', 0);
            $query->skip($offset)->take($limit);
        }

        $instituciones = $query->get();

        return response()->json($instituciones, 200);
    }

    // Método para eliminar una institución
    public function delete(Request $request, $id)
    {
        $institucion = Institucion::find($id);

        if (!$institucion) {
            return response()->json(['message' => 'Institucion not found'], 404);
        }

        if ($request->user()->id !== $institucion->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $institucion->delete();

        return response()->json(['message' => 'Institucion deleted successfully'], 200);
    }

    // Método para actualizar una institución
    public function update(Request $request, $id)
    {
        $institucion = Institucion::find($id);

        if (!$institucion) {
            return response()->json(['message' => 'Institucion not found'], 404);
        }

        if ($request->user()->id !== $institucion->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $institucion->update($request->all());

        return response()->json(['message' => 'Institucion updated successfully', 'data' => $institucion], 200);
    }
}
