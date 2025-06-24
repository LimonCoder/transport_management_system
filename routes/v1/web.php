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

use Illuminate\Support\Facades\App;
use \Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);


// all admin route
Route::group(['middleware' => 'auth', 'namespace' => 'V1'], function () {

    Route::get('lang/{locale}', function ($locale) {
        if (!in_array($locale, ['en', 'bn'])) {
            abort(400);
        }
        session(['locale' => $locale]);
        return redirect()->back();
    });

    Route::get('/home', 'HomeController@index')->name('home');

    // Auth logout
    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');

    // impersonate
    Route::get('/impersonate/{id}', 'SuperAdminController@impersonate')->name('impersonate');
    Route::get('/impersonateleave', 'SuperAdminController@impersonateleave')->name('impersonate.leave');

    //organization
    Route::prefix('/organization')->name('organization.')->group(function () {
        Route::get('/', 'OrganizationInfoController@index')->name('index');
        Route::post('/store', 'OrganizationInfoController@store')->name('store');
        Route::get('/list_data', 'OrganizationInfoController@list_data')->name('list_data');
        Route::post('/update', 'OrganizationInfoController@update')->name('update');
        Route::post('/delete', 'OrganizationInfoController@destroy')->name('delete');
    });

    // designation
    Route::prefix('/designation')->name('designation.')->group(function () {
        Route::get('/', 'DesignationController@index')->name('index');
        Route::post('/store', 'DesignationController@store')->name('store');
        Route::get('/list_data', 'DesignationController@list_data')->name('list_data');
        Route::post('/delete', 'DesignationController@destroy')->name('delete');
    });

    // employee
    Route::prefix('/employee')->name('employee.')->group(function () {
        Route::get('/', 'EmployeeController@index')->name('index');
        Route::post('/store', 'EmployeeController@store')->name('store');
        Route::get('/list_data', 'EmployeeController@list_data')->name('list_data');
        Route::post('/update', 'EmployeeController@update')->name('update');
        Route::post('/delete', 'EmployeeController@destroy')->name('delete');
    });

    // driver
    Route::prefix('/driver')->name('driver.')->group(function () {
        Route::get('/', 'DriverInfoController@index')->name('index');
        Route::post('/store', 'DriverInfoController@store')->name('store');
        Route::get('/list_data', 'DriverInfoController@list_data')->name('list_data');
        Route::post('/delete', 'DriverInfoController@destroy')->name('delete');
    });

    // vehicle
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


    // log book
    Route::prefix('/logbook')->name('logbook.')->group(function () {
        Route::get('/', 'LogBookController@index')->name('index');
        Route::post('/store', 'LogBookController@store')->name('store');
        Route::get('/list_data', 'LogBookController@list_data')->name('list_data');
        Route::post('/update', 'LogBookController@update')->name('update');
        Route::post('/delete', 'LogBookController@destroy')->name('delete');
        Route::post('/getCurrentStock', 'LogBookController@getCurrentStock')->name('current.stock');
    });

    //Repairs
    Route::prefix('/repairs')->name('repairs.')->group(function () {
        Route::get('/', 'RepairsController@index')->name('index');
        Route::post('/store', 'RepairsController@store')->name('store');
        Route::get('/list_data', 'RepairsController@list_data')->name('list_data');
        Route::post('/update', 'RepairsController@update')->name('update');
        Route::post('/delete', 'RepairsController@destroy')->name('delete');
    });

    // lobriant
    Route::prefix('/lobriant')->name('lobriant.')->group(function () {
        Route::get('/', 'FuelOilController@index')->name('index');
        Route::get('/list_data', 'FuelOilController@list_data')->name('list_data');
        Route::post('/store', 'FuelOilController@store')->name('store');


    });

    //Rental Car
    Route::prefix('/rentalcar')->name('rentalcar.')->group(function () {
        Route::get('/', 'RentalCarController@index')->name('index');
        Route::get('/list_data', 'RentalCarController@list_data')->name('list_data');
        Route::post('/store', 'RentalCarController@store')->name('store');
        Route::post('/update', 'RentalCarController@update')->name('update');
        Route::post('/delete', 'RentalCarController@destroy')->name('delete');
    });

});

Route::group(['middleware' => 'auth', 'namespace' => 'v2'], function () {

});

//========================== reports================================
//    employee_reports
Route::get('report/employee/{org_code?}', 'ReportController@employee_report')->name('report.employee');

//    driver_report
Route::get('report/driver/{org_code?}', 'ReportController@driver_report')->name('report.driver');

//   repairs Report

Route::get('report/repairs', 'ReportController@repairs')->name('report.repairs');

Route::get('report/repairs_report_print', 'ReportController@repairs_report_print')->name('report.repairs_report_print');

//Lubricant Report

Route::get('report/lubricant', 'ReportController@lubricant')->name('report.lubricant');
Route::get('report/lubricant_report_print', 'ReportController@lubricant_report_print')->name('report.lubricant_report_print');

//Useless car report

Route::get('report/useless', 'ReportController@useless')->name('report.useless');
Route::get('report/useless_report_print/{from?}/{to?}/{org_code?}', 'ReportController@useless_report_print')->name('report.useless_report_print');

//Rental Car Report
Route::get('report/rentalcar', 'ReportController@rentalcar')->name('report.rentalcar');
Route::get('report/rentalcar_report_print/', 'ReportController@rentalcar_report_print')->name
('report.rentalcar_report_print');

//log book Report

Route::get('report/log_book', 'ReportController@log_book')->name('report.log_book');
Route::get('report/log_book_report_print/{from?}/{to?}/{org_code?}', 'ReportController@log_book_report_print')->name('report.log_book_report_print');

