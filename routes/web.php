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


// Route::get('/', function () {
//     return redirect('home');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//Admin Routes
Route::middleware(['auth.role:admin'])->group(function () {
    Route::get('/user/create', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
    Route::post('/user/create', ['as' => '', 'uses' => 'Auth\RegisterController@register']);
    Route::resource('/category', 'CategoryController', ['as' => 'admin']);
});

Route::middleware(['auth.role:admin,teacher'])->group(function () {
    Route::resource('/course', 'CourseController', ['as' => 'admin']);
    Route::get('/course/{id}/clean', 'CourseController@clean');
    Route::resource('/lesson', 'LessonController', ['as' => 'admin']);
    Route::resource('/task', 'TaskController', ['as' => 'admin']);
    Route::resource('/answer', 'AnswerController', ['as' => 'admin']);
    Route::resource('/user', 'UserController', ['as' => 'admin']);
    Route::get('/user/create/multiple', 'UserController@createMultiple', ['as' => 'admin'])->name('admin.user.create.multiple');
    Route::post('/user/store/multiple', 'UserController@storeMultiple', ['as' => 'admin'])->name('admin.user.store.multiple');
});

Route::middleware(['auth.role:student'])->group(function () {

    Route::get('/', function () {
          return redirect('/student/course');
        });
    Route::get('/student/course/{id}/enroll', 'UserCourseController@enroll',  ['as' => 'student']);
    Route::get('/student/course/{id}/unenroll', 'UserCourseController@unenroll',  ['as' => 'student']);
    Route::resource('/student/course', 'UserCourseController', ['as' => 'student']);
    Route::resource('/student/lesson', 'UserLessonController', ['as' => 'student']);
    Route::resource('/student/task', 'UserTaskController', ['as' => 'student']);
    Route::resource('/student/answer', 'UserAnswerController', ['as' => 'student']);
});



//Teacher Routes




//Student Routes

