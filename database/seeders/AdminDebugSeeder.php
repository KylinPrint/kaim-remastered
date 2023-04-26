<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Peripheral;
use App\Models\Specification;
use Illuminate\Database\Seeder;

class AdminDebugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (['输出设备', '输入设备', '其它外设'] as $title) {
            Category::create(['title' => $title]);
        }
        Brand::factory()->count(50)->create();
        Category::factory()->count(20)->create();
        Peripheral::factory()->count(100)->create();
        Specification::factory()->count(30)->create();
    }
}
