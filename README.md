<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/jortizr/tecnologia"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Inventario tecnologico

Inventario para gestionar los dispositivos corporativos para cada area operativa de la compañia, donde se gestiona la signacion, prestacion, devolucion y reposicion de cada dispositivo entre ellos estan, las tablets y celulares corporativos.

---

## Requisitos Previos

Antes de comenzar, asegúrate de tener instalado lo siguiente:

* **PHP** (Versión 8.1 o superior)
* **Composer**
* **Node.js y npm**
* **Una base de datos** (como MySQL)

---

## Pasos para la Instalación y Configuración

Sigue estos pasos en tu terminal para poner el proyecto en funcionamiento.

### 1. Clonar el repositorio

Clona el proyecto en tu máquina local.

```
git clone [https://github.com/jortizr/tecnologia.git](https://github.com/jortizr/tecnologia.git)
cd tu-repositorio
```

### 2. Instalar dependencias
Instala las dependencias de PHP con Composer y las de JavaScript con npm.

```
composer install
npm install
```

### 3. Configurar el entorno
Crea una copia del archivo de ejemplo .env.example y renómbralo a .env.

```Bash
cp .env.example .env
```
Abre el archivo .env y configura la conexión a tu base de datos. En este ejemplo, se usa una base de datos llamada tecnologia.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tecnologia
DB_USERNAME=root
DB_PASSWORD=
```
### 4. Generar la clave de la aplicación
Ejecuta este comando para generar una clave de seguridad única para la aplicación.

```
php artisan key:generate
```

### 5. Configurar la base de datos
Ejecuta las migraciones para crear las tablas necesarias en tu base de datos.

```
php artisan migrate
```

### 6. Compilar los assets
Compila los archivos de estilos (Tailwind CSS) y scripts (Livewire) para que la interfaz de usuario se renderice correctamente.

```
npm run build
```

### 7. Iniciar el servidor de desarrollo
Para ver tu proyecto en el navegador, inicia el servidor local de Laravel.

```
php artisan serve
```

### 8. Iniciar el servidor de npm
Para ver tu proyecto en el navegador, inicia el servidor local de Laravel.
```
npm run dev
```
Tu aplicación ahora estará disponible en http://127.0.0.1:8000.


### 9. Configuracion de livewire
Para evitar errores de layouts no found, se requiere cambiar la ubicacion de la vista app.blade.php dentro de la configuracion de livewire, su archivo se ubica en vendor:
```
vendor\livewire\livewire\config\livewire.php
```
se busca la linea que diga:
```
'layout' => 'components.layouts.app',
```
la cual debe quedar asi:
```    
'layout' => 'layouts.app',
```
