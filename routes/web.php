<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/layout', function () {
    return view('layout');
});
Route::get('/about-us', function () {
    return view('about-us');
});
Route::get('/FAQ', function () {
    return view('FAQ');
});
Route::get('/retour', function () {
    return view('retour');
});
Route::get('/politique', function () {
    return view('politique');
});