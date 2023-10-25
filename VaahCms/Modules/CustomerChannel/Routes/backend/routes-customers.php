<?php

Route::group(
    [
        'prefix' => 'backend/customerchannel/customers',

        'middleware' => ['web', 'has.backend.access'],

        'namespace' => 'Backend',
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', 'CustomersController@getAssets')
        ->name('vh.backend.customerchannel.customers.assets');
    /**
     * Get List
     */
    Route::get('/', 'CustomersController@getList')
        ->name('vh.backend.customerchannel.customers.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'CustomersController@updateList')
        ->name('vh.backend.customerchannel.customers.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'CustomersController@deleteList')
        ->name('vh.backend.customerchannel.customers.list.delete');


    /**
     * Fill Form Inputs
     */
    Route::any('/fill', 'CustomersController@fillItem')
        ->name('vh.backend.customerchannel.customers.fill');

    /**
     * Create Item
     */
    Route::post('/', 'CustomersController@createItem')
        ->name('vh.backend.customerchannel.customers.create');
    /**
     * upload image
     */
    Route::match(['post','get'],'/upload-image', 'CustomersController@uploadImage')
        ->name('vh.backend.customerchannel.customers.uploadImage');
    /**
     * Get Item
     */
    Route::get('/{id}', 'CustomersController@getItem')
        ->name('vh.backend.customerchannel.customers.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'CustomersController@updateItem')
        ->name('vh.backend.customerchannel.customers.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'CustomersController@deleteItem')
        ->name('vh.backend.customerchannel.customers.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'CustomersController@listAction')
        ->name('vh.backend.customerchannel.customers.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'CustomersController@itemAction')
        ->name('vh.backend.customerchannel.customers.item.action');

    //---------------------------------------------------------

});
