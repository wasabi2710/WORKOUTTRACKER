<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// main pages route..
/**
 * default page index..
 */
Route::get('/', 'App\Http\Controllers\PagesController@index');
/**
 * about page..
 */
Route::get('/about', 'App\Http\Controllers\PagesController@about');

// workout log routes..
// routines
Route::get('/routines', 'App\Http\Controllers\PagesController@routines');
// food
Route::get('/food', 'App\Http\Controllers\PagesController@food');
// exercises
Route::get('/exercise', 'App\Http\Controllers\PagesController@exercise');
Route::get('/showexercise/{id}', 'App\Http\Controllers\PagesController@showexercise');
Route::get('/addExercise', 'App\Http\Controllers\PagesController@addExercise');
Route::get('/showworkout/{id}', 'App\Http\Controllers\PagesController@showworkout');
Route::get('/destroyWorkout/{id}', 'App\Http\Controllers\PagesController@destroyWorkout');
// sub tasks
// routines & workouts
Route::get('/discardworkout/{id}', 'App\Http\Controllers\PagesController@discardworkout');
Route::get('/startworkout', 'App\Http\Controllers\PagesController@startworkout');
Route::get('/storeroutine', 'App\Http\Controllers\PagesController@storeroutine');
Route::get('/storetracker/{trackerid}', 'App\Http\Controllers\PagesController@storetracker');
Route::get('/createworkout', 'App\Http\Controllers\PagesController@createworkout');
Route::get('/storeworkout/{id}/{trackerid}/{type}', 'App\Http\Controllers\PagesController@storeworkout');
Route::get('/addworkout', 'App\Http\Controllers\PagesController@addworkout');
Route::get('/removeworkout/{id}', 'App\Http\Controllers\PagesController@removeworkout');
// tracker
Route::get('/tracker', 'App\Http\Controllers\PagesController@tracker');

/**
 * authentication routes..
 */
Auth::routes();
// home/dashboard
/* Route::get('/home', 'App\Http\Controllers\HomeController@index') */
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
