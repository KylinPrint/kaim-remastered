<?php

namespace App\Admin\Controllers;

use App\Models\Distribution;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class DistributionController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Distribution(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('abbr');
            $grid->column('release');
            $grid->column('eosl');
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
        return Show::make($id, new Distribution(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('abbr');
            $show->field('release');
            $show->field('eosl');
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
        return Form::make(new Distribution(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('abbr');
            $form->text('release');
            $form->text('eosl');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
