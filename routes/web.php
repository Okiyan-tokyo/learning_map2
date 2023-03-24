<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LearningController;

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

Route::get('/', [LearningController::class,"showindex"])->name("indexroute");

// テーマを挿入したとき
Route::post('/posts.learning_plus', [LearningController::class,"learning_plus"])->name("plusroute");
