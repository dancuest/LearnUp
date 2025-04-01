<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstitutionUsersController extends Controller
{
    /**
     * Agregar un usuario a una institución.
     */
    public function addUserToInstitution(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'institucion_id' => 'required|integer|exists:instituciones,id',
        ]);

        $isOwner = DB::table('instituciones')
            ->where('id', $request->institucion_id)
            ->where('user_id', $request->user()->id)
            ->exists();

        if ($request->user_id !== $request->user()->id && !$isOwner) {
            return response()->json(['message' => 'No tienes permiso para realizar esta acción.'], 403);
        }

        DB::table('accede_institucion_user')->insert([
            'user_id' => $request->user_id,
            'institucion_id' => $request->institucion_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Usuario agregado a la institución exitosamente.']);
    }

    /**
     * Eliminar un usuario de una institución.
     */
    public function removeUserFromInstitution(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'institucion_id' => 'required|integer|exists:instituciones,id',
        ]);

        $isOwner = DB::table('instituciones')
            ->where('id', $request->institucion_id)
            ->where('user_id', $request->user()->id)
            ->exists();


        if ($request->user_id !== $request->user()->id && !$isOwner) {
            return response()->json(['message' => 'No tienes permiso para realizar esta acción.'], 403);
        }

        DB::table('accede_institucion_user')
            ->where('user_id', $request->user_id)
            ->where('institucion_id', $request->institucion_id)
            ->delete();

        return response()->json(['message' => 'Usuario eliminado de la institución exitosamente.']);
    }
}
