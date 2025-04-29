<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
 
 
/**
 * Class ImagenController
 *
 * Controlador encargado de manejar la subida y procesamiento
 * de imágenes enviadas desde el cliente.
 */
class ImagenController extends Controller
{
    /**
     * Procesa y almacena una imagen recibida en la solicitud.
     *
     * @param  Request  $request  Instancia de la petición HTTP con el archivo de imagen
     * @return \Illuminate\Http\JsonResponse  Respuesta JSON con el nombre de la imagen guardada
     */
    public function store(Request $request)
    {
        // Crear un gestor de imágenes usando el driver GD
        $manager = new ImageManager(new Driver());

        // Obtener el archivo de imagen desde la petición
        $imagen = $request->file('file');

        // Generar un nombre único para la imagen usando un UUID
        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        // Leer la imagen al servidor para su manipulación
        $imagenServidor = $manager->read($imagen);

        // Ajustar la imagen para que tenga un tamaño máximo de 1000x1000 píxeles
        $imagenServidor->cover(1000, 1000);
       
        // Definir la ruta donde se guardará la imagen en el sistema de archivos público
        $imagenesPath = public_path('uploads') . '/' . $nombreImagen;

        // Guardar la imagen procesada en disco
        $imagenServidor->save($imagenesPath);

        // Devolver el nombre de la imagen en formato JSON para que el cliente lo utilice
        return response()->json(['imagen' => $nombreImagen]);
    }
}
