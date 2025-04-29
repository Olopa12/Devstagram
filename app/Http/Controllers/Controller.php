<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * Abstract Controller
 *
 * Esta clase base provee métodos comunes de autorización y validación
 * para todos los controladores de la aplicación.
 *
 * @package App\Http\Controllers
 */
abstract class Controller
{
    /**
     * Incluye métodos para verificar políticas de autorización.
     *
     * @see \Illuminate\Foundation\Auth\Access\AuthorizesRequests
     */
    use AuthorizesRequests;

    /**
     * Incluye métodos para validación de solicitudes HTTP.
     *
     * @see \Illuminate\Foundation\Validation\ValidatesRequests
     */
    use ValidatesRequests;
}
