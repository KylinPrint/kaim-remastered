<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Dcat\Admin\Form;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Show;
use Dcat\Admin\Tree;

class CategoryController extends AdminController
{
    public function index(Content $content)
    {
        return $content->header('外设分类')
            ->body(function (Row $row) {
                $tree = new Tree(new Category);
                $tree->disableCreateButton();

                $row->column(12, $tree);
            });
    }

    protected function detail($id)
    {
        return Show::make($id, new Category(), function (Show $show) {
            $show->field('id');
            $show->field('parent_id');
            $show->field('title');
            $show->field('depth');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    protected function form()
    {
        return Form::make(new Category(), function (Form $form) {
            $form->select('parent_id')->options(Category::selectOptions())->default(0);
            $form->text('title')->required();
        });
    }
}