<?php

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'v2',
    'namespace' => 'V2',
    'middleware' => ['throttle:200,1'] // allow 200 requests per minute
], function () {
    Route::get('/routes', 'HomeController@getRoutes');
    Route::get('/trips', 'HomeController@getTrips');
    Route::get('/organizations', 'HomeController@getOrganizations');
    Route::get('/notices', 'HomeController@getNotices');
    
    Route::post('/contacts', 'ContactController@store');
});


