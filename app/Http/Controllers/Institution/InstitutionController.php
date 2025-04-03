<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institucion;

class InstitutionController extends Controller
{
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

        $validatedData['user_id'] = $user->id;
        $institucion = Institucion::create($validatedData);

        return back()->with([
            'flash' => [
                'type' => 'success',
                'message' => 'Institución creada exitosamente',
                'data' => $institucion // <<-- Todo el objeto aquí
            ]
        ]);
    }

    public function findById($id)
    {
        return back()->with([
            'flash' => [
                'data' => Institucion::findOrFail($id) // <<-- Datos aquí
            ]
        ]);
    }

    public function findAll(Request $request)
    {
        $query = Institucion::query();

        if ($request->has('titulo')) {
            $query->where('titulo', 'like', '%' . $request->input('titulo') . '%');
        }

        if ($request->has('limit')) {
            $query->skip($request->input('offset', 0))
                ->take($request->input('limit'));
        }

        return back()->with([
            'flash' => [
                'data' => $query->get() // <<-- Lista completa aquí
            ]
        ]);
    }

    public function delete(Request $request, $id)
    {
        $institucion = Institucion::findOrFail($id);

        if ($request->user()->id !== $institucion->user_id) {
            return back()->with([
                'flash' => [
                    'type' => 'error',
                    'message' => 'No autorizado',
                    'data' => null // <<-- Data explícita null
                ]
            ])->setStatusCode(403);
        }

        $institucion->delete();

        return back()->with([
            'flash' => [
                'type' => 'success',
                'message' => 'Institución eliminada',
                'data' => ['deleted_id' => $id] // <<-- Datos adicionales
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $institucion = Institucion::findOrFail($id);

        if ($request->user()->id !== $institucion->user_id) {
            return back()->with([
                'flash' => [
                    'type' => 'error',
                    'message' => 'No autorizado',
                    'data' => null
                ]
            ])->setStatusCode(403);
        }

        $institucion->update($request->all());

        return back()->with([
            'flash' => [
                'type' => 'success',
                'message' => 'Institución actualizada',
                'data' => $institucion // <<-- Datos actualizados
            ]
        ]);
    }
}
