<?php

namespace App\Livewire;

use Livewire\Component;

/**
 * Componente Livewire para gestionar los "likes" de una publicación.
 * 
 * Este componente permite a un usuario dar o quitar "like" a una publicación
 * y actualiza dinámicamente el número de "likes" sin recargar la página.
 */
class LikePost extends Component
{
    /** @var \App\Models\Post La publicación actual */
    public $post;

    /** @var bool Indica si el usuario actual ha dado like */
    public $isLiked;

    /** @var int Número total de likes de la publicación */
    public $likes;

    /**
     * Método que se ejecuta al montar el componente.
     *
     * @param \App\Models\Post $post La publicación recibida
     * @return void
     */
    public function mount($post)
    {
        $this->isLiked = $post->checkLike(auth()->user());
        $this->likes = $this->post->likes->count();
    }

    /**
     * Alterna el "like" del usuario sobre la publicación.
     *
     * Si el usuario ya dio like, se elimina. Si no, se crea uno nuevo.
     *
     * @return void
     */
    public function like()
    {
        if(($this->post)->checkLike(auth()->user()))
        {
            // Buscar y eliminar el registro de like para el usuario y la publicación especificada
            $this->post->likes()
                    ->where('post_id', $this->post->id)
                    ->delete();

            $this->isLiked = false;
            $this->likes--;
        }
        else
        {
            // Crear relación de like entre el usuario y la publicación
            $this->post->likes()->create([
                'user_id' => auth()->user()->id
            ]);                        
            $this->isLiked = true;
            $this->likes++;
        }
    }

    /**
     * Renderiza la vista asociada al componente.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.like-post');
    }

}
