<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



// Route::post('register', 'api\AuthController@register');
Route::post('login', 'api\AuthController@login');


Route::group(['middleware' => 'auth.jwt'], function () {
 	Route::get('me', 'api\AuthController@me');
    Route::get('user', 'api\AuthController@ume');
 	Route::post('logout', 'api\AuthController@logout');
	Route::post('refresh', 'api\AuthController@refresh');

	Route::get('/merchants', 'api\ProductController@getMerchants');
	Route::get('/categories', 'api\CategoryController@getCategories');
	Route::get('/products', 'api\ProductController@getProducts');
	Route::get('/randomProducts', 'api\ProductController@getRandomProducts');
	Route::get('/subcategories', 'api\CategoryController@getSubCategories');
	Route::get('/catProducts/{alias}', 'api\CategoryController@getCategoryProducts');
	Route::get('/utitility/countries', 'UtitlityController@getCountries')->name('countries.data');
	Route::get('/utitility/getCountryStates', 'UtitlityController@getCountryStates')->name('getCountryStates.data');
	Route::get('/utitility/cities', 'UtitlityController@getStateCities')->name('cities.data');
	Route::match(['get', 'post'], '/utitility/getCoupon', 'UtitlityController@getMerchantCoupon')->name('merchant.coupon');
});

// // Route::middleware('auth:api')->get('/user', function (Request $request) {
// //     return $request->user();
// // });


// Route::group(['middleware' => 'auth:api'], function () {
// 	//Route::post('/short', 'UrlMapperController@store');
// 	//Route::post('login', 'api\AuthController@login');
//     Route::post('logout', 'api\AuthController@logout');
//     Route::post('refresh', 'api\AuthController@refresh');
//     Route::get('me', 'api\AuthController@me');
// });
