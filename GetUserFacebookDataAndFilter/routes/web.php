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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', 'TestController@login');

Route::get('/logincallback', 'FacebookController@loginCallback');

Route::get('/cronjob', 'TestController@CronJob');

Route::get('/filter', 'TestController@FilterData');

Route::get('/oddity', function(){

    return view('test.main');
});


?>