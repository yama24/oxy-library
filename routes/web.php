<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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


// Route::get('/sent', function () {
//     return view('auth.checkemail', ['title' => 'Email Set']);
// });

Route::get('/', [HomeController::class, 'index'])->middleware('auth');

##### AUTH #####
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/forgotpassword', [AuthController::class, 'forgotpassword'])->name('forgotpassword');
Route::get('/resetpassword/{email}/{token}', [AuthController::class, 'resetpassword'])->name('resetpassword');
Route::post('/actionlogin', [AuthController::class, 'actionlogin'])->name('actionlogin');
Route::post('/actionregister', [AuthController::class, 'actionregister'])->name('actionregister');
Route::post('/actionforgotpassword', [AuthController::class, 'actionforgotpassword'])->name('actionforgotpassword');
Route::post('/actionresetpassword', [AuthController::class, 'actionresetpassword'])->name('actionresetpassword');
Route::get('/actionlogout', [AuthController::class, 'actionlogout'])->name('actionlogout');
##### AUTH #####

Route::get('/books', [HomeController::class, 'books'])->middleware('auth');