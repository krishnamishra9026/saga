<?php
$locale = Request::segment(1);
if(isset($locale)){
	$locale = Request::segment(1);
}else{
	$locale = 'ar-SA';
}

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
});


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These 
| routes are loaded by the RouteServiceProvider within a group which 
| contains the "web" middleware group. Now create something great!
|
*/

/*Admin Panel*/
    Route::get('/check-user-registration-email', function () {
            return view('Mail/admin_order_mail');
        });
  
Route::get('/backend/Login', ['as' => 'AdminLogin', 'uses' => 'Admin\LoginController@Login']);
Route::post('/backend/AdminLoginValidate', ['as' => 'AdminLoginValidate', 'uses' => 'Admin\LoginController@AdminLoginValidate']);
Route::post('/backend/CheckResetPassword', ['as' => 'CheckResetPassword', 'uses' => 'Admin\LoginController@CheckResetPassword']);

Route::group(['namespace' => 'Admin', 'prefix' => 'backend', 'middleware'=>['IsAdminLogin']], function () {
    
Route::get('/dashboard', ['as' => 'Dashboard', 'uses' => 'DashboardController@Dashboard']);
Route::get('/Logout', ['as' => 'Logout', 'uses' => 'LoginController@Logout']);

Route::get('/setting',['as'=>'Setting','uses'=>'SettingController@Setting']);
Route::post('/UpdateSetting',['as'=>'UpdateSetting','uses'=>'SettingController@UpdateSetting']);
Route::post('/ChangePassword',['as'=>'ChangePassword','uses'=>'SettingController@ChangePassword']);
Route::post('/UpdateSocialMedia',['as'=>'UpdateSocialMedia','uses'=>'SettingController@UpdateSocialMedia']);
Route::post('/UpdatePagination',['as'=>'UpdatePagination','uses'=>'SettingController@UpdatePagination']);

Route::get('/user',['as'=>'User','uses'=>'UserController@List']);
Route::get('/add-user',['as'=>'AddUser','uses'=>'UserController@Add']);
Route::get('/edit-user/{id}',['as'=>'EditUser','uses'=>'UserController@Edit']);
Route::post('/UserListing',['as'=>'UserListing','uses'=>'UserController@UserListing']);
Route::post('/UserChangeStatus',['as'=>'UserChangeStatus','uses'=>'UserController@ChangeStatus']);
Route::post('/InsertUser',['as'=>'InsertUser','uses'=>'UserController@InsertUser']);
Route::post('/SaveUser',['as'=>'SaveUser','uses'=>'UserController@SaveUser']);
Route::post('/CheckAdminUserName',['as'=>'CheckAdminUserName','uses'=>'UserController@CheckAdminUserName']);
Route::post('/CheckAdminEmail',['as'=>'CheckAdminEmail','uses'=>'UserController@CheckAdminEmail']);
Route::post('/CheckAdminMobile',['as'=>'CheckAdminMobile','uses'=>'UserController@CheckAdminMobile']);
Route::post('/CheckAdminSponsor',['as'=>'CheckAdminSponsor','uses'=>'UserController@CheckAdminSponsor']);
Route::post('/CheckAdminPCode',['as'=>'CheckAdminPCode','uses'=>'UserController@CheckAdminPCode']);


Route::get('/menu',['as'=>'Menu','uses'=>'MenuController@Menu']);
Route::get('/add-menu',['as'=>'AddMenu','uses'=>'MenuController@AddMenu']);
Route::post('/InsertMenu',['as'=>'InsertMenu','uses'=>'MenuController@InsertMenu']);
Route::post('/SaveMenu',['as'=>'SaveMenu','uses'=>'MenuController@SaveMenu']);
Route::post('/CheckMenuDetails',['as'=>'CheckMenuDetails','uses'=>'MenuController@CheckMenuDetails']);
Route::get('/MenuList',['as'=>'MenuList','uses'=>'MenuController@ProductList']);
Route::post('/MenuChangeStatus',['as'=>'MenuChangeStatus','uses'=>'MenuController@MenuChangeStatus']);
Route::post('/MenuChangeFeatured',['as'=>'MenuChangeFeatured','uses'=>'MenuController@MenuChangeFeatured']);
Route::get('/edit-menu/{id}',['as'=>'EditMenu','uses'=>'MenuController@EditMenu']);
Route::get('/delete-menu/{id}',['as'=>'DeleteMenu','uses'=>'MenuController@DeleteMenu']);


Route::get('/pincode',['as'=>'Pincode','uses'=>'PincodeController@Menu']);
Route::get('/add-pincode',['as'=>'AddPincode','uses'=>'PincodeController@AddPincode']);
Route::post('/InsertPincode',['as'=>'InsertPincode','uses'=>'PincodeController@InsertPincode']);
Route::post('/SavePincode',['as'=>'SavePincode','uses'=>'PincodeController@SavePincode']);
Route::post('/CheckPincodeDetails',['as'=>'CheckPincodeDetails','uses'=>'PincodeController@CheckMenuDetails']);
Route::get('/PincodeList',['as'=>'PincodeList','uses'=>'PincodeController@ProductList']);
// Route::post('/MeChangeStatus',['as'=>'MenuChangeStatus','uses'=>'MenuController@MenuChangeStatus']);
// Route::post('/MenuChangeFeatured',['as'=>'MenuChangeFeatured','uses'=>'MenuController@MenuChangeFeatured']);
Route::get('/edit-pincode/{id}',['as'=>'EditPincode','uses'=>'PincodeController@EditPincode']);
Route::get('/delete-pincode/{id}',['as'=>'DeletePincode','uses'=>'PincodeController@DeletePincode']);





Route::get('/banner',['as'=>'Banner','uses'=>'BannerController@Banner']);
Route::get('/edit-banner/{id}',['as'=>'EditBanner','uses'=>'BannerController@EditBanner']);
Route::post('/SaveBanner',['as'=>'SaveBanner','uses'=>'BannerController@SaveBanner']);
Route::post('/InsertBanner',['as'=>'InsertBanner','uses'=>'BannerController@InsertBanner']);
Route::get('/add-banner',['as'=>'AddBanner','uses'=>'BannerController@AddBanner']);
Route::get('/delete-banner/{id}',['as'=>'DeleteBanner','uses'=>'BannerController@DeleteBanner']);

// Category urls

Route::get('/category',['as'=>'Category','uses'=>'CategoryController@Category']);
Route::get('/edit-category/{id}',['as'=>'EditCategory','uses'=>'CategoryController@EditCategory']);
Route::post('/SaveCategory',['as'=>'SaveCategory','uses'=>'CategoryController@SaveCategory']);
Route::get('/add-category',['as'=>'AddCategory','uses'=>'CategoryController@AddCategory']);
Route::post('/InsertCategory',['as'=>'InsertCategory','uses'=>'CategoryController@InsertCategory']);
Route::get('/delete-category/{id}',['as'=>'DeleteCategory','uses'=>'CategoryController@DeleteCategory']);
Route::get('/delete-Concern/{id}',['as'=>'DeleteConcern','uses'=>'CategoryController@DeleteConcern']);


Route::get('/add-category-in-sub-category/{id}',['as'=>'AddCategoryInSubCategory','uses'=>'CategoryController@AddCategoryInSubCategory']);
Route::get('/add-category-in-concern/{id}',['as'=>'AddCategoryInConcern','uses'=>'CategoryController@AddCategoryInConcern']);
Route::post('/Insert-concern-in-category',['as'=>'InsertConcernInCategory','uses'=>'CategoryController@InsertConcernInCategory']);

// Concern urls
Route::get('/concern',['as'=>'Concern','uses'=>'CategoryController@Concern']);
Route::get('/add-concern',['as'=>'AddConcern','uses'=>'CategoryController@AddConcern']);
Route::get('/edit-concern/{id}',['as'=>'EditConcern','uses'=>'CategoryController@EditConcern']);
Route::post('/InsertConcern',['as'=>'InsertConcern','uses'=>'CategoryController@InsertConcern']);
Route::post('/SaveConcern',['as'=>'SaveConcern','uses'=>'CategoryController@SaveConcern']);



// sub-category urls

Route::get('/sub-category',['as'=>'SubCategory','uses'=>'SubCategoryController@SubCategory']);
Route::get('/add-sub-category',['as'=>'AddSubCategory','uses'=>'SubCategoryController@AddSubCategory']);
Route::post('/InsertSubCategory',['as'=>'InsertSubCategory','uses'=>'SubCategoryController@InsertSubCategory']);
Route::get('/edit-sub-category/{id}',['as'=>'EditSubCategory','uses'=>'SubCategoryController@EditSubCategory']);
Route::post('/SaveSubCategory',['as'=>'SaveSubCategory','uses'=>'SubCategoryController@SaveSubCategory']);
Route::get('/delete-sub-category/{id}',['as'=>'DeleteSubCategory','uses'=>'SubCategoryController@DeleteSubCategory']);


//product url
Route::get('/product',['as'=>'Product','uses'=>'ProductItemsController@Product']);
Route::get('/add-product',['as'=>'AddProduct','uses'=>'ProductItemsController@AddProduct']);
Route::post('/Insert-product',['as'=>'InsertProduct','uses'=>'ProductItemsController@InsertProduct']);
Route::post('/product-slug',['as'=>'FetchproductListSlug','uses'=>'ProductItemsController@getproductListSlug']);
Route::get('/edit-product/{id}',['as'=>'EditProduct','uses'=>'ProductItemsController@EditProduct']);
Route::post('/save-product',['as'=>'SaveProduct','uses'=>'ProductItemsController@SaveProduct']);
Route::any('/fetch-sub-category-list',['as'=>'FetchSubCategoryList','uses'=>'ProductItemsController@FetchSubCategoryList']);
Route::post('/remove-product-img',['as'=>'RemoveProductImg','uses'=>'ProductItemsController@RemoveProductImg']);


//blogs urls
Route::get('/blogs',['as'=>'Blog','uses'=>'BlogsController@blogs']);
Route::get('/add-blogs',['as'=>'AddBlog','uses'=>'BlogsController@AddBlog']);

Route::get('/edit-blog/{id}',['as'=>'EditBlogs','uses'=>'BlogsController@EditBlogs']);

Route::post('/Insert-blog',['as'=>'InsertBlog','uses'=>'BlogsController@InsertBlog']);
Route::post('/save-blog',['as'=>'SaveBlog','uses'=>'BlogsController@SaveBlog']);

Route::get('/delete-blog/{id}',['as'=>'DeleteBlog','uses'=>'BlogsController@DeleteBlog']);

//language urls

Route::get('/language',['as'=>'Language','uses'=>'LanguageController@language']);
Route::get('/add-language',['as'=>'AddLanguage','uses'=>'LanguageController@AddLanguage']);
Route::post('/Insert-language',['as'=>'InsertLanguage','uses'=>'LanguageController@InsertLanguage']);
Route::get('/edit-language/{id}',['as'=>'EditLanguage','uses'=>'LanguageController@EditLanguage']);
Route::post('/save-language',['as'=>'SaveLanguage','uses'=>'LanguageController@SaveLanguage']);

Route::get('/ourreviews',['as'=>'OurReview','uses'=>'OurCustomersController@OurReview']);
Route::get('/admin-user-comment',['as'=>'AdminUserComment','uses'=>'OurCustomersController@OurUserComment']);

//Notification urls
Route::get('/Notification',['as'=>'Notification','uses'=>'NotificationController@Notification']);
Route::get('/add-Notification',['as'=>'AddNotification','uses'=>'NotificationController@AddNotification']);
Route::post('/Insert-Notification',['as'=>'InsertNotification','uses'=>'NotificationController@InsertNotification']);
Route::get('/edit-Notification/{id}',['as'=>'EditNotification','uses'=>'NotificationController@EditNotification']);
Route::post('/save-Notification',['as'=>'SaveNotification','uses'=>'NotificationController@SaveNotification']);
Route::get('/delete-Notification/{id}',['as'=>'DeleteNotification','uses'=>'NotificationController@DeleteNotification']);


Route::get('/size',['as'=>'Size','uses'=>'SizeController@Size']);
Route::get('/edit-size/{id}',['as'=>'EditSize','uses'=>'SizeController@EditSize']);
Route::post('/SaveSize',['as'=>'SaveSize','uses'=>'SizeController@SaveSize']);
Route::get('/add-size',['as'=>'AddSize','uses'=>'SizeController@AddSize']);
Route::post('/InsertSize',['as'=>'InsertSize','uses'=>'SizeController@InsertSize']);
Route::get('/delete-size/{id}',['as'=>'DeleteSize','uses'=>'SizeController@DeleteSize']);

Route::get('/color',['as'=>'Color','uses'=>'ColorController@Color']);
Route::get('/edit-color/{id}',['as'=>'EditColor','uses'=>'ColorController@EditColor']);
Route::post('/SaveColor',['as'=>'SaveColor','uses'=>'ColorController@SaveColor']);
Route::get('/add-color',['as'=>'AddColor','uses'=>'ColorController@AddColor']);
Route::post('/InsertColor',['as'=>'InsertColor','uses'=>'ColorController@InsertColor']);
Route::get('/delete-color/{id}',['as'=>'DeleteColor','uses'=>'ColorController@DeleteColor']);


Route::get('/ourcustomers',['as'=>'OurCustomers','uses'=>'OurCustomersController@OurCustomers']);
Route::get('/edit-ourcustomers/{id}',['as'=>'EditOurCustomers','uses'=>'OurCustomersController@EditOurCustomers']);
Route::post('/SaveOurCustomers',['as'=>'SaveOurCustomers','uses'=>'OurCustomersController@SaveOurCustomers']);
Route::get('/add-ourcustomers',['as'=>'AddOurCustomers','uses'=>'OurCustomersController@AddOurCustomers']);
Route::post('/InsertOurCustomers',['as'=>'InsertOurCustomers','uses'=>'OurCustomersController@InsertOurCustomers']);
Route::get('/delete-ourcustomers/{id}',['as'=>'DeleteOurCustomers','uses'=>'OurCustomersController@DeleteOurCustomers']);

// Route::get('/offers',['as'=>'Offers','uses'=>'OffersController@Offers']);
// Route::get('/edit-offers/{id}',['as'=>'EditOffers','uses'=>'OffersController@EditOffers']);
// Route::post('/SaveOffers',['as'=>'SaveOffers','uses'=>'OffersController@SaveOffers']);
// Route::get('/add-offers',['as'=>'AddOffers','uses'=>'OffersController@AddOffers']);
// Route::post('/InsertOffers',['as'=>'InsertOffers','uses'=>'OffersController@InsertOffers']);
// Route::get('/delete-offers/{id}',['as'=>'DeleteOffers','uses'=>'OffersController@DeleteOffers']);

Route::get('/discount',['as'=>'Discount','uses'=>'DiscountController@Discount']);
Route::get('/edit-discount/{id}',['as'=>'EditDiscount','uses'=>'DiscountController@EditDiscount']);
Route::post('/SaveDiscount',['as'=>'SaveDiscount','uses'=>'DiscountController@SaveDiscount']);
Route::get('/add-discount',['as'=>'AddDiscount','uses'=>'DiscountController@AddDiscount']);
Route::post('/InsertDiscount',['as'=>'InsertDiscount','uses'=>'DiscountController@InsertDiscount']);
Route::get('/delete-discount/{id}',['as'=>'DeleteDiscount','uses'=>'DiscountController@DeleteDiscount']);
Route::get('/refund',['as'=>'Refund','uses'=>'OrderController@RefundList']);
Route::get('/delivered-order',['as'=>'DeliveredOrder','uses'=>'OrderController@DeliveredOrderList']);
Route::get('/order-tracking',['as'=>'OrderTracking','uses'=>'OrderController@OrderTracking']);

Route::get('/order',['as'=>'Order','uses'=>'OrderController@List']);
Route::get('/reservation',['as'=>'Reservation','uses'=>'ReservationController@List']);
Route::get('/generate-invoice/{id}', ['as' => 'GenerateInvoice', 'uses' => 'OrderController@GenerateInvoice']);
Route::get('/get-order-detail/{id}', ['as' => 'GetOrderDetails', 'uses' => 'OrderController@GetOrderDetails']);

Route::get('/generate-sipment/{id}', ['as' => 'genearteSipment', 'uses' => 'OrderController@genearteSipment']);

Route::post('/ship-user-order',['as'=>'ShipUserOrder','uses'=>'OrderController@ShipUserOrder']);
Route::get('/get-order-serviceability', ['as' => 'OrderServiceability', 'uses' => 'OrderController@CheckCourierServiceabilityOrder']);


Route::get('/gst',['as'=>'GST','uses'=>'OffersController@gst']);
Route::get('/add-gst',['as'=>'AddGST','uses'=>'OffersController@addGst']);
Route::get('/edit-gst/{id}',['as'=>'EditGST','uses'=>'OffersController@EditGST']);

Route::post('/InsertGst',['as'=>'InsertGst','uses'=>'OffersController@InsertGST']);
Route::get('/delete-gst/{id}',['as'=>'DeleteGst','uses'=>'OffersController@DeleteGst']);
Route::post('/save-gst',['as'=>'SaveGst','uses'=>'OffersController@SaveGst']);

Route::post('/fetch-category-list',['as'=>'FetchCategoryList','uses'=>'SizeController@fetchCategoryList']);
/*Route::post('/fetch-sub-category-list',['as'=>'FetchSubCategoryList','uses'=>'SizeController@fetchSubCategoryList']);*/
Route::post('/fetch-brand-list',['as'=>'FetchBrandList','uses'=>'SizeController@fetchBrandList']);
Route::post('/fetch-size-list',['as'=>'FetchSizeList','uses'=>'ColorController@fetchSizeList']);
Route::post('/fetch-color-list',['as'=>'FetchColorList','uses'=>'SizeController@fetchColorList']);

});

 
/*Front Panel*/

Route::get('/language',['as'=>'language','uses'=>'homeController@language']);
Route::get('SetLanguage','homeController@SetLanguage')->name('SetLanguage');

//Route::group(['prefix'=>'en-SA','middleware'=>['IsUserLogin']], function () {


Route::group(['prefix' => $locale], function() {

Route::get('/',['as'=>'Home','uses'=>'homeController@index']);
Route::get('/login',['as'=>'Login','uses'=>'Front\LoginController@Login']);

Route::any('/change-web-language',['as'=>'ChangeWebLanguage','uses'=>'Front\LoginController@ChangeWebLanguage']);
Route::get('/category-products/{category_slug}',['as'=>'CategoryProducts','uses'=>'homeController@categoryProducts']);

Route::get('/PaymentAuthorised',['as'=>'PaymentAuthorised','uses'=>'Front\PaymentController@PaymentAuthorised']);
Route::get('/PaymentSuccess',['as'=>'PaymentSuccess','uses'=>'Front\PaymentController@PaymentSuccess']);
Route::get('/PaymentCancelled',['as'=>'PaymentCancelled','uses'=>'Front\PaymentController@PaymentCancelled']);
Route::get('/PaymentDeclined',['as'=>'PaymentDeclined','uses'=>'Front\PaymentController@PaymentDeclined']);


Route::any('/front/add-item-in-cart',['as'=>'AddItem','uses'=>'Front\AddItemInCartController@AddItemInCart']);
Route::any('/front/remove-item-from-cart',['as'=>'RemoveItem','uses'=>'Front\AddItemInCartController@RemoveItemFromTheCart']);
Route::any('/front-user-added-items',['as'=>'FetchuserAddedItems','uses'=>'Front\AddItemInCartController@fetchUserAddedItems']);
Route::get('/shop-single/{name_slug}',['as'=>'DemoSingleProduct','uses'=>'homeController@shopSingle']);
Route::any('/blog/{blog_id}',['as'=>'BlogsPage','uses'=>'homeController@singleBlog']);
Route::get('/cureroot/public/add-to-cart/{id}', ['as'=>'AddItemsInCart','uses'=>'Front\AddItemInCartController@addToCart']);
Route::post('/front-calculate-price-acc-to-coupen',['as'=>'CalculateCoupenPriceAccToCoupen','uses'=>'Front\AddItemInCartController@calculatePriceAccToCoupen']);
Route::any('/front-auth-check',['as'=>'AuthCheck','uses'=>'Auth\AuthController@checkUserAuthentication']);
Route::any('/update-cart', ['as'=>'UpdateCart','uses'=>'Front\AddItemInCartController@update']);
Route::any('/reduce-quantity-cart', ['as'=>'ReduceQuantityCart','uses'=>'Front\AddItemInCartController@reduceQuantity']);
Route::any('/remove-from-cart', ['as'=>'RemoveFromCart','uses'=>'Front\AddItemInCartController@remove']);
Route::any('/cart',['as'=>'ShowCartItems','uses'=>'Front\AddItemInCartController@getAllProductItems']);
Route::get('/blog',['as'=>'Blogs','uses'=>'homeController@blog']);
Route::get('/product-listing-subcategory/{sub_category_slug}',['as'=>'ProductListingOfSubcategory','uses'=>'homeController@ProductListingOfSubcategory']);
Route::get('/product-listing-concern/{concern_slug}',['as'=>'ProductListingOfConcern','uses'=>'homeController@ProductListingOfConcern']);
Route::get('/checkout',['as'=>'Checkout','uses'=>'homeController@checkout']);
Route::get('/contact',['as'=>'Contact','uses'=>'homeController@contact']);
Route::get('/demo-forgetpass',['as'=>'ForgotPassword','uses'=>'homeController@forgetPass']);
Route::get('/about',['as'=>'About','uses'=>'homeController@about']);
Route::post('/contact/save',['as'=>'contactSave','uses'=>'homeController@contactSave']);

Route::get('/our-stores',['as'=>'OurStores','uses'=>'homeController@OurStores']);
Route::get('/shipping-and-returns',['as'=>'ShippingAndReturns','uses'=>'homeController@ShippingAndReturns']);
Route::get('/terms-and-conditions',['as'=>'TermsAndConditions','uses'=>'homeController@TermsAndConditions']);
Route::get('/accessibility-statement',['as'=>'AccessibilityStatement','uses'=>'homeController@AccessibilityStatement']);
Route::get('/privacy-policy',['as'=>'PrivacyPolicy','uses'=>'homeController@PrivacyPolicy']);

Route::get('/retain-and-refund-policy',['as'=>'RetainAndRefundPolicy','uses'=>'homeController@RetainAndRefundPolicy']);
Route::get('/shipping-policy',['as'=>'ShippingPolicy','uses'=>'homeController@ShippingPolicy']);

Route::get('/philosophy',['as'=>'Philosophy','uses'=>'homeController@philosophy']);
Route::get('/FAQS',['as'=>'FAQS','uses'=>'homeController@faqs']);  

Route::any('/user/show-user-comment',['as'=>'ShowUserComment','uses'=>'CommentController@showUserComment']);
Route::any('/user/reply-user-comment',['as'=>'ReplyUserComment','uses'=>'CommentController@ReplyUserComment']);

Route::any('/user/user-comment',['as'=>'UserComment','uses'=>'CommentController@userComment']);
Route::any('/user/user-rating',['as'=>'InsertRating','uses'=>'CommentController@userRating']);

Route::get('/user-Profile',['as'=>'userProfile','uses'=>'homeController@userProfile']);
Route::get('/address',['as'=>'address','uses'=>'homeController@address']);

Route::get('/orders',['as'=>'orders','uses'=>'homeController@orders']);

Route::any('/register',['as'=>'Register','uses'=>'Front\LoginController@Register']);
Route::any('/front-user-registration',['as'=>'UserRegistration','uses'=>'Front\LoginController@userRegistration']);
Route::post('/front-user-shipping-address',['as'=>'UserShippingAddress','uses'=>'Front\LoginController@UserShippingAddress']);
Route::post('/front-edit-user-shipping-address',['as'=>'EditUserShippingAddress','uses'=>'Front\LoginController@EditUserShippingAddress']);

Route::post('/user-login-validation',['as'=>'Userlogin','uses'=>'Front\LoginController@userFrontLoginValidate']);
Route::get('/UserLogout',['as'=>'UserLogout','uses'=>'Front\LoginController@UserLogout']);
Route::get('/forgot-password',['as'=>'ForgotPassword','uses'=>'Front\LoginController@ForgotPassword']);
Route::get('/change-password',['as'=>'ChangePassword','uses'=>'Front\LoginController@ChangePassword']);
Route::post('/user-forgot-password',['as'=>'UserForgotPasswordRecover','uses'=>'Front\LoginController@UserForgotPasswordRecover']);
Route::get('/forget-password', ['as'=>'forgetPassword','uses'=>'Auth\ForgotPasswordController@getEmail']);
Route::post('/forget-password', ['as'=>'postforgetPassword','uses'=>'Auth\ForgotPasswordController@postEmail']);
Route::get('/reset-password/{token}',['as'=>'resetPassword','uses'=>'Auth\ResetPasswordController@getPassword']);
Route::post('/reset-password', ['as'=>'postResetPassword','uses'=>'Auth\ResetPasswordController@updatePassword']);

Route::post('/user-contact',['as'=>'UserContact','uses'=>'Front\LoginController@UserContactSubmit']);

Route::post('/UserEditProfile',['as'=>'UserEditProfile','uses'=>'Front\LoginController@UserEditProfile']);
Route::post('/InsertRegisterUser',['as'=>'InsertRegisterUser','uses'=>'Front\LoginController@InsertRegisterUser']);
Route::post('/CheckUserLogin',['as'=>'CheckUserLogin','uses'=>'Front\LoginController@CheckUserLogin']);
Route::post('/UserForgotPassword',['as'=>'UserForgotPassword','uses'=>'Front\LoginController@UserForgotPassword']);
Route::post('/UserChangePassword',['as'=>'UserChangePassword','uses'=>'Front\LoginController@UserChangePassword']);
Route::post('/create-new-password',['as'=>'CreateNewPassword','uses'=>'Front\LoginController@CreateNewPassword']);
Route::get('/menu/{page}',['as'=>'MenusPage','uses'=>'homeController@MenusPage']);

Route::get('/menu-certificates',['as'=>'MenuCertificates','uses'=>'homeController@MenuCertificates']);

Route::get('/payment',['as'=>'payment','uses'=>'Front\PaymentController@index']);
Route::post('/pay',['as'=>'pay','uses'=>'Front\PaymentController@userPayment']);

Route::post('/pay-for-cash-on-delivery',['as'=>'payForCashOnDelivery','uses'=>'Front\PaymentController@userPaymentForCashOnDelivery']);

Route::post('/ProductListingBySlug',['as'=>'ProductListingBySlug','uses'=>'homeController@ProductListingBySlug']);

Route::post('/add', 'Front\CartController@add')->name('cart.store');
Route::post('/update', 'Front\CartController@update')->name('cart.update');
Route::post('/remove', 'Front\CartController@remove')->name('cart.remove');
Route::post('/clear', 'Front\CartController@clear')->name('cart.clear');
Route::get('/test', 'Front\CartController@test')->name('cart.clear');

});
Route::post('/save-address',['as'=>'save-address','uses'=>'homeController@saveAddress']);
Route::get('/user-Profile',['as'=>'userProfile','uses'=>'homeController@userProfile']);
Route::get('/address',['as'=>'address','uses'=>'homeController@address']);
Route::get('/orders',['as'=>'orders','uses'=>'homeController@orders']);

Route::get('/fetch-countries','homeController@fetchCountries')->name('fetch-countries');

Route::get('/create-shipment','homeController@createShipment')->name('create-shipment');

Route::get('/create-pickup','homeController@createPickup')->name('create-pickup');

Route::get('/calculate-rate','homeController@calculateRate')->name('calculate-rate');

Route::get('/fetch-states','homeController@fetchStates')->name('fetch-states');
