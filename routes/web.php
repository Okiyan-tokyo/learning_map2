<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\PatchController;
use App\Http\Controllers\DeleteController;

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

// 名称編集の時
Route::patch("patch/name",[PatchController::class,"namechange"])
->name("editroute");

// 削除の時
Route::delete("delete/name",[DeleteController::class,"themedelete"])
->name("deleteroute");