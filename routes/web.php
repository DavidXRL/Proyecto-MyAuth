<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Post; 
use App\Http\Controllers\PostController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/develop', function(){
    return 'Welcome to Developments';
})->name('develop.index');

Route::get('/develop/{develops}', function($develops)
{
    if ($develops === '5')
    {
        return redirect()->route('develop.index');
    }
    return 'Detalles del desarrollador ' . $develops;
});

Route::view('/welcome', 'welcome') -> name('welcome');
// Route::get('/dashboard', function () {
//     //EJECUCIÓN DEL MIDDLEWARE, ANTES DE DEVOLVER O MOSTRAR UNA VISTA
//     return view('dashboard');
//     //SE PUEDE EJECUTAR DESPUÉS DE DEVOLVERLO PARA MOSTRAR UNA VISTA
// })->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//RUTA PERSONALIZADA PARA MANDAR A LLAMAR LA FUNCIÓN DE INDEX Y MOSTRAR LOS POSTEOS 
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

//RUTA PERSONALIZADA PARA CREAR EL REGISTRO EN LA BD DE POSTS
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');



require __DIR__.'/auth.php';
