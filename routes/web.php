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

// 初期設定/設定追加のページへ
Route::get("config/config",[ConfigController::class,"conf_base"])
->name("configroute");

// 設定追加のpost
Route::post("config/conf_add",[ConfigController::class,"conf_add"])
->name("conf_add_route");

// 既存設定編集のページ
Route::get("config/exist_edit",[ConfigController::class,"conf_edit"])
->name("conf_edit_route");

// 設定から大テーマ編集のpatch
Route::patch("config/conf_patch{post}",[ConfigController::class,"conf_patch"])
->name("conf_patch_route");

// // 設定から内容変更のpatch
// Route::patch("config/conf_toggle",[ConfigController::class,"conf_cont_toggle"])
// ->name("conf_cont_toggle_route");

// // 設定から大テーマ削除のpost
// Route::delete("config/conf_delete",[ConfigController::class,"conf_delete"])
// ->name("conf_delete_route");
