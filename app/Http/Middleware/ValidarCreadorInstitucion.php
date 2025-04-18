<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Curso;

class ValidarAutorizacionCurso
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $userId = $user->id;

        $cursoId = $request->route('cursos') ?? $request->input('curso_id');

        if (!$cursoId) {
            return back()->with([
                'flash' => [
                    'type' => 'error',
                    'message' => 'Curso no especificado',
                    'data' => null
                ]
            ])->setStatusCode(400);
        }

        $curso = Curso::with('institucion')->find($cursoId);

        if (!$curso || !$curso->institucion) {
            return back()->with([
                'flash' => [
                    'type' => 'error',
                    'message' => 'Curso o institución no encontrada',
                    'data' => null
                ]
            ])->setStatusCode(404);
        }

        if ($curso->institucion->user_id !== $userId) {
            return back()->with([
                'flash' => [
                    'type' => 'error',
                    'message' => 'No autorizado',
                    'data' => null
                ]
            ])->setStatusCode(403);
        }

        return $next($request);
    }
}
