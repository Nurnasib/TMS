<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('{any}', function () {
    return view('welcome');  // The Blade view where Vue is mounted
})->where('any', '.*');
