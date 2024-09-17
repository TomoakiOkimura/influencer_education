<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\ArticleController as UserArticleController;
use App\Http\Controllers\user\ProfileController as UserProfileController;
use App\Http\Controllers\user\CurriculumController as UserCurriculumController;
use App\Http\Controllers\admin\ArticleController as AdminArticleController;


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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('user/{article}/article', [App\Http\Controllers\user\ArticleController::class, 'article'])->name('user.article');
Route::get('user/profile_edit', [App\Http\Controllers\user\ProfileController::class, 'profile_edit'])->name('user.profile_edit');
Route::put('user/profile_update/{id}', [App\Http\Controllers\user\ProfileController::class, 'profile_update'])->name('user.profile_update');
Route::get('user/password_edit', [App\Http\Controllers\user\ProfileController::class, 'password_edit'])->name('user.password_edit');
Route::put('user/password_update', [App\Http\Controllers\user\ProfileController::class, 'password_update'])->name('user.password_update');
Route::get('user/curriculum_list/{id?}', [App\Http\Controllers\user\CurriculumController::class, 'curriculum_list'])->name('user.curriculum_list');

// 紀谷が追加した仮ルート。
Route::get('user/password/hash', [App\Http\Controllers\user\ProfileController::class, 'showPasswordToHash'])->name('show.password.hash');
Route::POST('user/password/hash', [App\Http\Controllers\user\ProfileController::class, 'updatePassWordToHash'])->name('password.hash.update');

Route::get('admin/article_list', [App\Http\Controllers\admin\ArticleController::class, 'article_list'])->name('admin.article_list');
Route::get('admin/article_create', [App\Http\Controllers\admin\ArticleController::class, 'create'])->name('admin.article_create');
Route::post('admin/article_store', [App\Http\Controllers\admin\ArticleController::class, 'store'])->name('admin.article_store');
Route::get('admin/{article}/article_edit', [App\Http\Controllers\admin\ArticleController::class, 'article_edit'])->name('admin.article_edit');
Route::put('admin/{article}/article_update', [App\Http\Controllers\admin\ArticleController::class, 'update'])->name('admin.article_update');
Route::delete('admin/article/{article}', [App\Http\Controllers\admin\ArticleController::class, 'destroy'])->name('admin.article_destroy');
Route::namespace('Admin\Auth')->group(function () {
    Route::get('admin/confirm-password', [ConfirmPasswordController::class, 'showConfirmForm'])->name('admin.password.confirm');
    Route::post('admin/confirm-password', [ConfirmPasswordController::class, 'confirm']);
});
