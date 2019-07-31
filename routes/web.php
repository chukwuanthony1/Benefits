<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/userhome', 'HomeController@userHome')->name('user.home');
Route::get('/userprofile', 'HomeController@userProfile')->name('user.profile');
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::match(['get', 'post'], 'logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::get('user/registration', 'Auth\RegisterController@showUserRegistrationForm')->name('user.register');
Route::get('staffreg/{company_code}', 'Auth\RegisterController@showUserRegistrationForm')->name('staff.register');
Route::post('register', 'Auth\RegisterController@register');
// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::get('/user/verify/{token}', 'Auth\LoginController@verifyUser');

//utility route
Route::get('/utitility/countries', 'UtitlityController@getCountries')->name('countries.data');
Route::get('/utitility/getCountryStates', 'UtitlityController@getCountryStates')->name('getCountryStates.data');
Route::get('/utitility/cities', 'UtitlityController@getStateCities')->name('cities.data');
Route::match(['get', 'post'], '/utitility/getCoupon', 'UtitlityController@getMerchantCoupon')->name('merchant.coupon');


Route::group(['middleware' => ['auth']], function(){
	
	//admin routes
	Route::get('/admin/dashboard', 'Admin\HomeController@index')->name('admin.dashboard');
	Route::get('/admin/profile', 'Admin\HomeController@profile')->name('admin.profile');
	Route::get('/admin/adminusers', 'Admin\UsersController@adminUsers')->name('admin.adminusers');
	Route::get('/admin/approvedmerchants', 'Admin\UsersController@approvedMerchants')->name('admin.approvedmerchants');
	Route::get('/admin/pendingmerchants', 'Admin\UsersController@pendingMerchants')->name('admin.pendingmerchants');
	Route::get('/admin/approvedcompanies', 'Admin\UsersController@approvedCompanies')->name('admin.approvedcompanies');
	Route::get('/admin/pendingcompanies', 'Admin\UsersController@pendingCompanies')->name('admin.pendingcompanies');
	Route::match(['get', 'post'], '/admin/view-merchant/{id}', 'Admin\UsersController@adminViewMerchant')->name('admin.merchant.view');
	Route::match(['get', 'post'], '/admin/update-merchant/{id}', 'Admin\UsersController@adminUpdateMerchant');

	Route::match(['get', 'post'], '/admin/view-company/{id}', 'Admin\UsersController@adminViewCompany')->name('admin.company.view');
	Route::match(['get', 'post'], '/admin/update-company/{id}', 'Admin\UsersController@adminUpdateCompany');


	Route::get('/admin/categories', 'Admin\CategoriesController@index')->name('admin.categories');
	Route::match(['get', 'post'], '/admin/categories/new', 'Admin\CategoriesController@addCategory')->name('admin.category.new');
	Route::match(['get', 'post'], '/admin/edit-category/{id}', 'Admin\CategoriesController@editCategory');
	Route::match(['get', 'post'], '/admin/delete-category/{id}', 'Admin\CategoriesController@deleteCategory');

	Route::match(['get', 'post'], '/admin/deactive-user/{id}', 'Admin\UsersController@deactivateUser');
	Route::match(['get', 'post'], '/admin/active-user/{id}', 'Admin\UsersController@activateUser');

	Route::match(['get', 'post'], '/admin/products/approved', 'Admin\ProductsController@approvedProducts')->name('admin.products.approved');
	Route::match(['get', 'post'], '/admin/products/pending', 'Admin\ProductsController@pendingProducts')->name('admin.products.pending');
	Route::match(['get', 'post'], '/admin/view-product/{id}', 'Admin\ProductsController@adminViewProduct')->name('admin.product.view');
	Route::match(['get', 'post'], '/admin/update-product/{id}', 'Admin\ProductsController@adminUpdateProduct');


	//merchant routes
	Route::get('/merchant/dashboard', 'Merchant\HomeController@index')->name('merchants.dashboard');
	Route::get('/merchant/profile', 'Merchant\HomeController@profile')->name('merchant.profile');
	Route::get('/merchant/products', 'Merchant\ProductsController@merchantProducts')->name('merchant.products');
	Route::match(['get', 'post'], '/merchant/products/new', 'Merchant\ProductsController@merchantAddProduct')->name('merchant.product.new');
	Route::match(['get', 'post'], '/merchant/edit-product/{id}', 'Merchant\ProductsController@merchantEditProduct');
	Route::match(['get', 'post'], '/merchant/delete-product/{id}', 'Merchant\ProductsController@merchantDeleteProduct');
	Route::match(['get', 'post'], '/merchant/delete-productImg/{id}/{product_id}', 'Merchant\ProductsController@merchantDeleteProductImage');
	Route::get('/merchant/coupons', 'Merchant\CouponsController@merchantCoupons')->name('merchant.coupons');
	Route::match(['get', 'post'], '/merchant/coupon/new', 'Merchant\CouponsController@merchantAddCoupon')->name('merchant.coupon.new');


	//company routes
	Route::get('/company/dashboard', 'Company\HomeController@index')->name('company.dashboard');
	Route::get('/company/profile', 'Company\HomeController@profile')->name('company.profile');
	Route::get('/company/employees', 'Company\EmployeeController@companyEmployee')->name('company.employees');
	Route::match(['get', 'post'], '/company/employee/new', 'Company\EmployeeController@companyAddEmployee')->name('company.employee.new');
	Route::match(['get', 'post'],'/company/employees/upload', 'Company\EmployeeController@companyUploadEmployee')->name('company.employees.upload');
	Route::get('/company/invites', 'Company\CompanyInvitesController@index')->name('company.invites');
	Route::match(['get', 'post'],'/company/invites/add', 'Company\CompanyInvitesController@newInvites')->name('company.invites.new');


	//staff routes
	Route::get('/benefit/home', 'Staff\HomeController@index')->name('benefit.home');
	Route::match(['get', 'post'], '/benefit/profile', 'Staff\HomeController@profile')->name('benefit.profile');
	Route::match(['get', 'post'], '/category/product-list/{alias}', 'Staff\ProductsController@viewCatProducts');

	//Route::match(['get', 'post'], '/product/details/{catid}/{alias}', 'Staff\ProductsController@viewCategoryProduct');

	Route::match(['get', 'post'], '/product/details/{alias}', 'Staff\ProductsController@viewProduct');

	//Route::match(['get', 'post'], '/search/details', 'SearchController@index')->name('search');

	//datatable routes
	//all datatable routes
	// Route::get('/admin/report', 'CategoryController@addCategory')->name('admin.report');
	Route::match(['get', 'post'], '/category/data', 'Admin\CategoriesController@categoryData')->name('category.data');
	Route::match(['get', 'post'], '/merchant/data', 'Admin\UsersController@merchantData')->name('merchants.data');
	Route::match(['get', 'post'], '/admin/data', 'Admin\UsersController@adminData')->name('adminusers.data');
	Route::match(['get', 'post'],'/company/data', 'Admin\UsersController@companyData')->name('companies.data');
	Route::match(['get', 'post'],'/company/pending/data', 'Admin\UsersController@pendingCompanyData')->name('pending.companies.data');
	Route::match(['get', 'post'],'/merchant/pending/data', 'Admin\UsersController@pendingMerchantData')->name('pending.merchants.data');
	// Route::post('/admin/data', 'Admin\UsersController@adminData')->name('adminusers.data');
	// Route::post('/product/data', 'ProductsController@productData')->name('product.data');
	// Route::post('/brand/data', 'BrandsController@brandData')->name('brand.data');
	// Route::post('/model/data', 'ModelsController@modelData')->name('model.data');
	Route::match(['get', 'post'], '/product/merchantdata', 'Merchant\ProductsController@merchantProductData')->name('product.merchant.data');
	Route::match(['get', 'post'], '/coupon/merchantdata', 'Merchant\CouponsController@merchantCouponData')->name('coupon.merchant.data');
	Route::match(['get', 'post'], '/product/pendingProductData', 'Admin\ProductsController@pendingProductData')->name('product.pending.data');
	Route::match(['get', 'post'], '/product/approvedProductData', 'Admin\ProductsController@approvedProductData')->name('product.approved.data');

	Route::match(['get', 'post'], '/company/companyEmployeeData', 'Company\EmployeeController@companyEmployeeData')->name('company.employees.data');
	// Route::post('/orders/data', 'OrdersController@orderData')->name('orders.data');
	// Route::match(['get', 'post'], '/customer/orders/data', 'CustomerController@customerOrderData')->name('customer.orders.data');
	// Route::post('/customers/data', 'CustomerController@customerData')->name('customers.data');
});