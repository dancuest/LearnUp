<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Curso;

class ValidarDocenteCurso
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Obtenemos el ID del curso desde la ruta o input
        $cursoId = $request->route('course_id') ?? $request->input('course_id');

        if (!$cursoId) {
            return response()->json(['message' => 'Course ID is required.'], 400);
        }

        $curso = Curso::find($cursoId);

        if (!$curso) {
            return response()->json(['message' => 'Course not found.'], 404);
        }

        if ($curso->docente_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized: You are not the owner of this course.'], 403);
        }

        return $next($request);
    }
}
