<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PerfilController extends Controller
{
    public function index()
    {
        return view(('perfil.index'));
    }

    public function store(Request $request)
    {
        $request->request->add(['username' => Str::slug( $request->username )]);

        $this->validate($request, [
            'username' => ['required', 'unique:users,username,'.auth()->user()->id, 
            'min:3', 'max:20', 'not_in:editar-perfil'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp'],
        ]);

        if($request->imagen) 
        {
            $manager = new ImageManager(new Driver());
            $imagen = $request->file('imagen');
 
            $nombreImagen = Str::uuid() . "." . $imagen->extension();
    
            $imagenServidor = $manager->read($imagen);
            $imagenServidor->cover(1000, 1000);
        
            $imagenesPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenesPath);
        } 
       
        //Guardar cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        //Redireccionar
        return redirect()->route('post.index', $usuario->username);
    }
}
