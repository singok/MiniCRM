<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*--------------------Company Controller---------------------*/
Route::controller(CompanyController::class)->prefix('dashboard/companies')->group(function () {
    Route::get('/', 'index')->name('companies.list');
    Route::post('add-company', 'store')->name('companies.add');
    Route::post('districts', 'loadDistricts')->name('companies.districts');
    Route::post('vdcormunicipality', 'loadVdc')->name('companies.vdcormunicipality');
    Route::get('table/load', 'show')->name('companies.loadtable');
    Route::post('company/delete', 'destroy')->name('companies.delete');
    Route::post('company/edit', 'edit')->name('companies.edit');
});

/*---------------------Employee Controller-------------------*/
Route::controller(EmployeeController::class)->prefix('dashboard/employees')->group(function () {
    Route::get('/', 'index')->name('emloyees.list');
    Route::post('add', 'store')->name('employees.store');
    Route::get('load', 'show')->name('employees.load');
    Route::post('remove', 'destroy')->name('employee.remove');
    Route::post('edit', 'edit')->name('employee.edit');
});

Route::controller(ProfileController::class)->prefix('dashboard/profile')->group(function () {
    Route::get('/', 'index')->name('profile.index');
    Route::post('password/check', 'check')->name('profile-password.check');
    Route::post('password/update', 'update')->name('profile.update');
});
