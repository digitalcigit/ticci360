<?php

use Botble\Base\Facades\AdminHelper;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function (): void {
    Route::group(['namespace' => 'Botble\Sitemap\Http\Controllers'], function (): void {
        Route::group(['prefix' => 'settings'], function (): void {
            Route::group(['prefix' => 'sitemap', 'as' => 'sitemap.', 'permission' => 'sitemap.settings'], function (): void {
                Route::get('/', [
                    'as' => 'settings',
                    'uses' => 'SitemapSettingController@edit',
                ]);

                Route::put('/', [
                    'as' => 'settings.update',
                    'uses' => 'SitemapSettingController@update',
                    'permission' => 'sitemap.settings',
                ]);
            });
        });
    });
});
