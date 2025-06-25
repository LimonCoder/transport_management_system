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
    });
        Route::prefix('/vehicle')->name('vehicle.')->group(function () {
        Route::get('/', 'VehicleSetupController@index')->name('index');
        Route::post('/store', 'VehicleSetupController@store')->name('store');
        Route::get('/list_data', 'VehicleSetupController@list_data')->name('list_data');
        Route::post('/update', 'VehicleSetupController@update')->name('update');
        Route::post('/delete', 'VehicleSetupController@destroy')->name('delete');
        // useless vehicle module
        Route::get('/useless', 'VehicleSetupController@uselessVehicle')->name('useless');
        Route::post('/uselessVehicleStore', 'VehicleSetupController@uselessVehicleStore')->name('uselessVehicle.store');
        Route::get('/uselessVehicleList', 'VehicleSetupController@uselessVehicleList')->name('useless.list_data');
    });
});

