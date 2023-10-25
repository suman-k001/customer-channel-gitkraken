<?php

/*
 * API url will be: <base-url>/public/api/customerchannel/channels
 */
Route::group(
    [
        'prefix' => 'customerchannel/channels',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', 'ChannelsController@getAssets')
        ->name('vh.backend.customerchannel.api.channels.assets');
    /**
     * Get List
     */
    Route::get('/', 'ChannelsController@getList')
        ->name('vh.backend.customerchannel.api.channels.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'ChannelsController@updateList')
        ->name('vh.backend.customerchannel.api.channels.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'ChannelsController@deleteList')
        ->name('vh.backend.customerchannel.api.channels.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'ChannelsController@createItem')
        ->name('vh.backend.customerchannel.api.channels.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'ChannelsController@getItem')
        ->name('vh.backend.customerchannel.api.channels.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'ChannelsController@updateItem')
        ->name('vh.backend.customerchannel.api.channels.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'ChannelsController@deleteItem')
        ->name('vh.backend.customerchannel.api.channels.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'ChannelsController@listAction')
        ->name('vh.backend.customerchannel.api.channels.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'ChannelsController@itemAction')
        ->name('vh.backend.customerchannel.api.channels.item.action');



});
