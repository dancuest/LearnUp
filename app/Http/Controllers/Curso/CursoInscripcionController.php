<?php

namespace App\Http\Controllers\Curso;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curso;

class CursoInscripcionController extends Controller
{
    /**
     * Inscribe a user in a course.
     * 
     * @OA\Post(
     *      path="/courses/{curso}/inscripcion",
     *      operationId="inscribeUserInCourse",
     *      tags={"curso"},
     *      summary="Inscribe user in a course",
     *      description="Inscribe the authenticated user in the specified course.",
     *      @OA\Parameter(
     *          name="curso",
     *          in="path",
     *          description="ID of the course",
     *          required=true,
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Inscription successful",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Inscripción exitosa")
     *          )
     *      ),
     *      @OA\Response(
     *          response=409,
     *          description="User already enrolled in the course"
     *      ),
     *      @OA\Response(
     *          response=402,
     *          description="Payment required"
     *      )
     * )
     */
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

    /**
     * Get all students enrolled in a course.
     * 
     * @OA\Get(
     *      path="/courses/{curso}/students",
     *      operationId="getAllStudentsInCourse",
     *      tags={"curso"},
     *      summary="Get all students in a course",
     *      description="Retrieve a list of all students enrolled in the specified course.",
     *      @OA\Parameter(
     *          name="curso",
     *          in="path",
     *          description="ID of the course",
     *          required=true,
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Parameter(
     *          name="nombre",
     *          in="query",
     *          description="Filter students by name",
     *          required=false,
     *          @OA\Schema(type="string", example="John")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="List of students",
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
