<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/admins/{any?}', function () {
    return view('admin');
})->where('any', '.*');
