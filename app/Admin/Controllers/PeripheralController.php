<?php

namespace App\Admin\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Peripheral;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Dropdown;

class PeripheralController extends AdminController
{
    public $category_id;

    public function __construct()
    {
        // category_id设置默认值防止不带参数访问外设页面报错
        $this->category_id = request('category') ? request('category') : Category::where('parent_id' , '!=', 0)->orderBy('order')->pluck('id')->first();
    }

    public function index(Content $content)
    {
        // 创建下拉菜单
        $category_parent = Category::find($this->category_id)->parent_id;
        $categories = Category::select('id', 'title')->where('parent_id', $category_parent);
        $dropdown = Dropdown::make($categories->pluck('id')->toarray())
            ->button('选择外设分类') // 设置按钮
            ->buttonClass('btn btn-outline btn-white waves-effect') // 设置按钮样式
            ->click($categories->find($this->category_id)->title) // 默认选项
            ->map(function ($id) {
                // 格式化菜单选项
                $url = admin_url('peripherals?category='.$id);
                $title = Category::find($id)->title;
                return "<a href='$url'>{$title}</a>";
            });
        
        return $content
            ->header(Category::find($category_parent)->title)
            ->description($dropdown)
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Peripheral::with(['brand', 'category']), function (Grid $grid) {
            $grid->model()->where('category_id', $this->category_id)->orderBy('created_at', 'desc');

            $grid->column('brand.full_name', admin_trans_field('brand_name'));
            $grid->column('name');
            $grid->column('category.title', admin_trans_field('category_title'));
            $grid->column('description');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, Peripheral::with(['brand', 'category']), function (Show $show) {
            $show->field('id');
            $show->field('brand.full_name', admin_trans_field('brand_name'));
            $show->field('name');
            $show->field('category.title', admin_trans_field('category_title'));
            $show->field('description');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(Peripheral::with(['brand', 'category']), function (Form $form) {
            $form->display('id');
            // 编辑时分类
            if ($form->isEditing()) {
                $form->display('category_id')->with(function ($category_id) {
                    return Category::find($category_id)->title;
                });
            }
            // 新增时分类
            elseif ($form->isCreating()) {
                $form->hidden('category_id')->default($this->category_id);
                $form->title(Category::find($this->category_id)->title);
            }
            $form->select('brand_id')->options(Brand::all()->pluck('full_name', 'id'));
            $form->text('name');
            $form->text('description');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
