<?php

return [
    "name"=> "CustomerTheme",
    "title"=> "Theme for customer and channels",
    "slug"=> "customertheme",
    "thumbnail"=> "https://img.site/p/300/160",
    "excerpt"=> "this theme is my first ever theme",
    "description"=> "this theme is my first ever theme",
    "download_link"=> "",
    "author_name"=> "customertheme",
    "author_website"=> "https://vaah.dev",
    "version"=> "v0.0.1",
    "is_migratable"=> true,
    "is_sample_data_available"=> true,
    "db_table_prefix"=> "vh_customertheme_",
    "providers"=> [
        "\\VaahCms\\Themes\\CustomerTheme\\Providers\\CustomerThemeServiceProvider"
    ],
    "aside-menu-order"=> null
];
