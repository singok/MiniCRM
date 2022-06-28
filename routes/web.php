<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;

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
});
