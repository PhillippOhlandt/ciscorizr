<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::model('course', 'Course');
Route::model('chapter', 'Chapter');
Route::model('question', 'Question');
Route::model('answer', 'Answer');

Route::group(array('prefix' => 'admin'), function()
{
	Route::get('/', array('before' => 'auth', 'uses' => 'AdminController@index'));

	Route::get('/courses', array('before' => 'auth', 
								'uses' => 'AdminController@getCourses',
								'as' => 'courses-path'));
	Route::post('/courses/new', array('before' => 'auth|csrf', 
										'uses' => 'CourseController@postNew',
										'as' => 'course-new'));


	Route::get('/courses/{course}/chapter/{chapter}', array('before' => 'auth', 
										'uses' => 'ChapterController@show',
										'as' => 'chapter'));
	Route::post('/courses/{course}/chapter/new', array('before' => 'auth|csrf', 
										'uses' => 'ChapterController@postNew',
										'as' => 'chapter-new'));
	Route::get('/courses/{course}/chapter/{chapter}/delete', array('before' => 'auth', 
								'uses' => 'ChapterController@delete',
								'as' => 'chapter-delete'));
	Route::post('/courses/{course}/chapter/{chapter}/delete', array('before' => 'auth|csrf', 
										'uses' => 'ChapterController@destroy',
										'as' => 'chapter-delete'));
	Route::get('/courses/{course}/chapter/{chapter}/edit', array('before' => 'auth', 
								'uses' => 'ChapterController@edit',
								'as' => 'chapter-edit'));
	Route::post('/courses/{course}/chapter/{chapter}/edit', array('before' => 'auth|csrf', 
										'uses' => 'ChapterController@update',
										'as' => 'chapter-edit'));


	Route::get('/courses/{course}/chapter/{chapter}/question/{question}', array('before' => 'auth', 
										'uses' => 'QuestionController@show',
										'as' => 'question'));
	Route::post('/courses/{course}/chapter/{chapter}/question/new', array('before' => 'auth|csrf', 
										'uses' => 'QuestionController@postNew',
										'as' => 'question-new'));
	Route::get('/courses/{course}/chapter/{chapter}/question/{question}/delete', array('before' => 'auth', 
								'uses' => 'QuestionController@delete',
								'as' => 'question-delete'));
	Route::post('/courses/{course}/chapter/{chapter}/question/{question}/delete', array('before' => 'auth|csrf', 
										'uses' => 'QuestionController@destroy',
										'as' => 'question-delete'));
	Route::get('/courses/{course}/chapter/{chapter}/question/{question}/edit', array('before' => 'auth', 
								'uses' => 'QuestionController@edit',
								'as' => 'question-edit'));
	Route::post('/courses/{course}/chapter/{chapter}/question/{question}/edit', array('before' => 'auth|csrf', 
										'uses' => 'QuestionController@update',
										'as' => 'question-edit'));


	Route::post('/courses/{course}/chapter/{chapter}/question/{question}/answer/new', array('before' => 'auth|csrf', 
										'uses' => 'AnswerController@postNew',
										'as' => 'answer-new'));
	Route::get('/courses/{course}/chapter/{chapter}/question/{question}/answer/{answer}/edit', array('before' => 'auth', 
								'uses' => 'AnswerController@edit',
								'as' => 'answer-edit'));
	Route::post('/courses/{course}/chapter/{chapter}/question/{question}/answer/{answer}/edit', array('before' => 'auth|csrf', 
										'uses' => 'AnswerController@update',
										'as' => 'answer-edit'));


	Route::get('/courses/{course}', array('before' => 'auth', 
										'uses' => 'CourseController@show',
										'as' => 'course'));
	Route::get('/courses/{course}/delete', array('before' => 'auth', 
								'uses' => 'CourseController@delete',
								'as' => 'course-delete'));
	Route::post('/courses/{course}/delete', array('before' => 'auth|csrf', 
										'uses' => 'CourseController@destroy',
										'as' => 'course-delete'));
	Route::get('/courses/{course}/edit', array('before' => 'auth', 
								'uses' => 'CourseController@edit',
								'as' => 'course-edit'));
	Route::post('/courses/{course}/edit', array('before' => 'auth|csrf', 
										'uses' => 'CourseController@update',
										'as' => 'course-edit'));



    Route::get('login', array('before' => 'guest', 'uses' => 'AuthController@getLogin'));
    Route::post('login', array('before' => 'csrf', 'uses' => 'AuthController@postLogin'));
    Route::get('logout', 'AuthController@getLogout');

});


Route::get('/', array('as' => 'home', function()
{
	$courses = Course::where('is_visible', '=', 1)->get();
	return View::make('site.pages.index', ['courses' => $courses]);
}));

Route::group(array('prefix' => 'api'), function()
{

	Route::get('course/{course}/chapters', 'ApiController@getChaptersFromCourse');
	Route::get('chapter/{chapter}/questions', 'ApiController@getQuestionsFromChapter');
	Route::post('player/new', array('before' => 'csrf', 'uses' => 'PlayerController@store'));
	Route::post('player/rank', array('before' => 'csrf', 'uses' => 'ApiController@getRankForPlayer'));

});


Route::get('/{playerhash}', 'PlayerController@show');


























Route::get('/create/adminuser', function()
{

//User::truncate();

	$users = User::first();

	if(empty($users)){
		$user = new User();
		$user->username = "Admin";
		$user->email = "email@example.com";
		$user->password = Hash::make("admin");
		$user->permissions = 0;
		$user->last_login = date('Y-m-d G:i:s');
		$user->save();

		return $user;
	}

	return $users;
});