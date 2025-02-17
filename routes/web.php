<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;



Route::get('/',[ContactController::class ,'index'])->name('load');
Route::post('/upload',[ContactController::class ,'uploadXmlFile'])->name('upload');
Route::get('/upload-data/{id}',[ContactController::class ,'uploadData']);
Route::post('/update-contact/{id}',[ContactController::class ,'updateContact'])->name('updateContact');
Route::Delete('/update-delete/{id}',[ContactController::class ,'destroy']);
Route::post('/add-contact',[ContactController::class ,'addContact'])->name('addContact');
