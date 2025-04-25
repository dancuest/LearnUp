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
            return back()->with([
                'flash' => [
                    'type' => 'error',
                    'message' => 'No autorizado',
                    'data' => null
                ]
            ])->setStatusCode(403);
        }

        $data = DB::table('accede_institucion_user')->insert([
            'user_id' => $request->user_id,
            'institucion_id' => $request->institucion_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with([
            'flash' => [
                'type' => 'success',
                'message' => 'Usuario agregado a la institución exitosamente.',
                'data' => $data
            ]
        ]);
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
            return back()->with([
                'flash' => [
                    'type' => 'error',
                    'message' => 'No autorizado',
                    'data' => null
                ]
            ])->setStatusCode(403);
        }

        $data = DB::table('accede_institucion_user')
            ->where('user_id', $request->user_id)
            ->where('institucion_id', $request->institucion_id)
            ->delete();

        return back()->with([
            'flash' => [
                'type' => 'success',
                'message' => 'Usuario eliminado de la institución exitosamente.',
                'data' => $data
            ]
        ]);
    }
}
