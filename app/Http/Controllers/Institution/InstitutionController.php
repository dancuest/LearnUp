<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institucion;

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
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|in:publico,privado',
            'capacidad' => 'nullable|integer',
            'imagen_perfil' => 'nullable|string',
        ]);

        $validatedData['user_id'] = $user->id;
        $institucion = Institucion::create($validatedData);

        return back()->with([
            'flash' => [
                'type' => 'success',
                'message' => 'Institución creada exitosamente',
                'data' => $institucion
            ]
        ]);
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
        return back()->with([
            'flash' => [
                'type' => 'success',
                'message' => 'Institución encontrada',
                'data' => Institucion::findOrFail($id) // <<-- Datos aquí
            ]
        ]);
    }

    /**
     * Busqueda por filtros y paginación 
     * 
     * @OA\Get (
     *      path = "/institution/",
     *      operationId = "get Institutions",
     *      tags = {"institucion"},
     *      summary = "Get institutions",
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
    public function findAll(Request $request) //modificaciones para busqueda y get
    {
        $query = Institucion::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->input('nombre') . '%');
        }

        if ($request->has('limit')) {
            $query->skip($request->input('offset', 0) * $request->input('limit'))
                ->take($request->input('limit'));
        }

        return back()->with([
            'flash' => [
                'type' => 'success',
                'message' => 'Instituciones encontradas',
                'data' => $query->get()
            ]
        ]);
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
        $institucion = Institucion::findOrFail($id);

        if ($request->user()->id !== $institucion->user_id) {
            return back()->with([
                'flash' => [
                    'type' => 'error',
                    'message' => 'No autorizado',
                    'data' => null // <<-- Data explícita null
                ]
            ])->setStatusCode(403);
        }

        $institucion->delete();

        return back()->with([
            'flash' => [
                'type' => 'success',
                'message' => 'Institución eliminada',
                'data' => ['deleted_id' => $id] // <<-- Datos adicionales
            ]
        ]);
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
        $institucion = Institucion::findOrFail($id);

        if ($request->user()->id !== $institucion->user_id) {
            return back()->with([
                'flash' => [
                    'type' => 'error',
                    'message' => 'No autorizado',
                    'data' => null
                ]
            ])->setStatusCode(403);
        }

        $institucion->update($request->all());

        return back()->with([
            'flash' => [
                'type' => 'success',
                'message' => 'Institución actualizada',
                'data' => $institucion
            ]
        ]);
    }
}
