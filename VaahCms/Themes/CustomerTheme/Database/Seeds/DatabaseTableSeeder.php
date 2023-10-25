<?php
namespace VaahCms\Themes\CustomerTheme\Database\Seeds;


use Illuminate\Database\Seeder;

class DatabaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $theme_slug = 'customertheme';

        // create theme location
        /*
         $file = __DIR__.'/json/theme_locations.json';
         \VaahCms\Modules\Cms\Libraries\CmsSeeder::themeLocations($theme_slug, $file);
        */

        // create theme templates
        /*
         $file = __DIR__.'/json/templates.json';
         \VaahCms\Modules\Cms\Libraries\CmsSeeder::templates($theme_slug, $file);
        */
    }




}
