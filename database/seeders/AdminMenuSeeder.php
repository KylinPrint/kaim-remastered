<?php

namespace Database\Seeders;

use Dcat\Admin\Models\Menu;
use Illuminate\Database\Seeder;

class AdminMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (['brands', 'chips', 'distributions', 'categories', 'specifications', 'solutions'] as $menu) {
            Menu::create([
                'title'         => $menu,
                'icon'          => 'fa-folder-open-o',
                'uri'           => $menu,
            ]);
        }
    }
}
