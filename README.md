<p align="center">
  <a href="https://devstagram-olopa12.domcloud.dev" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="#"><img src="https://img.shields.io/badge/Laravel-11-red?logo=laravel" alt="Laravel 11"></a>
  <a href="#"><img src="https://img.shields.io/badge/Livewire-Activo-purple?logo=livewire" alt="Livewire Activo"></a>
  <a href="#"><img src="https://img.shields.io/badge/TailwindCSS-Utilizado-0ea5e9?logo=tailwindcss" alt="Tailwind CSS Utilizado"></a>
  <a href="#"><img src="https://img.shields.io/badge/MySQL-Base%20de%20Datos-4479A1?logo=mysql" alt="MySQL Usado"></a>
</p>

---

## 📸 Devstagram

**Devstagram** es una aplicación web tipo red social inspirada en Instagram. Fue desarrollada con [Laravel 11](https://laravel.com/), [Livewire](https://livewire.laravel.com/), [Tailwind CSS](https://tailwindcss.com/) y base de datos [MySQL](https://www.mysql.com/).

Permite a los usuarios registrarse, iniciar sesión, publicar imágenes, comentar, dar "likes" y ver perfiles.

🔗 **[Visita la demo online aquí](https://devstagram-olopa12.domcloud.dev/)**

---

## 🚀 Tecnologías utilizadas

- **Laravel 11** – Framework backend y sistema de rutas
- **Livewire** – Componentes interactivos sin necesidad de JavaScript
- **Tailwind CSS** – Diseño moderno y responsive
- **MySQL** – Almacenamiento de datos
- **DomCloud** – Hosting para la demo en línea

---

## ⚙️ Requisitos del proyecto

- PHP 8.2 o superior
- Composer
- Node.js y npm
- MySQL

---

## 🛠️ Instalación y ejecución

```bash
git clone https://github.com/tu-usuario/devstagram.git
cd devstagram
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
# Configura los datos de tu base de datos en el archivo .env
php artisan migrate --seed
php artisan serve


