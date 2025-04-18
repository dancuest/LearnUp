<?php

namespace App\Http\Controllers\Curso;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Institucion;
use Illuminate\Support\Facades\DB;

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

    /**
     * Busqueda por filtros y paginación 
     * 
     * @OA\GET (
     *      path = "/institution/courses/",
     *      operationId = "get all courses from a Institution",
     *      tags = {"curso"},
     *      summary = "Get all courses from a Institution",
     *      @OA\ Response (
     *          response = 200,
     *          description = "List of courses",
     *          @OA\JsonContent (
     *              type = "Object",
     *              @OA\Property(property= "id", type= "integer", example=1),
     *              @OA\Property(property = "nombre", type="string", example= "Desarrollo de software"),
     *              @OA\Property(property = "costo", type="float", example= "356000"),
     *              @OA\Property(property = "cantidad_alumnos", type="integer", example= "150"),
     *          )
     *      ),
     *      @OA\Response (
     *          response = 404,
     *          description = "there are not courses"
     *      )
     * )
     */
    public function findAllCursos(Request $request)
    {
        $institucionId = $request->route('institution_id') ?? $request->input('institucion_id');

        if (!$institucionId) {
            return back()->withErrors('Debe proporcionar un ID de institución.');
        }

        $query = Curso::where('institution_id', $institucionId);

        if ($request->has('nombre')) {
            $query->where('nombre', 'like', '%' . $request->input('nombre') . '%');
        }

        if ($request->has('limit')) {
            $query->skip($request->input('offset', 0))
                ->take($request->input('limit'));
        }

        return back()->with([
            'flash' => [
                'data' => $query->get()
            ]
        ]);
    }

    /**
     * Obtener curso por el id
     * 
     * @OA\Get (
     *      path="/institution/course/{id}",
     *      operationId = "get one course by Id",
     *      tags = {"curso"},
     *      summary = "Get one Course by Id",
     *      @OA\Parameter(
     *          name = "id",
     *          in = "path",
     *          description = "Id of course",
     *          required = true,
     *          @OA\Schema(type = "integer", example = 1)
     *      ),
     *      @OA\Response (
     *          response = 200,
     *          description = "Course data",
     *          @OA\JsonContent (
     *              type = "object", 
     *              @OA\Property(property= "id", type= "integer", example=1),
     *              @OA\Property(property = "nombre", type="string", example= "Desarrollo de software"),
     *              @OA\Property(property = "costo", type="float", example= "356000"),
     *              @OA\Property(property = "cantidad_alumnos", type="integer", example= "150"),
     *          )
     *      ),
     *      @OA\Response (
     *          response = 404,
     *          description = "Course not found"
     *      )
     * )
     */
    public function findById($id)
    {
        return back()->with([
            'flash' => [
                'data' => Curso::findOrFail($id)
            ]
        ]);
    }

    /**
     * Metodo para actualizar un curso
     * 
     * @OA\PUT(
     *      path= "/institution/course/{id}",
     *      operationId = "update course",
     *      tags = {"curso"},
     *      summary = "Update Course",
     *      @OA\RequestBody(
     *          description = "Course data",
     *          @OA\JsonContent(
     *              @OA\Property(property= "id", type= "integer", example=1),
     *              @OA\Property(property = "nombre", type="string", example= "Sistemas de Información"),
     *              @OA\Property(property = "costo", type="float", example= "35000"),
     *              @OA\Property(property = "cantidad_alumnos", type="integer", example= "150"),
     *          )
     *      ),
     *      @OA\Response (
     *          response = 201,
     *          description = "Course updated successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property= "id", type= "integer", example=1),
     *              @OA\Property(property = "nombre", type="string", example= "Ciberseguridad"),
     *              @OA\Property(property = "costo", type="float", example= "380000"),
     *              @OA\Property(property = "cantidad_alumnos", type="integer", example= "120"),
     *          )
     *      ),
     *      @OA\Response(
     *          response = 400,
     *          description = "request failed"
     *      )
     * )
     */
    public function updateCourse(Request $request, $id)
    {
        $curso = Curso::findOrFail($id);

        $curso->update($request->all());

        return back()->with([
            'flash' => [
                'type' => 'success',
                'message' => 'Course update successfully',
                'data' => $curso
            ]
        ]);
    }

    /**
     * Metodo para eliminar un curso 
     * 
     * @OA\Delete (
     *      path = "/institution/course/{id}",
     *      operationId = "delete a course",
     *      tags = {"curso"},
     *      summary = "Delete a course by Id",
     *      @OA\Parameter(
     *          name = "id",
     *          in = "path",
     *          description = "Id of course",
     *          required = true,
     *          @OA\Schema(type = "integer", example = 1)
     *      ),
     *      @OA\Response(
     *          response = 200,
     *          description = "Course deleted",
     *          @OA\JsonContent(
     *              type = "object",
     *              @OA\Property(property= "id", type= "integer", example=1),
     *              @OA\Property(property = "nombre", type="string", example= "Ciberseguridad"),
     *              @OA\Property(property = "costo", type="float", example= "380000"),
     *              @OA\Property(property = "cantidad_alumnos", type="integer", example= "120"),
     *          )
     *      ),
     *      @OA\Response(
     *          response = 404,
     *          description = "Course not deleted"
     *      )
     * )
     */
    public function deleteCurso(Request $request, $id)
    {
        $curso = Curso::findOrFail($id);

        $curso->delete();

        return back()->with([
            'flash' => [
                'type' => 'success',
                'message' => 'Curso eliminado',
                'data' => ['deleted_id' => $id]
            ]
        ]);
    }
}
