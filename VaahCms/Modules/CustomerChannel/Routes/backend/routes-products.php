<?php

Route::group(
    [
        'prefix' => 'backend/customerchannel/products',

        'middleware' => ['web', 'has.backend.access'],

        'namespace' => 'Backend',
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', 'ProductsController@getAssets')
        ->name('vh.backend.customerchannel.products.assets');
    /**
     * Get List
     */
    Route::get('/', 'ProductsController@getList')
        ->name('vh.backend.customerchannel.products.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'ProductsController@updateList')
        ->name('vh.backend.customerchannel.products.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'ProductsController@deleteList')
        ->name('vh.backend.customerchannel.products.list.delete');


    /**
     * Fill Form Inputs
     */
    Route::any('/fill', 'ProductsController@fillItem')
        ->name('vh.backend.customerchannel.products.fill');

    /**
     * Create Item
     */
    Route::post('/', 'ProductsController@createItem')
        ->name('vh.backend.customerchannel.products.create');

    /**
     * GetUser
     */

    Route::get('/item/{id}/users', 'ProductsController@getItemUser')
        ->name('backend.vaah.products.item.users');
    /**
     * Get Item
     */
    Route::get('/{id}', 'ProductsController@getItem')
        ->name('vh.backend.customerchannel.products.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'ProductsController@updateItem')
        ->name('vh.backend.customerchannel.products.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'ProductsController@deleteItem')
        ->name('vh.backend.customerchannel.products.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'ProductsController@listAction')
        ->name('vh.backend.customerchannel.products.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'ProductsController@itemAction')
        ->name('vh.backend.customerchannel.products.item.action');

    Route::post('/actions/{action_name}', 'ProductsController@postActions')
        ->name('backend.vaah.products.actions');

    /**
     * get module section
     */
    Route::post('/module/{module_name}/sections', 'ProductsController@getModuleSections')
        ->name('backend.vaah.products.module.sections');

    //---------------------------------------------------------

});
