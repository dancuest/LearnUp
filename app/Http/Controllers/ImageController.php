<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPUnit\Event\Runtime\PHP;

class ImageController extends Controller
{
    /**
     * Store an image in S3 and update the database.
     * 
     * @OA\Post(
     *      path="/images",
     *      operationId="storeImage",
     *      tags={"images"},
     *      summary="Store image",
     *      description="Upload an image to S3 and update the database.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"file", "table", "row_id", "column"},
     *              @OA\Property(property="file", type="string", format="binary"),
     *              @OA\Property(property="table", type="string", example="users"),
     *              @OA\Property(property="row_id", type="integer", example=1),
     *              @OA\Property(property="column", type="string", example="profile_picture")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Image uploaded successfully"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Validation error"
     *      )
     * )
     */
    public function store(Request $request)
    {
        try {
            // Validación de la solicitud
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'table' => 'required|string',
                'row_id' => 'required|integer',
                'column' => 'required|string',
            ]);

            // Obtención de los datos de la solicitud
            $file = $request->file('file');
            $table = $request->input('table');
            $column = $request->input('column');
            $rowId = $request->input('row_id');

            // Verificación de la existencia del registro en la base de datos
            $existingRecord = DB::table($table)->where('id', $rowId)->first();
            Log::info('Existing record:', (array) $existingRecord->{$column}); // Logs the record for debugging

            if (!$existingRecord) {
                return back()->withErrors(['error' => 'Registro no encontrado en la base de datos.']);
            }

            // Eliminación de la imagen anterior si existe
            if (!empty($existingRecord->{$column})) {
                $existingFilePath = parse_url($existingRecord->{$column}, PHP_URL_PATH);
                if ($existingFilePath) {
                    $existingFilePath = ltrim($existingFilePath, '/');
                    if (Storage::disk('s3')->exists($existingFilePath)) {
                        Storage::disk('s3')->delete($existingFilePath);
                    } else {
                        Log::warning("El archivo {$existingFilePath} no existe en S3.");
                    }
                } else {
                    Log::warning("No se pudo obtener la ruta del archivo existente.");
                }
            }

            // Almacenamiento de la nueva imagen en S3
            $path = Storage::disk('s3')->put("images/{$table}/{$column}", $file);
            if (!$path) {
                return back()->withErrors(['error' => 'Error al subir la nueva imagen a S3.']);
            }

            // Obtención de la URL pública de la imagen
            $bucketUrl = config('filesystems.disks.s3.url'); // Ensure this is set in your config
            $url = $bucketUrl . '/' . $path;

            // Actualización del registro en la base de datos
            DB::table($table)->where('id', $rowId)->update([
                $column => $url,
            ]);

            return back()->with('success', 'Imagen subida y base de datos actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error en el método store: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete an image from S3 and update the database.
     * 
     * @OA\Delete(
     *      path="/images",
     *      operationId="deleteImage",
     *      tags={"images"},
     *      summary="Delete image",
     *      description="Delete an image from S3 and update the database.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"table", "row_id", "column"},
     *              @OA\Property(property="table", type="string", example="users"),
     *              @OA\Property(property="row_id", type="integer", example=1),
     *              @OA\Property(property="column", type="string", example="profile_picture")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Image deleted successfully"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Validation error"
     *      )
     * )
     */
    public function destroy(Request $request)
    {
        try {
            // Validación de la solicitud
            $request->validate([
                'table' => 'required|string',
                'row_id' => 'required|integer',
                'column' => 'required|string',
            ]);

            // Obtención de los datos de la solicitud
            $table = $request->input('table');
            $column = $request->input('column');
            $rowId = $request->input('row_id');

            // Verificación de la existencia del registro en la base de datos
            $existingRecord = DB::table($table)->where('id', $rowId)->first();
            if (!$existingRecord) {
                return back()->withErrors(['error' => 'Registro no encontrado en la base de datos.']);
            }

            // Eliminación de la imagen si existe
            if (!empty($existingRecord->{$column})) {
                $existingFilePath = parse_url($existingRecord->{$column}, PHP_URL_PATH);
                if ($existingFilePath) {
                    $existingFilePath = ltrim($existingFilePath, '/');
                    if (Storage::disk('s3')->exists($existingFilePath)) {
                        Storage::disk('s3')->delete($existingFilePath);
                    } else {
                        Log::warning("El archivo {$existingFilePath} no existe en S3.");
                    }
                } else {
                    Log::warning("No se pudo obtener la ruta del archivo existente.");
                }

                // Actualización del registro en la base de datos
                DB::table($table)->where('id', $rowId)->update([
                    $column => null,
                ]);
            } else {
                return back()->withErrors(['error' => 'No hay imagen para eliminar en este registro.']);
            }

            return back()->with('success', 'Imagen eliminada y base de datos actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error en el método destroy: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }
}
