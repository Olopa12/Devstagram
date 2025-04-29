<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 *
 * Modelo de usuario que extiende de Authenticatable e incluye
 * relaciones con posts, likes y seguidores.
 *
 * @package App\Models
 *
 * @property int    $id                   Identificador único del usuario
 * @property string $name                 Nombre completo del usuario
 * @property string $username             Nombre de usuario único (slug)
 * @property string $email                Correo electrónico del usuario
 * @property string $password             Contraseña hasheada
 * @property string|null $remember_token  Token de sesión
 * @property \Illuminate\Support\Carbon|null $email_verified_at Fecha de verificación de email
 * @property \Illuminate\Support\Carbon|null $created_at  Fecha de creación
 * @property \Illuminate\Support\Carbon|null $updated_at  Fecha de última actualización
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atributos que pueden asignarse de forma masiva.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'
    ];

    /**
     * Atributos que se ocultan en la serialización del modelo.
     *
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atributos que deben convertirse (casts) al serializar.
     *
     * @var array<string,string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación uno a muchos: Usuario tiene muchas publicaciones.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Relación uno a muchos: Usuario tiene muchos likes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Relación muchos a muchos: usuarios que siguen a este usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    /**
     * Relación muchos a muchos: usuarios a los que este usuario sigue.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followins()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    /**
     * Verifica si el usuario autenticado sigue a otro usuario dado.
     *
     * @param  User $user  Usuario a comprobar
     * @return bool        True si ya sigue, false si no
     */
    public function siguiendo(User $user)
    {
        return $this->followers->contains( $user->id );
    }
}
