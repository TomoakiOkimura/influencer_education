<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('user')->namespace('Admin')->name('admin.')->group(function () {
    
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ----------------------授業一覧画面表示
Route::get('/curriculum_list', [App\Http\Controllers\CurriculumController::class, 'showCurriculumList'])->name('show.curriculum.list');
// 学年ボタン押下後に学年ごとの授業の表示
Route::get('/curriculum_list/{gradeId}', [App\Http\Controllers\CurriculumController::class, 'getCurriculum'])->name('search.curriculum.list');
//これいるんかいね？
Route::get('/grades', [App\Http\Controllers\CurriculumController::class, 'showGrades']);

// ------------------配信期間編集画面--新規登録用
Route::get('/show_delivery_new_create/{id}',  [App\Http\Controllers\DeliveryController::class, 'showDeliveryNewCreate'])->name('show.delivery.new.create');
// 配信期間編集画面--新規登録処理用
Route::post('/delivery_new_create/{id}',  [App\Http\Controllers\DeliveryController::class, 'deliveryNewCreate'])->name('delivery.new.create');

// ------------------配信期間編集画面--更新表示用
Route::get('/show_delivery_update/{id}',  [App\Http\Controllers\DeliveryController::class, 'showDeliveryUpdate'])->name('show.delivery.update');
// 配信期間編集画面--更新処理用
Route::post('/delivery_update/{id}',  [App\Http\Controllers\DeliveryController::class, 'deliveryUpdate'])->name('delivery.update');

// ------------------配信期間削除ボタンでデータがあったときの削除処理
Route::delete('/delivery/{id}', [App\Http\Controllers\DeliveryController::class, 'destroy'])->name('delivery.destroy');

//--------------------授業新規登録画面--表示用
Route::get('/curriculum_showcreate', [App\Http\Controllers\CurriculumController::class, 'showCurriculumCreate'])->name('show.curriculum.create');
//授業新規登録画面--登録処理用
Route::post('/curriculum_create', [App\Http\Controllers\CurriculumController::class, 'curriculumCreate'])->name('curriculum.create');


//---------------------授業更新登録画面--表示用
Route::get('/curriculum_edit/{id}', [App\Http\Controllers\CurriculumController::class, 'showCurriculumEdit'])->name('show.curriculum.edit');
//授業更新登録画面--更新登録用
Route::post('/curriculum_edit/{id}', [App\Http\Controllers\CurriculumController::class, 'curriculumEdit'])->name('curriculum.edit');
Route::get('show.search.grade/{grade_id}',[App\Http\Controllers\CurriculumController::class, 'searchCurriculums'])->name('show.search.grade');
Route::post('curriculum_store',[App\Http\Controllers\CurriculumController::class, 'store'])->name('store');

});