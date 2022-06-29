<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*--------------------Company Controller---------------------*/
Route::controller(CompanyController::class)->prefix('admin/companies')->group(function () {
    Route::get('/', 'index')->name('companies.list');
    Route::post('add-company', 'store')->name('companies.add');
    Route::post('districts', 'loadDistricts')->name('companies.districts');
    Route::post('vdcormunicipality', 'loadVdc')->name('companies.vdcormunicipality');
    Route::post('table/load', 'show')->name('companies.loadtable');
    Route::post('company/delete', 'destroy')->name('companies.delete');
    Route::post('company/edit', 'edit')->name('companies.edit');
});

/*---------------------Employee Controller-------------------*/
Route::controller(EmployeeController::class)->prefix('admin/employees')->group(function () {
    Route::get('/', 'index')->name('emloyees.list');
    Route::post('add', 'store')->name('employees.store');
    Route::post('load', 'show')->name('employees.load');
    Route::post('remove', 'destroy')->name('employee.remove');
    Route::post('edit', 'edit')->name('employee.edit');
});
