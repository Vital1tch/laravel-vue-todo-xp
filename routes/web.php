<?php /** @noinspection ALL */

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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




Route::get('/',[IndexController::class,'index'])->name('Home');
Route::get('/about',[IndexController::class,'about'])->name('About');

Route::resource('users',UserController::class);

//Route::inertia('/about','About');
//Route::inertia('users.index','Pages/Users/Index.vue');
