<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

/**
 * Class PerfilController
 *
 * Controlador encargado de mostrar y actualizar el perfil de los usuarios.
 */
class PerfilController extends Controller
{
    /**
     * Muestra el formulario de edición de perfil.
     *
     * @return \Illuminate\View\View Vista del formulario de edición de perfil
     */
    public function index()
    {
        // Retornar la vista 'perfil.index'
        return view(('perfil.index'));
    }

    /**
     * Valida y procesa la actualización de datos del perfil, incluyendo imagen.
     *
     * @param  Request  $request  Instancia de la petición HTTP con datos de perfil
     * @return \Illuminate\Http\RedirectResponse  Redirige al listado de posts del usuario
     */
    public function store(Request $request)
    {
        // Convertir el username a formato "slug" (minúsculas y guiones)
        $request->request->add([
            'username' => Str::slug($request->username)
        ]);

        // Validar campos username e imagen
        $this->validate($request, [
            'username' => ['required', 'unique:users,username,'.auth()->user()->id, 
            'min:3', 'max:20', 'not_in:editar-perfil'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp'],
        ]);

        // Procesar imagen si se envió
        if ($request->imagen) {
            // Inicializar gestor de imágenes con driver GD
            $manager = new ImageManager(new Driver());
            // Obtener el archivo de imagen
            $imagen = $request->file('imagen');

            // Generar nombre único con UUID y extensión
            $nombreImagen = Str::uuid() . '.' . $imagen->extension();

            // Leer imagen para manipulación
            $imagenServidor = $manager->read($imagen);
            // Ajustar tamaño máximo de 1000x1000 px
            $imagenServidor->cover(1000, 1000);

            // Definir ruta de guardado en carpeta 'perfiles'
            $imagenesPath = public_path('perfiles') . '/' . $nombreImagen;
            // Guardar la imagen procesada
            $imagenServidor->save($imagenesPath);
        }

       
        // Actualizar datos del usuario en la base de datos
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        // Asignar imagen nueva, o conservar la anterior si no se subió
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        // Redirigir al listado de posts de este usuario
        return redirect()->route('post.index', $usuario->username);
    }
}
