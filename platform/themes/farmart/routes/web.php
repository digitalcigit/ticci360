<?php

use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;
use Theme\Farmart\Http\Controllers\FarmartController;

Route::group(['controller' => FarmartController::class, 'middleware' => ['web', 'core']], function () {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        Route::group(['prefix' => 'ajax', 'as' => 'public.ajax.'], function () {
            Route::get('search-products', [
                'uses' => 'ajaxSearchProducts',
                'as' => 'search-products',
            ]);

            Route::get('products', [
                'uses' => 'ajaxGetProducts',
                'as' => 'products',
            ]);

            Route::get('featured-product-categories', [
                'uses' => 'ajaxGetFeaturedProductCategories',
                'as' => 'featured-product-categories',
            ]);

            Route::get('featured-brands', [
                'uses' => 'ajaxGetFeaturedBrands',
                'as' => 'featured-brands',
            ]);

            Route::get('get-flash-sale/{id}', [
                'uses' => 'ajaxGetFlashSale',
                'as' => 'get-flash-sale',
            ])->wherePrimaryKey();

            Route::get('product-categories/products', [
                'uses' => 'ajaxGetProductsByCategoryId',
                'as' => 'product-category-products',
            ]);

            Route::get('featured-products', [
                'uses' => 'ajaxGetFeaturedProducts',
                'as' => 'featured-products',
            ]);

            Route::get('cart', [
                'uses' => 'ajaxCart',
                'as' => 'cart',
            ]);

            Route::get('quick-view/{id?}', [
                'uses' => 'ajaxGetQuickView',
                'as' => 'quick-view',
            ])->wherePrimaryKey();

            Route::post('add-to-wishlist/{id?}', [
                'uses' => 'ajaxAddProductToWishlist',
                'as' => 'add-to-wishlist',
            ])->wherePrimaryKey();

            Route::get('related-products/{id}', [
                'uses' => 'ajaxGetRelatedProducts',
                'as' => 'related-products',
            ])->wherePrimaryKey();

            Route::get('product-reviews/{id}', [
                'uses' => 'ajaxGetProductReviews',
                'as' => 'product-reviews',
            ])->wherePrimaryKey();

            Route::get('get-product-categories', [
                'uses' => 'ajaxGetProductCategories',
                'as' => 'get-product-categories',
            ]);

            Route::get('recently-viewed-products', [
                'uses' => 'ajaxGetRecentlyViewedProducts',
                'as' => 'recently-viewed-products',
            ]);

            Route::post('ajax/contact-seller', 'ajaxContactSeller')
                ->name('contact-seller');
        });
    });
});

Theme::routes();
