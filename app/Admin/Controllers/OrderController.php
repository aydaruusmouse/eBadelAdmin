<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Order;

class OrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Order';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order());

        $grid->column('Order_Id', __('Order Id'));
        $grid->column('User_Profile_Id', __('User Profile Id'));
        $grid->column('Origin_Wallet', __('Origin Wallet'));
        $grid->column('Destination_Wallet', __('Destination Wallet'));
        $grid->column('Sender_Account', __('Sender Account'));
        $grid->column('Recipient_Account', __('Recipient Account'));
        $grid->column('Origin_Currency', __('Origin Currency'));
        $grid->column('Destination_Currency', __('Destination Currency'));
        $grid->column('Amount', __('Amount'));
        $grid->column('Bridge_Fee', __('Bridge Fee'));
        $grid->column('Debit_Response', __('Debit Response'));
        $grid->column('Credit_Response', __('Credit Response'));
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
        $show = new Show(Order::findOrFail($id));

        $show->field('Order_Id', __('Order Id'));
        $show->field('User_Profile_Id', __('User Profile Id'));
        $show->field('Origin_Wallet', __('Origin Wallet'));
        $show->field('Destination_Wallet', __('Destination Wallet'));
        $show->field('Sender_Account', __('Sender Account'));
        $show->field('Recipient_Account', __('Recipient Account'));
        $show->field('Origin_Currency', __('Origin Currency'));
        $show->field('Destination_Currency', __('Destination Currency'));
        $show->field('Amount', __('Amount'));
        $show->field('Bridge_Fee', __('Bridge Fee'));
        $show->field('Debit_Response', __('Debit Response'));
        $show->field('Credit_Response', __('Credit Response'));
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
        $form = new Form(new Order());

        $form->number('User_Profile_Id', __('User Profile Id'));
        $form->text('Origin_Wallet', __('Origin Wallet'));
        $form->text('Destination_Wallet', __('Destination Wallet'));
        $form->text('Sender_Account', __('Sender Account'));
        $form->text('Recipient_Account', __('Recipient Account'));
        $form->text('Origin_Currency', __('Origin Currency'));
        $form->text('Destination_Currency', __('Destination Currency'));
        $form->decimal('Amount', __('Amount'));
        $form->decimal('Bridge_Fee', __('Bridge Fee'));
        $form->text('Debit_Response', __('Debit Response'));
        $form->text('Credit_Response', __('Credit Response'));
        $form->text('Status', __('Status'));

        return $form;
    }
}
