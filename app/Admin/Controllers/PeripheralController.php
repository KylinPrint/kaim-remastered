<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Form\ListButton;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Peripheral;
use App\Models\Specification;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Dropdown;

class PeripheralController extends AdminController
{
    public $category;

    public function __construct()
    {
        if (!Category::where('id', request('category'))->exists()) {
            // 防止URL参数不合法时报错
            $id = Category::where('parent_id' , '!=', 0)->orderBy('order')->pluck('id')->first();
        } elseif (Category::find(request('category'))->parent_id == 0) {
            // 将URL参数中的一级分类转换为二级分类
            $id = Category::where('parent_id' , request('category'))->orderBy('order')->pluck('id')->first();
        } else {
            // 正确URL参数
            $id = request('category');
        }

        $this->category = Category::find($id);
    }

    public function index(Content $content)
    {
        // 无分类时报错
        if ($this->category->id == null) {
            return $content->header('外设')
                ->description('列表')
                ->body('<strong>没有有效的二级分类，请前往<a href="/admin/categories">分类</a>页面创建');
        }

        // 创建下拉菜单
        $category = Category::find($this->category->id);
        $categories = Category::select('id', 'title')->where('parent_id', $category->parent_id);
        
        $dropdown = Dropdown::make($categories->pluck('id')->toarray())
            ->button('选择外设分类') // 设置按钮
            ->buttonClass('waves-effect') // 设置按钮样式
            ->click($category->title) // 默认选项
            ->map(function ($id) {
                // 格式化菜单选项
                $url = admin_url('peripherals?category='.$id);
                $title = Category::find($id)->title;
                return "<a href='$url'>{$title}</a>";
            });
        
        return $content
            // ->header(Category::find($category->parent_id)->title)
            ->header($dropdown)
            // ->description($dropdown)
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        // 重新生成页面<title>
        Admin::script('document.title="' . config('admin.title') . ' | 外设 - ' . $this->category->title . '"');

        return Grid::make(Peripheral::with(['brand', 'category', 'values']), function (Grid $grid) {
            $grid->model()->where('category_id', $this->category->id)->orderBy('created_at', 'desc');

            $grid->column('brand.full_name', admin_trans_field('brand_name'));
            $grid->column('name');
            // $grid->column('category.title', admin_trans_field('category_title'));
            $grid->column('description');

            // 生成参数列
            $specifications = Category::find($this->category->id)->specifications;
            foreach ($specifications as $specification) {
                $grid->column($specification->name)->display(function () use ($specification) {
                    return $this->values()->where('specification_id', $specification->id)->pluck('value')->first();
                });
            }

            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });

            $grid->model()->setConstraints([ 'category' => $this->category->id ]);
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
        return Form::make(Peripheral::with(['brand', 'category', 'values']), function (Form $form) {
            $form->display('id');
            // 编辑时分类
            if ($form->isEditing()) {
                $form->display('category_id')->with(function ($category_id) {
                    return Category::find($category_id)->title;
                });
            }
            // 新增时分类
            elseif ($form->isCreating()) {
                $form->hidden('category_id')->default($this->category->id);
                $form->title(Category::find($this->category->id)->title);
            }
            $form->select('brand_id')->options(Brand::all()->pluck('full_name', 'id'));
            $form->text('name');
            $form->text('description');

            // 参数
            $form->hasMany('values', function (Form\NestedForm $form) {
                // TODO: 同一个参数不允许多次选择
                $form->select('specification_id')->options(Specification::where('category_id', $this->category->id)->pluck('name', 'id'));
                $form->text('value');
            })->useTable();
        
            $form->display('created_at');
            $form->display('updated_at');

            
            // 自定义列表按钮
            $form->tools(function (Form\Tools $tools) {
                $tools->disableList();
                $href = '/admin/peripherals?category=' . request('category');
                $tools->append('<div class="btn-group pull-right" style="margin-right: 5px"><a href="'. $href . '" class="btn btn-sm btn-primary "><i class="feather icon-list"></i><span class="d-none d-sm-inline">&nbsp;'. trans('admin.list') . '</span></a></div>');
            });
        });
    }
}
