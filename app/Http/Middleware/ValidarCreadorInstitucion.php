<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Institucion;

class ValidarCreadorInstitucion
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Obtenemos el ID de la institución desde la ruta o input
        $institutionId = $request->route('institution_id') ?? $request->input('institucion_id');

        if (!$institutionId) {
            return response()->json(['message' => 'Institution ID is required.'], 400);
        }

        $institution = Institucion::find($institutionId);

        if (!$institution) {
            return response()->json(['message' => 'Institution not found.'], 404);
        }

        if ($institution->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized: You are not the owner of this institution.'], 403);
        }

        return $next($request);
    }
}
