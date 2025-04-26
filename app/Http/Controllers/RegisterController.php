<?php

namespace App\Http\Controllers;
//posible errro recrear en caso de fallos
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function index() 
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->request->add(['username' => Str::slug( $request->username )]);

        $request->validate([
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20|not_in:editar-perfil',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:5'
        ]);

        User::create([
            'name' => $request->name,
            'username' => Str::slug( $request->username ),
            'email' => $request->email,
            'password' => Hash::make( $request->password )
        ]);

        Auth::attempt($request->only('email', 'password'));

        return redirect()->route('post.index', auth()->user()->username);
    }
}
