<?php

use Botble\Base\Facades\AdminHelper;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function (): void {
    Route::group(['namespace' => 'Botble\Optimize\Http\Controllers'], function (): void {
        Route::group(['prefix' => 'settings'], function (): void {
            Route::group(['prefix' => 'optimize', 'as' => 'optimize.', 'permission' => 'optimize.settings'], function (): void {
                Route::get('/', [
                    'as' => 'settings',
                    'uses' => 'Settings\OptimizeSettingController@edit',
                ]);

                Route::put('/', [
                    'as' => 'settings.update',
                    'uses' => 'Settings\OptimizeSettingController@update',
                    'permission' => 'optimize.settings',
                ]);
            });
        });
    });
});
