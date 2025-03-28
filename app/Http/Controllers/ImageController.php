<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    /**
     * Almacena una imagen en S3 y actualiza la base de datos.
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
            $path = Storage::disk('s3')->put("images/{$table}/{$column}", $file, 'public');
            if (!$path) {
                return back()->withErrors(['error' => 'Error al subir la nueva imagen a S3.']);
            }

            // Obtención de la URL pública de la imagen
            $url = Storage::disk('s3')->url($path);

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
     * Elimina una imagen de S3 y actualiza la base de datos.
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
