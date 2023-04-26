<?php

use App\Models\Category;
use Dcat\Admin\Admin;
use Dcat\Admin\Layout\Menu;
use Dcat\Admin\Models\Menu as ModelsMenu;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

// 先生成外设的一级菜单
$id = 1;
$menu_list = [
    [
        'id'            => $id++,
        'title'         => 'peripherals',
        'icon'          => 'fa-file-text-o',
        'uri'           => '',
        'parent_id'     => 0,
        'permission_id' => 'test', // 与权限绑定
        'roles'         => 'test-roles', // 与角色绑定
    ],
];
// 动态生成外设菜单下的二级菜单
foreach (Category::where('parent_id', 0)->get() as $category) {
    $menu_list[] = [
        'id'            => $id++,
        'title'         => $category->title,
        'icon'          => 'fa-file-text-o',
        'uri'           => 'peripherals?category=' . $category->id,
        'parent_id'     => 1,
        'permission_id' => 'test', // 与权限绑定
        'roles'         => 'test-roles', // 与角色绑定
    ];
};
Admin::menu(function (Menu $menu) use ($menu_list) {
    $menu->add($menu_list);
});
unset($id, $menu_list);
