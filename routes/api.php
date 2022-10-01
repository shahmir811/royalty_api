<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Must uncomment line-29 in App\Providers\App\Providers\RouteServiceProvider to use following namespace

Route::group([
    'middleware' => ['cors'],
    'namespace' => 'API\Auth',
    'prefix' => 'auth'

], function () {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');

});

// Web Admin Routes

Route::group([
    'middleware' => ['auth:api', 'cors', 'role:admin'],
    'namespace' => 'API\Web\Admin',
    'prefix' => 'wadmin'

], function () {

    // Web Admin User Controller
    Route::get('users', 'UserController@users');
    Route::post('add-user', 'UserController@AddUser');
    Route::post('update-user/{id}', 'UserController@updateUser');
    Route::post('update-password/{id}', 'UserController@updatePassword');
    Route::delete('delete-user/{id}', 'UserController@deleteUser');
    Route::get('change-user-status/{id}', 'UserController@changeUserStatus');    

    // Web Admin PredefinedValue Controller    
    Route::get('tax-details', 'PredefinedValueController@taxDetails');
    Route::post('update-tax-details', 'PredefinedValueController@updateTaxDetails');

    // Web Admin Customer Controller
    Route::get('customers', 'CustomerController@index');
    Route::post('add-customer', 'CustomerController@store');
    Route::get('show-customer/{id}', 'CustomerController@show');
    Route::post('update-customer/{id}', 'CustomerController@update');
    Route::get('change-customer-status/{id}', 'CustomerController@changeCustomerStatus');

    // Web Admin Location Controller
    Route::get('locations', 'LocationController@index');   
    Route::get('active-locations', 'LocationController@activeLocations');   
    Route::post('add-location', 'LocationController@store');
    Route::get('show-location/{id}', 'LocationController@show');  
    Route::post('update-location/{id}', 'LocationController@update');
    Route::get('change-location-status/{id}', 'LocationController@changeLocationStatus');       

    // Web Admin Inventory Controller
    Route::get('inventory-list', 'InventoryController@index');
    Route::post('add-inventoryItem', 'InventoryController@store');   
    Route::get('show-inventoryItem/{id}', 'InventoryController@show');  
    Route::post('update-inventoryItem/{id}', 'InventoryController@update');
    Route::get('location-based-inventory/{id}', 'InventoryController@locationBasedInventory'); // "id" is the location id

    // Web Admin Purchases Controller
    Route::get('purchase-list', 'PurchaseController@purchaseList');
    Route::post('add-purchase', 'PurchaseController@addNewPurchase');
    Route::get('show-purchase/{id}', 'PurchaseController@showPurchase');
    Route::post('update-purchase/{id}', 'PurchaseController@updatePurchase');
    Route::delete('remove-purchased-item/{id}', 'PurchaseController@removePurchasedItem');
    Route::get('change-purchase-status/{id}', 'PurchaseController@changePurchaseStatus');
    Route::get('remove-purchase-record/{id}', 'PurchaseController@removePurchaseRecord');
    Route::get('print-purchase-details/{id}', 'PurchaseController@printPurchaseDetails');

    // Web Admin Category controller
    Route::get('categories', 'CategoryController@index');
    Route::post('add-category', 'CategoryController@store');
    Route::post('update-category/{id}', 'CategoryController@update');
    Route::delete('remove-category/{id}', 'CategoryController@removeCategoryRecord');

    // Web Admin Items Controller
    Route::get('items-list', 'ItemsController@index');
    Route::post('add-item', 'ItemsController@store');
    Route::post('update-item/{id}', 'ItemsController@update');
    Route::delete('remove-item/{id}', 'ItemsController@delete');
    Route::get('change-item-status/{id}', 'ItemsController@changeItemStatus');  

    // Web Admin Sales Controller
    Route::get('sales-list', 'SaleController@index');
    Route::post('add-sale', 'SaleController@addNewSale');
    Route::get('sales-with-delivery-notes', 'SaleController@salesWithDeliveryNotes');
    Route::get('show-sale-details/{id}', 'SaleController@showSaleDetails'); 
    Route::get('all-sales-statuses', 'SaleController@fetchAllSalesStatus');
    Route::post('update-sale-data/{id}', 'SaleController@updateSaleRecord');
    Route::get('get-sale-invoice/{id}', 'SaleController@getSaleInvoice'); // id => saleId
    Route::post('add-sale-detail-item-data', 'SaleController@addSaleDetailItem');
    Route::post('update-sale-detail-item-data/{id}', 'SaleController@updateSaleDetailItem');
    Route::get('remove-sale-detail-item/{id}', 'SaleController@removeSaleDetailItem');
    Route::get('print-sale-details/{id}', 'SaleController@printSaleDetails');


    // Web Admin dashboard charts
    Route::get('get-weekly-sales', 'SaleController@weeklySale');
    Route::get('get-sales', 'SaleController@getSalesRecord');
    Route::get('get-sales-between-dates', 'SaleController@getSalesBetweenDates');
    Route::get('get-yearly-sales', 'SaleController@getYearlySales');


    // Web Admin Customer Credit
    Route::get('get-all-customers-credit', 'CustomerCreditController@getAllCustomersCreditList');
    Route::get('customer-credit-details/{customer_id}', 'CustomerCreditController@getCustomerCreditDetails');
    Route::get('credit-payment-details/{credit_id}', 'CustomerCreditController@getCreditPaymentDetails');
    Route::get('print-payment-details/{credit_id}', 'CustomerCreditController@printPaymentDetails');
    Route::post('add-payment/{credit_id}', 'CustomerCreditController@addPayment');
    Route::get('remove-customer-credit-record/{credit_id}', 'CustomerCreditController@removeCustomerCreditRecord');
    Route::post('add-new-customer-credit/{customer_id}', 'CustomerCreditController@addNewCustomerCredit');

    // Web Admin Delivery Notes controller
    Route::get('all-delivery-notes', 'DeliveryNoteController@allDeliveryNotes');
    Route::post('create-delivery-note', 'DeliveryNoteController@createDeliveryNote');
    Route::get('view-delivery-note/{id}', 'DeliveryNoteController@viewDeliveryNote');
    Route::delete('delete-delivery-note/{id}', 'DeliveryNoteController@deleteDeliveryNote');
    Route::get('remaining-quantity/{sale_id}', 'DeliveryNoteController@remainingQuantityToDispatch');
    Route::get('print-delivery-note/{id}', 'DeliveryNoteController@printDeliveryNote');


});


// Web Employee Routes

Route::group([
    'middleware' => ['auth:api', 'cors', 'role:employee'],
    'namespace' => 'API\Web\Employee',
    'prefix' => 'wemployee'

], function () {

    // Web Employee Customer Controller
    Route::get('customers', 'CustomerController@index');
    Route::post('add-customer', 'CustomerController@store');
    Route::get('show-customer/{id}', 'CustomerController@show');
    Route::post('update-customer/{id}', 'CustomerController@update');

    // Web Employee Location Controller
    Route::get('locations', 'LocationController@index');   
    Route::get('active-locations', 'LocationController@activeLocations');  
    Route::post('add-location', 'LocationController@store');
    Route::get('show-location/{id}', 'LocationController@show');  
    Route::post('update-location/{id}', 'LocationController@update');

    // Web Employee Inventory Controller
    Route::get('inventory-list', 'InventoryController@index');
    Route::post('add-inventoryItem', 'InventoryController@store');   
    Route::get('show-inventoryItem/{id}', 'InventoryController@show');  
    Route::post('update-inventoryItem/{id}', 'InventoryController@update');
    Route::get('location-based-inventory/{id}', 'InventoryController@locationBasedInventory'); // "id" is the location id    

    // Web Employee PredefinedValue Controller    
    Route::get('tax-details', 'PredefinedValueController@taxDetails');

    // Web Employee Purchases Controller
    Route::get('purchase-list', 'PurchaseController@purchaseList');
    Route::post('add-purchase', 'PurchaseController@addNewPurchase');
    Route::get('show-purchase/{id}', 'PurchaseController@showPurchase');
    Route::post('update-purchase/{id}', 'PurchaseController@updatePurchase');
    Route::delete('remove-purchased-item/{id}', 'PurchaseController@removePurchasedItem');
    Route::get('change-purchase-status/{id}', 'PurchaseController@changePurchaseStatus');
    // Route::get('remove-purchase-record/{id}', 'PurchaseController@removePurchaseRecord');
    Route::get('print-purchase-details/{id}', 'PurchaseController@printPurchaseDetails');

    // Web Employee Category controller
    Route::get('categories', 'CategoryController@index');
    Route::post('add-category', 'CategoryController@store');
    Route::post('update-category/{id}', 'CategoryController@update');

    // Web Employee Items Controller
    Route::get('items-list', 'ItemsController@index');
    Route::post('add-item', 'ItemsController@store');
    Route::post('update-item/{id}', 'ItemsController@update');
    Route::delete('remove-item/{id}', 'ItemsController@delete');

    // Web Employee Sales Controller
    Route::get('sales-list', 'SaleController@index');
    Route::post('add-sale', 'SaleController@addNewSale');
    Route::get('sales-with-delivery-notes', 'SaleController@salesWithDeliveryNotes');
    Route::get('show-sale-details/{id}', 'SaleController@showSaleDetails'); 
    Route::get('all-sales-statuses', 'SaleController@fetchAllSalesStatus');
    Route::post('update-sale-data/{id}', 'SaleController@updateSaleRecord');
    Route::get('get-sale-invoice/{id}', 'SaleController@getSaleInvoice'); // id => saleId
    Route::post('add-sale-detail-item-data', 'SaleController@addSaleDetailItem');
    Route::post('update-sale-detail-item-data/{id}', 'SaleController@updateSaleDetailItem');
    Route::get('remove-sale-detail-item/{id}', 'SaleController@removeSaleDetailItem');
    Route::get('print-sale-details/{id}', 'SaleController@printSaleDetails'); 
    
    
    // Web Employee Customer Credit
    Route::get('get-all-customers-credit', 'CustomerCreditController@getAllCustomersCreditList');
    Route::get('customer-credit-details/{customer_id}', 'CustomerCreditController@getCustomerCreditDetails');
    Route::get('credit-payment-details/{credit_id}', 'CustomerCreditController@getCreditPaymentDetails');
    Route::get('print-payment-details/{credit_id}', 'CustomerCreditController@printPaymentDetails');
    Route::post('add-payment/{credit_id}', 'CustomerCreditController@addPayment');
    Route::get('remove-customer-credit-record/{credit_id}', 'CustomerCreditController@removeCustomerCreditRecord');
    Route::post('add-new-customer-credit/{customer_id}', 'CustomerCreditController@addNewCustomerCredit');


});


Route::group([
    'middleware' => ['cors'],
    'namespace' => 'API\Auth',

], function () {

    Route::post('/userForgotPassword', 'ForgotPasswordController@userForgotPassword');
    Route::post('/resetPassword', 'ForgotPasswordController@resetPassword');    

});