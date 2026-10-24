<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// La SPA de Vue resuelve el resto de rutas (/register, /game, /ranking...) en el cliente:
// cualquier URL que no sea de la API ni de los assets devuelve la misma vista.
Route::view('/{any}', 'welcome')->where('any', '^(?!api|build|storage).*$');
