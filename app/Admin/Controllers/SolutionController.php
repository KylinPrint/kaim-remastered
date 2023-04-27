<?php

namespace App\Admin\Controllers;

use App\Models\Solution;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class SolutionController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Solution(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('peripheral_id');
            $grid->column('chip_id');
            $grid->column('distribution_id');
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
        return Show::make($id, new Solution(), function (Show $show) {
            $show->field('id');
            $show->field('peripheral_id');
            $show->field('chip_id');
            $show->field('distribution_id');
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
        return Form::make(new Solution(), function (Form $form) {
            $form->display('id');
            $form->text('peripheral_id');
            $form->text('chip_id');
            $form->text('distribution_id');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
