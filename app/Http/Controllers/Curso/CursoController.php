<?php

namespace App\Http\Controllers\Curso;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Institucion;

/**
 * OA\Info
 * (
 *      title = "Api LearnUp Documentation",
 *      version = "1.0.0",
 *      description = "LearnUp project Documentation",
 *  )
 */
class CursoController extends Controller
{

    /**
     * Crear un curso 
     * 
     * @OA\Post 
     *(
     *      path = "/institution/{institution}/course",
     *      operationId = "create course",
     *      tags = {"curso"},
     *      summary = "Create new courses",
     *      description = "this endpoint allows to create a new course",
     * 
     *      @OA\RequestBody(
     *          required=true,
     *          description= "course data",
     *          @OA\JsonContent(
     *              required={"nombre", "costo", "cantidad_alumnos"},
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="nombre", type="string", example="Calculo I"),
     *              @OA\Property(property="costo", type="float", example=0.0),
     *              @OA\Property(property="cantidad_alumnos", type="integer", example=50)
     *          )
     *      ),
     *      @OA\Response (
     *          response = 201,
     *          description = "Course created successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="nombre", type="string", example="Calculo I"),
     *              @OA\Property(property="costo", type="float", example=0.0),
     *              @OA\Property(property="cantidad_alumnos", type="integer", example=50)
     *          )
     *      ),
     *      @OA\Response(
     *          response = 400,
     *          description="request failed"
     *      )
     * )
     */
    public function createCurso(Request $request, Institucion $institucion)
    {
        $validateData = $request->validate([
            'nombre' => 'required|string|max:255',
            'costo' => 'required|float',
            'cantidad_alumnos' => 'required|integer',
        ]);

        $validateData['institucion_id'] = $institucion->id;
        $curso = Curso::create($validateData);

        return back()->with([
            'flash' => [
                'type' => 'success',
                'message' => 'Curso creado exitosamente',
                'data' => $curso
            ]
        ]);
    }
}
