<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstitutionUsersController extends Controller
{
    /**
     * Add a user to an institution.
     * 
     * @OA\Post(
     *      path="/institutions/users/add",
     *      operationId="addUserToInstitution",
     *      tags={"institucion"},
     *      summary="Add user to institution",
     *      description="Add a user to the specified institution.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"user_id", "institucion_id"},
     *              @OA\Property(property="user_id", type="integer", example=1),
     *              @OA\Property(property="institucion_id", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User added successfully"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="User already in institution"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized"
     *      )
     * )
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
     * Remove a user from an institution.
     * 
     * @OA\Delete(
     *      path="/institutions/users/remove",
     *      operationId="removeUserFromInstitution",
     *      tags={"institucion"},
     *      summary="Remove user from institution",
     *      description="Remove a user from the specified institution.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"user_id", "institucion_id"},
     *              @OA\Property(property="user_id", type="integer", example=1),
     *              @OA\Property(property="institucion_id", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User removed successfully"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized"
     *      )
     * )
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
     * Get all users in an institution.
     * 
     * @OA\Get(
     *      path="/institutions/{institucion_id}/users",
     *      operationId="getUsersByInstitution",
     *      tags={"institucion"},
     *      summary="Get users by institution",
     *      description="Retrieve all users in the specified institution.",
     *      @OA\Parameter(
     *          name="institucion_id",
     *          in="path",
     *          description="ID of the institution",
     *          required=true,
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="List of users",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="name", type="string", example="John Doe"),
     *                  @OA\Property(property="email", type="string", example="john@example.com")
     *              )
     *          )
     *      )
     * )
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
     * Check if a user belongs to an institution.
     * 
     * @OA\Post(
     *      path="/institutions/users/check",
     *      operationId="isUserInInstitution",
     *      tags={"institucion"},
     *      summary="Check user in institution",
     *      description="Check if a user belongs to the specified institution.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"user_id", "institucion_id"},
     *              @OA\Property(property="user_id", type="integer", example=1),
     *              @OA\Property(property="institucion_id", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User enrollment status",
     *          @OA\JsonContent(
     *              @OA\Property(property="isEnrolled", type="boolean", example=true)
     *          )
     *      )
     * )
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
     * Get all institutions a user belongs to.
     * 
     * @OA\Get(
     *      path="/users/{user_id}/institutions",
     *      operationId="getInstitutionsByUser",
     *      tags={"institucion"},
     *      summary="Get institutions by user",
     *      description="Retrieve all institutions a user belongs to.",
     *      @OA\Parameter(
     *          name="user_id",
     *          in="path",
     *          description="ID of the user",
     *          required=true,
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="List of institutions",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="nombre", type="string", example="Univalle"),
     *                  @OA\Property(property="tipo", type="string", example="publica")
     *              )
     *          )
     *      )
     * )
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
     * Get the number of students in an institution.
     * 
     * @OA\Get(
     *      path="/institutions/{institucion_id}/students/count",
     *      operationId="getNumberOfStudentsByInstitution",
     *      tags={"institucion"},
     *      summary="Get number of students in institution",
     *      description="Retrieve the number of students in the specified institution.",
     *      @OA\Parameter(
     *          name="institucion_id",
     *          in="path",
     *          description="ID of the institution",
     *          required=true,
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Number of students",
     *          @OA\JsonContent(
     *              @OA\Property(property="count", type="integer", example=150)
     *          )
     *      )
     * )
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
