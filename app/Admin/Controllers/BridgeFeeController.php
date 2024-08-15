<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\BridgeFee;

class BridgeFeeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'BridgeFee';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new BridgeFee());

        $grid->column('Bridge_Fee_Id', __('Bridge Fee Id'));
        $grid->column('Origin_Wallet', __('Origin Wallet'));
        $grid->column('Destination_Wallet', __('Destination Wallet'));
        $grid->column('Origin_Currency', __('Origin Currency'));
        $grid->column('Destination_Currency', __('Destination Currency'));
        $grid->column('Fee_Percentage', __('Fee Percentage'));
        $grid->column('Calculation_Method', __('Calculation Method'));
        $grid->column('Status', __('Status'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(BridgeFee::findOrFail($id));

        $show->field('Bridge_Fee_Id', __('Bridge Fee Id'));
        $show->field('Origin_Wallet', __('Origin Wallet'));
        $show->field('Destination_Wallet', __('Destination Wallet'));
        $show->field('Origin_Currency', __('Origin Currency'));
        $show->field('Destination_Currency', __('Destination Currency'));
        $show->field('Fee_Percentage', __('Fee Percentage'));
        $show->field('Calculation_Method', __('Calculation Method'));
        $show->field('Status', __('Status'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new BridgeFee());

        $form->text('Origin_Wallet', __('Origin Wallet'));
        $form->text('Destination_Wallet', __('Destination Wallet'));
        $form->text('Origin_Currency', __('Origin Currency'));
        $form->text('Destination_Currency', __('Destination Currency'));
        $form->decimal('Fee_Percentage', __('Fee Percentage'));
        $form->text('Calculation_Method', __('Calculation Method'));
        $form->text('Status', __('Status'));

        return $form;
    }
}
