<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Specification;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class SpecificationController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Specification::with(['category']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('category.title');
            $grid->column('required');
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
        return Show::make($id, Specification::with(['category']), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('category.title');
            $show->field('required');
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
        return Form::make(Specification::with(['category']), function (Form $form) {
            $form->display('id');
            $form->text('name')->required();
            $form->select('category_id')->options(Category::where('parent_id', '!=', 0)->pluck('title', 'id'))->required();
            $form->radio('required')->options([1 => '是', 0 => '否'])->required();
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
