<?php

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

//トップページ
Route::get('/', 'MainHomeController@index');

//パスワード忘れた画面
Route::get('/allhome/forgot', 'MainHomeController@showforgot');
Route::post('/allhome/forgot', 'MainHomeController@forgot');
//ワンタイムパスワード入力画面
Route::get('/allhome/onepass', 'MainHomeController@showonepass');
Route::post('/allhome/onepass', 'MainHomeController@onepass');
//パスワード入力画面
Route::get('/allhome/resetpass', 'MainHomeController@showresetpass')->name('test');
Route::post('/allhome/resetpass', 'MainHomeController@resetpass');

/*
 * パスワ―ド変更
 */
Route::get('/updatepass',                   'Auth/ResetPassword@Auth');

/*
 * レッスン
 */
Route::post('/lesson/detail/start/{id}',    'LessonController@start')->name('lesson_start');
Route::get('/lesson/testRoom', 'LessonController@start')->name('lesson_start');

/*
 * 管理者一覧
 */
Route::get('/admin/list',                    'AdminController@index')->name('admin_index');
Route::post('/admin/list',                   'AdminController@search');
Route::post('/admin/create',                 'AdminController@create')->name('admin_create');

/*
 * 管理者詳細
 */
Route::get('/admin/detail/{adminisId}',     'AdminController@detail')->name('admin_detail');
Route::post('/admin/detail/{adminisId}',    'AdminController@update')->name('admin_update');
Route::get('/admin/delete/{adminisId}',    'AdminController@delete')->name('admin_delete');

/*
 * 学生一覧
 */
Route::get('/student/list',                 'StudentController@index')->name('student_index');
Route::post('/student/list',                'StudentController@search');
Route::post('/student/create',              'StudentController@create')->name('student_create');
Route::post('/student/list/import',         'StudentController@import');
/*
 * 学生詳細
 */
Route::get('/student/detail/{id}',          'StudentController@detail')->name('student_detail');
Route::post('/student/detail/{id}',         'StudentController@update')->name('student_update');
Route::get('/student/delete/{id}',          'StudentController@delete')->name('student_delete');

// パスワード変更
Route::post('password', 'User\HomeController@updatePassword')->name('user_password_update');


// ユーザー
Route::namespace('User')->prefix('user')->name('user.')->group(function () {
    // ログイン認証関連
    Auth::routes([
        'register' => true,
        'confirm'  => false,
        'reset'    => false

    ]);
    // ログイン認証後
    Route::middleware('auth:user')->group(function () {
        // TOPページ
        Route::resource('home', 'HomeController', ['only' => 'index']);

        /* プロフィール陣営 */
        Route::get('/profile',                      'ProfileController@profile');
        Route::post('/profile',                     'ProfileController@profileupdate');
        Route::get('/yourProfile/{id}',             'LessonController@yourProfile');

        /* レッスン検索 */
        Route::get('/lesson/search',                'LessonController@search')->name('lesson_search');
        Route::post('/lesson/search',               'LessonController@result')->name('lesson_result');

        /* レッスン予約 */
        Route::get('/lesson/show/{lesson_id}',      'LessonController@show')->name('lesson_show');
        Route::post('/lesson/reserve',              'LessonController@reserve')->name('lesson_reserve');

        /* レッスン登録 */
        Route::get('/lesson/create',                'LessonController@create')->name('lesson_create');
        Route::post('/lesson/create',               'LessonController@insert')->name('lesson_insert');

        /* レッスン一覧 */
        Route::get('/lesson/list',                   'LessonController@list')->name('lesson_list');

        /* レッスン詳細 */
        Route::get('/lesson/detail_0/{id}',           'LessonController@detail0')->name('lesson_detail_0');
        Route::post('/lesson/detail/cancel0',        'LessonController@cancel0')->name('lesson_cancel0');
        Route::get('/lesson/detail_1/{id}',           'LessonController@detail1')->name('lesson_detail_1');
        Route::get('/lesson/detail_2/{id}',           'LessonController@detail2')->name('lesson_detail_2');
        Route::post('/lesson/detail/cancel2',        'LessonController@cancel2')->name('lesson_cancel2');
        Route::get('/lesson/detail/cancel2_1/{id}',        'LessonController@cancel2_1');
        Route::get('/lesson/detail_3/{id}',           'LessonController@detail3')->name('lesson_detail_3');

        /* レッスン */
        Route::post('/lesson/detail/start/{id}',    'LessonController@start')->name('lesson_start');

        /* レッスン履歴 */
        Route::get('/lesson/log',                   'LessonlogController@log')->name('lesson_log');
        Route::post('/lesson/log',                 'LessonlogController@lang')->name('lang_log');

        /* レッスン評価 */
        Route::post('/lesson/review',                 'LessonController@review')->name('review');

        /* チャット */
        Route::get('/chat','ChatController@chat');
        Route::get('/user_search','ChatController@user_search');
        Route::get('/group_make/{id}','ChatController@group_make');
        Route::post('/mes','ChatController@mes');
        Route::post('/get_mes/{id}','ChatController@get_mes');
        Route::post('/send_mes','ChatController@send_mes');
        Route::get('/group_make/{id}','ChatController@group_make');



        /* ルーム入室(hikal) */
        //Route::get('/lesson/room/{id}',                 'LessonController@inRoom')->name('room');
        Route::post('/lesson/room/leave',                 'LessonController@leaveRoom')->name('room');

        Route::get('/lesson/aRoom/{id}',                   'RoomController@indexA');
        Route::get('/lesson/bRoom/{id}',                   'RoomController@indexB');
        Route::post('/lesson/auth/video_chatA',                 'RoomController@auth');

        //Route::get('/lesson/video_chat',                 'VideoChatController@index');
        //Route::post('/lesson/auth/video_chat', 'VideoChatController@auth');

    });

});


// 管理者
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    // ログイン認証関連
    Auth::routes([
        'register' => true,
        'confirm'  => false,
        'reset'    => false
    ]);
    // ログイン認証後
    Route::middleware('auth:admin')->group(function () {
        // TOPページ
        Route::resource('home', 'HomeController', ['only' => 'index']);

    });
});