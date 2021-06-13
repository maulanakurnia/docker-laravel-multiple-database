<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, HomeController, TaskController};
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

Route::get('/', [AuthController::class, 'showFormLogin'])->name('login');
Route::get('login', [AuthController::class, 'showFormLogin'])->name('login');

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::get('signup', [AuthController::class, 'showFormRegister'])->name('register');
Route::post('signup', [AuthController::class, 'register']);

Route::get('/signup', function () {
    return view('pages.signup');
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('tasks', TaskController::class)->only([
        'index', 'store', 'update', 'destroy', 'edit'
    ]);

    Route::post('updateTask',[TaskController::class, 'updateTask'])->name('tasks.updateTask');
 
});
