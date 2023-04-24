<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Brand;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class BrandController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Brand(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name')->display(function () {
                if ($this->subname) {
                    return $this->name . '(' . $this->subname . ')';
                } else {
                    return $this->name;
                }
                
                
            });
            // $grid->column('subname');
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
        return Show::make($id, new Brand(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('subname');
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
        return Form::make(new Brand(), function (Form $form) {
            $form->display('id');
            $form->text('name')->required();
            $form->text('subname');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
