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

Route::post('/login', 'Api\UserController@login');

Route::middleware('Api.Admin.Auth')->namespace('V1')->group(function () {

    // employee
    Route::prefix('/employee')->group(function () {
        Route::get('/', 'Api\EmployeeController@index');
        Route::post('/store', 'Api\EmployeeController@store');
        Route::get('/list_data', 'Api\EmployeeController@list_data');
        Route::post('/update', 'Api\EmployeeController@update');
        Route::post('/delete', 'Api\EmployeeController@destroy');
    });

    // driver
    Route::prefix('/driver')->group(function () {
        Route::post('/store', 'Api\DriverController@store');
        Route::get('/list_data', 'Api\DriverController@list_data');
        Route::post('/update', 'Api\DriverController@update');
        Route::post('/delete', 'Api\DriverController@destroy');
    });

    // vehicle
    Route::prefix('/vehicle')->group(function () {
        Route::get('/', 'Api\VehicleController@index');
        Route::post('/store', 'Api\VehicleController@store');
        Route::get('/list_data', 'Api\VehicleController@list_data');
        Route::post('/update', 'Api\VehicleController@update');
        Route::post('/delete', 'Api\VehicleController@destroy');
        Route::post('/useless_vehicle_store', 'Api\VehicleController@uselessVehicleStore');
    });

    // logbook
    Route::prefix('/logbook')->group(function () {
        Route::get('/', 'Api\LogBookController@index');
        Route::post('/store', 'Api\LogBookController@store');
        Route::get('/list_data', 'Api\LogBookController@list_data');
        Route::post('/update', 'Api\LogBookController@update');
        Route::post('/delete', 'Api\LogBookController@destroy');
    });
//rental car
    Route::prefix('/rental_car')->group(function (){
       Route::get('/', 'Api\RentalCarController@index');
       Route::get('/list_data', 'Api\RentalCarController@list_data');
       Route::post('/store', 'Api\RentalCarController@store');
       Route::post('/update', 'Api\RentalCarController@update');
       Route::post('/delete', 'Api\RentalCarController@destroy');
    });

    //Repairs
    Route::prefix('/repairs')->group(function(){
        Route::get('/index','Api\RepairsController@index');
        Route::post('/store', 'Api\RepairsController@store');
        Route::get('/list_data', 'Api\RepairsController@list_data');
        Route::post('/update', 'Api\RepairsController@update');
        Route::post('/delete', 'Api\RepairsController@destroy');
    });
    //Report
    Route::get('/employee_report','Api\ReportController@employee_report');
    Route::get('/driver_report','Api\ReportController@driver_report');
    Route::get('/repairs_report_print','Api\ReportController@repairs_report_print');
    Route::get('/lubricant_report_print','Api\ReportController@lubricant_report_print');
    Route::get('/useless_report_print','Api\ReportController@useless_report_print');
    Route::get('/log_book_report_print','Api\ReportController@log_book_report_print');
    Route::get('/rentalcar_report_print','Api\ReportController@rentalcar_report_print');

//lubricant list
    Route::get('/lubricant/list_data','Api\FuelOilController@list_data');
    Route::post('/lubricant/store','Api\FuelOilController@store');
});
