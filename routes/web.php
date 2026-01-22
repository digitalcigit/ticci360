<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/enable-api', function () {
    try {
        Botble\Setting\Facades\Setting::set('api_enabled', 1);
        Botble\Setting\Facades\Setting::save();
        return 'API enabled successfully';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
