<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institucion; // Asegúrate de tener un modelo llamado Institucion

/**
 * OA\Info
 * (
 *      title = "Api LearnUp Documentation",
 *      version = "1.0.0",
 *      description = "LearnUp project Documentation",
 *  )
 */

class InstitutionController extends Controller
{

    /**
     * Crear una institución 
     * 
     * @OA\Post
     *  (
     *     path = "/institution/create",
     *     operationId = "create Institution",
     *     tags = {"institucion"},
     *     summary = "Create a new institutions.",
     *     description = "this endpoint allows to register a new institution in the database",
     *     
     *      @OA\RequestBody(
     *          required=true,
     *          description = "Institution data.",
     *          @OA\JsonContent(
     *              required={"nombre", "tipo", "capacidad"},
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="nombre", type="string", example="Univalle"),
     *              @OA\Property(property="tipo", type="string", example="publica"),
     *              @OA\Property(property="Capacidad", type="integer", example=1500),
     *          )
     *      ),
     *      @OA\Response (
     *          response = 201,
     *          description = "Institution created successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="nombre", type="string", example="Univalle"),
     *              @OA\Property(property="tipo", type="string", example="publica"),
     *              @OA\Property(property="Capacidad", type="integer", example=1500),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="request failed"
     *      )
     *  )
     */
    public function create(Request $request)
    {
        $user = $request->user();

        if (!$user || !$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|in:publico,privado',
            'capacidad' => 'required|integer|min:1',
        ]);

        $validatedData['user_id'] = $user->id;

        $institucion = Institucion::create($validatedData);

        return response()->json(['message' => 'Institucion created successfully', 'data' => $institucion], 201);
    }


    /**
     * Obtener institucion por el id 
     * 
     * @OA\Get (
     *      path="/institution/{id}",
     *      operationId = "get Institution By Id",
     *      tags = {"institucion"},
     *      summary = "Get an Institution by Id",
     *      @OA\Parameter(
     *          name = "id",
     *          in = "path",
     *          description = "ID of institution",
     *          required = true,
     *          @OA\Schema(type = "integer", example = 1)
     *      ),
     *      @OA\Response(
     *          response = 200,
     *          description = "Institution data",
     *          @OA\JsonContent (
     *              type = "object",
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="nombre", type="string", example="Univalle"),
     *              @OA\Property(property="tipo", type="string", example="publica"),                 
     *              @OA\Property(property="Capacidad", type="integer", example=1500)
     *          )
     *      ),
     *      @OA\Response(
     *          response = 404,
     *          description = "Institution not found"
     *      )
     * )
     */
    
    public function findById($id)
    {
        $institucion = Institucion::find($id);

        if (!$institucion) {
            return response()->json(['message' => 'Institucion not found'], 404);
        }

        return response()->json($institucion, 200);
    }


    /**
     * Busqueda por filtros y paginación 
     * 
     * @OA\Get (
     *      path = "/institution/",
     *      operationId = "get Institutions",
     *      tags = {"institucion"},
     *      summary = "Get an institutions",
     *      @OA\ Response (
     *          response = 200,
     *          description = "List of institutions",
     *          @OA\JsonContent (
     *              type = "object",
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="nombre", type="string", example="Univalle"),
     *              @OA\Property(property="tipo", type="string", example="publica"),                 
     *              @OA\Property(property="Capacidad", type="integer", example=1500)
     *          )
     *      ),
     *      @OA\Response(
     *          response = 404,
     *          description = "There are not institutions"
     *      )
     * )
     */
    public function findAll(Request $request)
    {
        $query = Institucion::query();

        // Filtrar por título si se proporciona
        if ($request->has('titulo')) {
            $query->where('titulo', 'like', '%' . $request->input('titulo') . '%');
        }

        // Aplicar paginación si se proporcionan limit y offset
        if ($request->has('limit')) {
            $limit = (int) $request->input('limit');
            $offset = (int) $request->input('offset', 0);
            $query->skip($offset)->take($limit);
        }

        $instituciones = $query->get();

        return response()->json($instituciones, 200);
    }

    /**
     * Método para eliminar una institución
     * 
     * @OA\Delete (
     *      path = "/institution/delete",
     *      operationId = "delete an institution",
     *      tags = {"institucion"},
     *      summary = "Delete an Institution By Id",
     *      @OA\Parameter(
     *          name = "id",
     *          in = "path",
     *          description = "Id of institution",
     *          required = true,
     *          @OA\Schema(type = "integer", example = 1)
     *      ),
     *      @OA\Response(
     *          response = 200,
     *          description = "Institution deleted",
     *          @OA\JsonContent(
     *              type = "object",
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="nombre", type="string", example="Univalle"),
     *              @OA\Property(property="tipo", type="string", example="publica"),                 
     *              @OA\Property(property="Capacidad", type="integer", example=1500)
     *          )
     *      ),
     *      @OA\Response(
     *          response = 404,
     *          description = "Institution not deleted"
     *      )
     * )
     *  
     * */ 
    
    public function delete(Request $request, $id)
    {
        $institucion = Institucion::find($id);

        if (!$institucion) {
            return response()->json(['message' => 'Institucion not found'], 404);
        }

        if ($request->user()->id !== $institucion->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $institucion->delete();

        return response()->json(['message' => 'Institucion deleted successfully'], 200);
    }

    /**
     * Método para actualizar una institución
     * @OA\PUT (
     *      path = "/institution/update",
     *      operationId = "update institution",
     *      tags = {"institucion"},
     *      summary = "Update an institution",
     *      @OA\RequestBody(
     *          description = "Institution data",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="nombre", type="string", example="Univalle"),
     *              @OA\Property(property="tipo", type="string", example="publica"),
     *              @OA\Property(property="Capacidad", type="integer", example=1500),
     *          )
     *      ),
     *      @OA\Response (
     *          response = 201,
     *          description = "Institution updated successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="nombre", type="string", example="Univalle"),
     *              @OA\Property(property="tipo", type="string", example="publica"),
     *              @OA\Property(property="Capacidad", type="integer", example=1500),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="request failed"
     *      )
     * )
     * 
     *  */ 
    public function update(Request $request, $id)
    {
        $institucion = Institucion::find($id);

        if (!$institucion) {
            return response()->json(['message' => 'Institucion not found'], 404);
        }

        if ($request->user()->id !== $institucion->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $institucion->update($request->all());

        return response()->json(['message' => 'Institucion updated successfully', 'data' => $institucion], 200);
    }
}
