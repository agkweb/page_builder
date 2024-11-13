<?php

use App\Http\Controllers\Home\CategoryController;
use App\Http\Controllers\Home\PageController;
use App\Http\Controllers\Home\RegistrationController;
use App\Http\Controllers\Home\SurveyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout.main');
});

Route::post('pages/upload/images', [PageController::class, 'upload']);
Route::get('pagesSearch', [PageController::class , 'search'])->name('pages.search');
Route::get('pages/trash', [PageController::class , 'trash'])->name('pages.trash');
Route::get('pages/export/{page}', [PageController::class , 'export'])->name('pages.export');
Route::post('pages/export/{page}', [PageController::class , 'exportInExcel'])->name('pages.exportInExcel');
Route::resource('pages', PageController::class);
Route::post('pages/{page}/restore', [PageController::class , 'restore'])->name('pages.restore');
Route::get('pagesSearchFromTrash', [PageController::class , 'searchFromTrash'])->name('pages.searchFromTrash');

Route::get('surveySearch', [SurveyController::class , 'search'])->name('surveys.search');
Route::get('surveys/trash', [SurveyController::class , 'trash'])->name('surveys.trash');
Route::get('surveys/export/{survey}', [SurveyController::class , 'export'])->name('surveys.export');
Route::post('surveys/export/{survey}', [SurveyController::class , 'exportInExcel'])->name('surveys.exportInExcel');
Route::resource('surveys', SurveyController::class);
Route::post('surveys/{survey}/restore', [SurveyController::class , 'restore'])->name('surveys.restore');
Route::get('surveysSearchFromTrash', [SurveyController::class , 'searchFromTrash'])->name('surveys.searchFromTrash');

Route::get('registrationsSearch', [RegistrationController::class , 'search'])->name('registrations.search');
Route::resource('registrations', RegistrationController::class);

Route::get('categoriesSearch', [CategoryController::class , 'search'])->name('categories.search');
Route::get('categories/trash', [CategoryController::class , 'trash'])->name('categories.trash');
Route::resource('categories', CategoryController::class);
Route::post('categories/{category}/restore', [CategoryController::class , 'restore'])->name('categories.restore');
Route::get('categoriesSearchFromTrash', [CategoryController::class , 'searchFromTrash'])->name('categories.searchFromTrash');
