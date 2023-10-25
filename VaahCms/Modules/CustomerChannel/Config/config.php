<?php

return [
    "name"=> "CustomerChannel",
    "title"=> "Module for defining relation between Customers and Channels",
    "slug"=> "customerchannel",
    "thumbnail"=> "https://img.site/p/300/160",
    "is_dev" => env('MODULE_CUSTOMERCHANNEL_ENV')?true:false,
    "excerpt"=> "Customers and Channels relationship",
    "description"=> "Customers and Channels relationship",
    "download_link"=> "",
    "author_name"=> "Suman",
    "author_website"=> "https://vaah.dev",
    "version"=> "0.0.1",
    "is_migratable"=> true,
    "is_sample_data_available"=> false,
    "db_table_prefix"=> "vh_customerchannel_",
    "providers"=> [
        "\\VaahCms\\Modules\\CustomerChannel\\Providers\\CustomerChannelServiceProvider"
    ],
    "aside-menu-order"=> null
];
