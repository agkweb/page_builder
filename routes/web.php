<?php

use App\Http\Controllers\Home\CategoryController;
use App\Http\Controllers\Home\PageController;
use App\Http\Controllers\Home\QuizController;
use App\Http\Controllers\Home\RegistrationController;
use App\Http\Controllers\Home\SurveyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout.main');
});
Route::get('/surveys/{survey}/questions', [SurveyController::class, 'getQuestions']);
Route::post('/validate-browser', [SurveyController::class, 'validateBrowser']);

// PAGES
Route::get('pagesSearch', [PageController::class , 'search'])->name('pages.search');
Route::resource('pages', PageController::class);
Route::get('pagesSearchFromTrash', [PageController::class , 'searchFromTrash'])->name('pages.searchFromTrash');
Route::prefix('pages/')->name('pages.')->group(function (){
    Route::get('chart/registrations', [PageController::class , 'chart'])->name('chart');
    Route::post('upload/images', [PageController::class, 'upload']);
    Route::get('trash', [PageController::class , 'trash'])->name('trash');
    Route::get('export/{page}', [PageController::class , 'export'])->name('export');
    Route::post('export/{page}', [PageController::class , 'exportInExcel'])->name('exportInExcel');
    Route::post('{page}/restore', [PageController::class , 'restore'])->name('restore');
});

// REGISTRATIONS
Route::get('registrationsSearch', [RegistrationController::class , 'search'])->name('registrations.search');
Route::post('registrations/storePhoneNumber', [RegistrationController::class , 'storePhoneNumber'])->name('registrations.storePhoneNumber');
Route::get('registrations/storeData', [RegistrationController::class , 'storeData'])->name('registrations.storeData');
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
    Route::get('edit_question/{question}', [SurveyController::class , 'edit_question'])->name('edit_question');
    Route::put('update_question/{question}', [SurveyController::class , 'update_question'])->name('update_question');
    Route::get('delete_question/{question}', [SurveyController::class , 'delete_question'])->name('delete_question');
    Route::get('delete_answer/{answer}', [SurveyController::class , 'delete_answer'])->name('delete_answer');
    Route::post('add_phoneNumber', [SurveyController::class , 'add_phoneNumber'])->name('add_phoneNumber');
    Route::get('trash', [SurveyController::class , 'trash'])->name('trash');
    Route::post('{survey}/restore', [SurveyController::class , 'restore'])->name('restore');
    Route::get('editQuestions/{survey}', [SurveyController::class , 'editQuestions'])->name('editQuestions');
    Route::get('preview/{survey:slug}', [SurveyController::class , 'preview'])->name('preview');
    Route::get('export/{survey}', [SurveyController::class , 'export'])->name('export');
    Route::post('export/{survey}', [SurveyController::class , 'exportInExcel'])->name('exportInExcel');
});

Route::post('/submit-survey', [SurveyController::class , 'save'])->name('surveys.save');

// QUIZZES
//Route::get('quizSearch', [QuizController::class , 'search'])->name('quizzes.search');
//Route::resource('quizzes', QuizController::class);
//Route::get('quizSearchFromTrash', [QuizController::class , 'searchFromTrash'])->name('quizzes.searchFromTrash');
//Route::prefix('quizzes/')->name('quizzes.')->group(function (){
//    Route::get('edit_question/{quiz_question}', [QuizController::class , 'edit_question'])->name('edit_question');
//    Route::put('update_question/{quiz_question}', [QuizController::class , 'update_question'])->name('update_question');
//    Route::get('delete_question/{quiz_question}', [QuizController::class , 'delete_question'])->name('delete_question');
//    Route::get('delete_answer/{quiz_option}', [QuizController::class , 'delete_option'])->name('delete_option');
//    Route::get('trash', [QuizController::class , 'trash'])->name('trash');
//    Route::post('{quiz}/restore', [QuizController::class , 'restore'])->name('restore');
//    Route::get('editQuestions/{quiz}', [QuizController::class , 'editQuestions'])->name('editQuestions');
//    Route::get('preview/{quiz:slug}', [QuizController::class , 'preview'])->name('preview');
//    Route::get('export/{quiz}', [QuizController::class , 'export'])->name('export');
//    Route::post('export/{quiz}', [QuizController::class , 'exportInExcel'])->name('exportInExcel');
//});
