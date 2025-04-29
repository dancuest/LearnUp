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
        // Verificar si el usuario ya está en la institución
        $exists = DB::table('accede_institucion_user')
            ->where('user_id', $request->user_id)
            ->where('institucion_id', $request->institucion_id)
            ->exists();
        if ($exists) {
            return back()->with([
                'flash' => [
                    'type' => 'error',
                    'message' => 'El usuario ya está en la institución.',
                    'data' => null
                ]
            ])->setStatusCode(400);
        }
        $data = DB::table('accede_institucion_user')->insert([
            'user_id' => $request->user_id,
            'institucion_id' => $request->institucion_id,
            'created_at' => now(),
            'updated_at' => now(),
            'rol' => 'estudiante',
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


    /**
     * Método para obtener todos los usuarios de una institución
     */
    public function getUsersByInstitution(Request $request)
    {
        $request->validate([
            'institucion_id' => 'required|integer|exists:instituciones,id',
        ]);


        $users = DB::table('users')
            ->join('accede_institucion_user', 'users.id', '=', 'accede_institucion_user.user_id')
            ->where('accede_institucion_user.institucion_id', $request->institucion_id)
            ->select('users.*')
            ->get();

        return response()->json($users);
    }

    /**
     * Método para saber si un usuario pertenece a una institución
     */
    public function isUserInInstitution(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'institucion_id' => 'required|integer|exists:instituciones,id',
        ]);

        $exists = DB::table('accede_institucion_user')
            ->where('user_id', $request->input('user_id'))
            ->where('institucion_id', $request->input('institucion_id'))
            ->exists();

        return response()->json(['isEnrolled' => $exists]); // Ensure the response uses 'isEnrolled'
    }

    /**
     * Método para obtener todas las instituciones a las que pertenece un usuario
     */
    public function getInstitutionsByUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $isMyProfile = $request->user()->id === $request->user_id;
        if (!$isMyProfile) {
            return back()->with([
                'flash' => [
                    'type' => 'error',
                    'message' => 'No autorizado',
                    'data' => null
                ]
            ])->setStatusCode(403);
        }

        $institutions = DB::table('instituciones')
            ->join('accede_institucion_user', 'instituciones.id', '=', 'accede_institucion_user.institucion_id')
            ->where('accede_institucion_user.user_id', $request->user_id)
            ->select('instituciones.*')
            ->get();

        return response()->json($institutions);
    }

    /**
     * Método para obtener todos los usuarios de una institución
     */
    public function getNumberOfStudentsByInstitution(Request $request, $institucion_id)
    {
        // Validate the $institucion_id parameter
        $request->merge(['institucion_id' => $institucion_id]);
        $request->validate([
            'institucion_id' => 'required|integer|exists:instituciones,id',
        ]);

        $cantityStudents = DB::table('users')
            ->join('accede_institucion_user', 'users.id', '=', 'accede_institucion_user.user_id')
            ->where('accede_institucion_user.institucion_id', $institucion_id)
            ->where('accede_institucion_user.rol', 'estudiante')
            ->count();

        return response()->json($cantityStudents);
    }
}
