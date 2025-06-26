<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth', 'namespace' => 'V2'], function () {
    Route::prefix('/operator')->name('operator.')->group(function () {
        Route::get('/', 'OperatorController@index')->name('index');
        Route::get('/list_data', 'OperatorController@listData')->name('list_data');
        Route::post('/store', 'OperatorController@store')->name('store');
        Route::post('/update', 'OperatorController@update')->name('update');
        Route::post('/destroy', 'OperatorController@destroy')->name('destroy');
    });

    Route::prefix('/driver')->name('driver.')->group(function () {
        Route::get('/', 'DriverController@index')->name('index');
        Route::get('/list_data', 'DriverController@listData')->name('list_data');
        Route::post('/store', 'DriverController@store')->name('store');
        Route::post('/update', 'DriverController@update')->name('update');
        Route::post('/destroy', 'DriverController@destroy')->name('destroy');
    });

    Route::prefix('/trip')->name('trip.')->group(function () {
        Route::get('/', 'TripController@index')->name('index');
        Route::get('/list_data', 'TripController@listData')->name('list_data');
        Route::post('/store', 'TripController@store')->name('store');
        Route::post('/update', 'TripController@update')->name('update');
        Route::post('/destroy', 'TripController@destroy')->name('destroy');
        Route::get('/report', 'TripController@report')->name('report');
        Route::post('/report/print','TripController@reportPrint')->name('report.print');
    });
    Route::prefix('/vehicle')->name('vehicle.')->group(function () {
        Route::get('/', 'VehicleController@index')->name('index');
        Route::post('/store', 'VehicleController@store')->name('store');
        Route::get('/list_data', 'VehicleController@list_data')->name('list_data');
        Route::post('/update', 'VehicleController@update')->name('update');
        Route::post('/delete', 'VehicleController@destroy')->name('delete');
    });

    // Routes API endpoints
    Route::prefix('/routes')->name('routes.')->group(function () {
        Route::get('/list', 'RouteController@list')->name('list');
        Route::get('/{id}', 'RouteController@show')->name('show');
    });

    // Drivers API endpoints
    Route::prefix('/drivers')->name('drivers.')->group(function () {
        Route::get('/list', 'DriverController@list')->name('list');
        Route::get('/{id}', 'DriverController@show')->name('show');
    });

    // Vehicles API endpoints
    Route::prefix('/vehicles')->name('vehicles.')->group(function () {
        Route::get('/list', 'VehicleController@list')->name('list');
        Route::get('/{id}', 'VehicleController@show')->name('show');
    });
});

