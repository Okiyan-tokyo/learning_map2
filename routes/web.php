<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\PatchController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\ConfigController;

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

// 意識することの編集
Route::patch("patch/conscious",([PatchController::class,"edit_conscious"]))
->name("edit_conscious_route");

// 意識することの削除
Route::delete("delete/conscious",([PatchController::class,"delete_conscious"]))
->name("delete_conscious_route");

// 初期設定/設定変更のページへ
Route::get("config/config",[ConfigController::class,"conf_base"])
->name("configroute");

// // 初期設定のpost
// Route::post("config/conf_post",[ConfigController::class,"conf_add"])
// ->name("conf_add_route");

// 設定変更のpost
Route::patch("config/conf_patch",[ConfigController::class,"conf_edit"])
->name("conf_edit_route");

// // 設定から大テーマ削除のpost
// Route::delete("config/conf_delete",[ConfigController::class,"conf_delete"])
// ->name("conf_delete_route");
