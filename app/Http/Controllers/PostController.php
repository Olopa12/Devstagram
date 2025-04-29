<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/**
 * Class PostController
 *
 * Controlador responsable de manejar las operaciones CRUD de publicaciones:
 * listado, creación, visualización y eliminación de posts.
 */
class PostController extends Controller
{
    /**
     * Muestra el dashboard con las publicaciones de un usuario.
     *
     * @param  User  $user  Usuario cuyas publicaciones se desean listar
     * @return \Illuminate\View\View Vista del dashboard con posts paginados
     */
    public function index(User $user)
    {
        // Obtener posts del usuario ordenados por fecha descendente y paginados
        $posts =Post::where('user_id', $user->id)->latest()->paginate(20);

        // Retornar la vista 'dashboard' con el usuario y sus publicaciones
        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo post.
     *
     * @return \Illuminate\View\View Vista del formulario de creación de post
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Almacena un nuevo post en la base de datos.
     *
     * @param  Request  $request  Instancia de la petición HTTP con datos del post
     * @return \Illuminate\Http\RedirectResponse  Redirige al dashboard del usuario
     */
    public function store(Request $request)
    {
        // Validar los campos requeridos del formulario
        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        // Crear la publicación asociada al usuario autenticado
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);

        // Redirigir al dashboard del usuario
        return redirect()->route('post.index', auth()->user()->username);
    }

    /**
     * Muestra los detalles de un post específico.
     *
     * @param  User  $user  Usuario propietario del post
     * @param  Post  $post  Publicación a mostrar
     * @return \Illuminate\View\View Vista con los detalles del post
     */
    public function show(User $user, Post $post)
    {
        return view('posts.show', [
            'post' => $post,    
            'user' => $user
        ]);
    }

    /**
     * Elimina un post y su imagen asociada del sistema.
     *
     * @param  Post  $post  Publicación a eliminar
     * @return \Illuminate\Http\RedirectResponse  Redirige al dashboard con mensaje
     */
    public function destroy(Post $post)
    {
        // Verificar autorización de eliminación según la policy
        $this->authorize('delete', $post);

        // Ruta completa de la imagen en el sistema de archivos
        $imagen_path = public_path('uploads/' . $post->imagen);

        // Eliminar el archivo de imagen si existe
        $imagne_path = public_path('uploads/' . $post->imagen);

        // Eliminar el registro de la base de datos
        if(File::exists($imagne_path)){
            unlink($imagne_path);
        }

        // Redirigir al dashboard del usuario con mensaje de éxito
        return redirect()->route('post.index', auth()->user()->username)
        ->with('mensaje', '¡Post eliminado correctamente!');
    }
    
}
