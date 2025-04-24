<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class CursoInscripcionController extends Controller
{
    public function inscripcion(Request $request, Curso $curso)
    {
        $user = $request->user();

        if ($user->cursos()->where('curso_id', $curso->id)->exists()) {
            return response()->json([
                'message' => 'Ya estás inscrito en este curso'
            ], 409);
        }

        if ($curso->costo > 0) {
            $pagoExitoso = $this->validarPago($request);

            if (!$pagoExitoso) {
                return response()->json([
                    'message' => 'El pago no se realizó correctamente'
                ], 402);
            }
        }

        $curso->userEstudia()->attach($user->id);
        $curso->increment('cantidad_alumnos');
        $curso->save();

        return response()->json([
            'message' => 'Inscripción exitosa'
        ], 201);
    }

    private function validarPago(Request $request)
    {
        return true;
    }

    public function findAllStudents(Request $request, Curso $curso)
    {
        $query = $curso->userEstudia();

        if ($request->has('nombre')) {
            $query->where('name', 'like', '%' . $request->nombre . '%');
        }

        $estudiantes = $query->get();

        return response()->json($estudiantes);
    }
}
