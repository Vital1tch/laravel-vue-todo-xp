<?php /** @noinspection ALL */

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;

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

Route::get('/',[HomeController::class,'index'])->name('Home');

Route::get('/about',[AboutController::class,'index'])->name('About');

Route::post('/tasks', [HomeController::class,'addTask']);

Route::post('/habits', [HomeController::class,'addHabit']);

Route::delete('/tasks/{id}',[HomeController::class,'completeTask']);

Route::delete('/tasks/{task}', [HomeController::class, 'destroyTask']);

Route::delete('/habits/{habit}', [HomeController::class, 'destroyHabit']);

Route::put('/habits/{habit}', [HomeController::class, 'updateHabit']);

Route::put('/tasks/{task}', [HomeController::class, 'updateTask']);

Route::get('/api/user-progress', function () {
    return response()->json([
        'experience' => session('experience', 0),
        'level' => session('level', 1)
    ]);
});

Route::post('/habits/add-experience', [HomeController::class, 'addExperienceForHabit']);

Route::post('/reset-progress', [HomeController::class, 'resetProgress']);

