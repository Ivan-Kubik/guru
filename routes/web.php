<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'Home\MainController@index')->name('site.main');

Auth::routes();

Route::get('/author', 'Catalog\UserController@index')->name('site.author.list');
Route::get('/organizer', 'Catalog\UserController@organizer')->name('site.organizer.list');
Route::get('/author/{id}', 'Catalog\UserController@show')->name('site.author.show');
Route::post('/author/add/comment/{id}', 'Catalog\UserController@addCommentToAuthor')->name('site.author.add_comment');

Route::resource('events', 'Catalog\TourController')->only('show')->names('site.catalog.tour');

Route::get('/category', 'Catalog\CategoryTourController@index')->name('site.catalog.category.list');
Route::get('/category/{id}', 'Catalog\CategoryTourController@show')->name('site.catalog.category.name');

Route::resource('/tag', 'Catalog\TagController')->only('show')->names('site.catalog.tag');

Route::resource('/journal', 'Journal\BlogController')->only(['index', 'show'])->names('site.journal.blog');

Route::resource('/page', 'Pages\PageController')->only('show')->names('site.pages.official');

Route::match(['post', 'get'], '/search', 'Catalog\SearchController@index')->name('site.catalog.search');
Route::get('/help', 'HelpController@show')->name('site.help.show');

Route::get('add-advert', 'Landing\LandingPageController@index')->name('site.landing');
Route::get('about-us', 'Pages\AboutController@show')->name('site.about');

Route::prefix('cabinet')->middleware('auth')->group(function (){
    Route::get('', function (){ return redirect()->route('site.cabinet.user.index'); });

    Route::resource('/user', 'Cabinet\HomeController')->only(['index', 'edit', 'update'])->names('site.cabinet.user');
    Route::resource('/purchases', 'Cabinet\PurchasesController')->only('index')->names('site.cabinet.purchases');
    Route::get('request-auth', 'Cabinet\SettingsController@request_auth')->name('site.cabinet.request_auth');

    Route::group(['middleware' => ['cabinet_auth']], function (){
        Route::resource('/tour', 'Cabinet\TourController')->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])->names('site.cabinet.tour');
        Route::resource('/leaders', 'Cabinet\LeaderController')->except('show')->names('site.cabinet.leaders');
        Route::resource('/messages', 'Cabinet\MessageController')->only(['index', 'destroy'])->names('site.cabinet.message');
        Route::resource('/reviews', 'Cabinet\ReviewController')->only(['index', 'edit', 'destroy', 'update'])->names('site.cabinet.review');
        Route::resource('/video', 'Cabinet\VideoController')->only(['index', 'store', 'destroy'])->names('site.cabinet.video');

        Route::prefix('ajax')->group(function (){
            Route::post('general-gallery-insert', 'Cabinet\TourController@ajax_general_gallery_insert')->name('site.ajax.general.gallery.insert');
            Route::post('general-accommodation-insert', 'Cabinet\TourController@ajax_accommodation_gallery_insert')->name('site.ajax.accommodation.gallery.insert');
            Route::post('general-meals-insert', 'Cabinet\TourController@ajax_meals_gallery_insert')->name('site.ajax.meals.gallery.insert');

            Route::post('ajax-gallery-remove', 'Cabinet\TourController@ajax_gallery_remove')->name('site.ajax.gallery.remove');

            Route::post('ajax-gallery-author-remove', 'Cabinet\LeaderController@ajax_gallery_remove')->name('site.ajax.gallery.author.remove');
        });
    });


});

Route::get('/delete-variant-tour/{id}', 'Cabinet\AjaxController@remove_variant_tour')->middleware('auth');
Route::post('/delete-img-gallery-author', 'Cabinet\AjaxController@remove_img_gallery_author')->middleware('auth');

Route::post('/tour-rating-estimate', 'Catalog\TourRatingController@estimate')->name('site.tour.rating.estimate');
Route::post('/send-message', 'Cabinet\MessageController@store')->name('site.send-message-to-leader');

Route::prefix('payment')->group(function (){
//    Route::get('handler', 'Payment\UnitPayController@handler')->name('unitpay.handler');
    Route::post('customer-pays', 'Payment\PayController@store')->name('customer.pays');
    // обработчик после оплаты
    Route::post('handler-from-pay-system', 'Payment\PayController@handler_from_pay_system')->name('customer.paid');
    Route::get('order-before-pay/{id}', 'Payment\PayController@show')->name('customer.order.show');
});

if (env('APP_DEBUG') == 'true'){
    Route::prefix('test')->group(function (){
        Route::get('phpinfo', 'Tests\InfoController@index');
        Route::get('pay', 'Tests\InfoController@pay');
        Route::get('pay-handler', 'Tests\InfoController@pay_handler');
    });
}


