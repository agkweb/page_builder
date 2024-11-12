<?php

use App\Http\Controllers\Home\CategoryController;
use App\Http\Controllers\Home\PageController;
use App\Http\Controllers\Home\RegistrationController;
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

Route::get('registrationsSearch', [RegistrationController::class , 'search'])->name('registrations.search');
Route::resource('registrations', RegistrationController::class);

Route::get('categoriesSearch', [CategoryController::class , 'search'])->name('categories.search');
Route::get('categories/trash', [CategoryController::class , 'trash'])->name('categories.trash');
Route::resource('categories', CategoryController::class);
Route::post('categories/{category}/restore', [CategoryController::class , 'restore'])->name('categories.restore');
Route::get('categoriesSearchFromTrash', [CategoryController::class , 'searchFromTrash'])->name('categories.searchFromTrash');
