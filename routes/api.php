<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Must uncomment line-29 in App\Providers\App\Providers\RouteServiceProvider to use following namespace

Route::group([
    'namespace' => 'API\Auth',
    'prefix' => 'auth'

], function () {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');

    Route::post('/userForgotPassword', 'ForgotPasswordController@userForgotPassword');
    Route::post('/resetPassword', 'ForgotPasswordController@resetPassword');    

});

// Web Admin Routes

Route::group([
    'middleware' => ['auth:api', 'role:admin'],
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
    Route::get('change-inventoryItem-status/{id}', 'InventoryController@changeInventoryItemStatus');  
    Route::get('location-based-inventory/{id}', 'InventoryController@locationBasedInventory'); // "id" is the location id

    // Web Admin Purchases Controller
    Route::get('purchase-list', 'PurchaseController@purchaseList');
    Route::post('add-purchase', 'PurchaseController@addNewPurchase');
    Route::get('show-purchase/{id}', 'PurchaseController@showPurchase');
    Route::post('update-purchase/{id}', 'PurchaseController@updatePurchase');
    Route::delete('remove-purchased-item/{id}', 'PurchaseController@removePurchasedItem');
    Route::get('change-purchase-status/{id}', 'PurchaseController@changePurchaseStatus');
    Route::get('remove-purchase-record/{id}', 'PurchaseController@removePurchaseRecord');

    // Web Admin Items Controller
    Route::get('items-list', 'ItemsController@index');
    Route::post('add-item', 'ItemsController@store');
    Route::post('update-item/{id}', 'ItemsController@update');
    Route::delete('remove-item/{id}', 'ItemsController@delete');

});


// Web Employee Routes

Route::group([
    'middleware' => ['auth:api', 'role:employee'],
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

    // Web Employee Items Controller
    Route::get('items-list', 'ItemsController@index');
    Route::post('add-item', 'ItemsController@store');
    Route::post('update-item/{id}', 'ItemsController@update');
    Route::delete('remove-item/{id}', 'ItemsController@delete');


});
