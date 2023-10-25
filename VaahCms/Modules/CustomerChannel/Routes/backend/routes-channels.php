<?php

Route::group(
    [
        'prefix' => 'backend/customerchannel/channels',

        'middleware' => ['web', 'has.backend.access'],

        'namespace' => 'Backend',
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', 'ChannelsController@getAssets')
        ->name('vh.backend.customerchannel.channels.assets');
    /**
     * Get List
     */
    Route::get('/', 'ChannelsController@getList')
        ->name('vh.backend.customerchannel.channels.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'ChannelsController@updateList')
        ->name('vh.backend.customerchannel.channels.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'ChannelsController@deleteList')
        ->name('vh.backend.customerchannel.channels.list.delete');


    /**
     * Fill Form Inputs
     */
    Route::any('/fill', 'ChannelsController@fillItem')
        ->name('vh.backend.customerchannel.channels.fill');

    /**
     * Create Item
     */
    Route::post('/', 'ChannelsController@createItem')
        ->name('vh.backend.customerchannel.channels.create');
    /**
     * Get Customers name
     */
    Route::get('/customer-names', 'ChannelsController@customerNames')
        ->name('vh.backend.customerchannel.channels.customerNames');
    /**
     * Get Auto-complete data
     */
    Route::post('/auto-complete/', 'ChannelsController@searchCustomerNames')
        ->name('vh.backend.customerchannel.channels.autoComplete');
    /**
     * Get Item
     */
    Route::get('/{id}', 'ChannelsController@getItem')
        ->name('vh.backend.customerchannel.channels.read');

    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'ChannelsController@updateItem')
        ->name('vh.backend.customerchannel.channels.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'ChannelsController@deleteItem')
        ->name('vh.backend.customerchannel.channels.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'ChannelsController@listAction')
        ->name('vh.backend.customerchannel.channels.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'ChannelsController@itemAction')
        ->name('vh.backend.customerchannel.channels.item.action');

    //---------------------------------------------------------

});
