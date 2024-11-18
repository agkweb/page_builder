<?php

use App\Http\Controllers\Home\CategoryController;
use App\Http\Controllers\Home\PageController;
use App\Http\Controllers\Home\RegistrationController;
use App\Http\Controllers\Home\SurveyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout.main');
});
Route::get('/surveys/{survey}/questions', [SurveyController::class, 'getQuestions']);

// PAGES
Route::get('pagesSearch', [PageController::class , 'search'])->name('pages.search');
Route::resource('pages', PageController::class);
Route::get('pagesSearchFromTrash', [PageController::class , 'searchFromTrash'])->name('pages.searchFromTrash');
Route::prefix('pages/')->name('pages.')->group(function (){
    Route::post('upload/images', [PageController::class, 'upload']);
    Route::get('trash', [PageController::class , 'trash'])->name('trash');
    Route::get('export/{page}', [PageController::class , 'export'])->name('export');
    Route::post('export/{page}', [PageController::class , 'exportInExcel'])->name('exportInExcel');
    Route::post('{page}/restore', [PageController::class , 'restore'])->name('restore');
});

// REGISTRATIONS
Route::get('registrationsSearch', [RegistrationController::class , 'search'])->name('registrations.search');
Route::resource('registrations', RegistrationController::class);

// CATEGORIES
Route::get('categoriesSearch', [CategoryController::class , 'search'])->name('categories.search');
Route::resource('categories', CategoryController::class);
Route::get('categoriesSearchFromTrash', [CategoryController::class , 'searchFromTrash'])->name('categories.searchFromTrash');
Route::prefix('categories/')->name('categories.')->group(function (){
    Route::get('trash', [CategoryController::class , 'trash'])->name('trash');
    Route::post('{category}/restore', [CategoryController::class , 'restore'])->name('restore');
});

// SURVEYS
Route::get('surveySearch', [SurveyController::class , 'search'])->name('surveys.search');
Route::resource('surveys', SurveyController::class);
Route::get('surveysSearchFromTrash', [SurveyController::class , 'searchFromTrash'])->name('surveys.searchFromTrash');
Route::prefix('surveys/')->name('surveys.')->group(function (){
    Route::post('add_phoneNumber', [SurveyController::class , 'add_phoneNumber'])->name('add_phoneNumber');
    Route::get('trash', [SurveyController::class , 'trash'])->name('trash');
    Route::post('{survey}/restore', [SurveyController::class , 'restore'])->name('restore');
    Route::get('editQuestions/{survey}', [SurveyController::class , 'editQuestions'])->name('editQuestions');
    Route::get('preview/{survey}', [SurveyController::class , 'preview'])->name('preview');
    Route::get('export/{survey}', [SurveyController::class , 'export'])->name('export');
    Route::post('export/{survey}', [SurveyController::class , 'exportInExcel'])->name('exportInExcel');
});

Route::post('/submit-survey', [SurveyController::class , 'save'])->name('surveys.save');
