<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\UserWalletAccount;

class UserWalletAccountController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'UserWalletAccount';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserWalletAccount());

        $grid->column('User_Wallet_Account_Id', __('User Wallet Account Id'));
        $grid->column('User_Profile_Id', __('User Profile Id'));
        $grid->column('Wallet_Id', __('Wallet Id'));
        $grid->column('Status', __('Status'));
        $grid->column('Account_Number', __('Account Number'));
        $grid->column('Account_Name', __('Account Name'));
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
        $show = new Show(UserWalletAccount::findOrFail($id));

        $show->field('User_Wallet_Account_Id', __('User Wallet Account Id'));
        $show->field('User_Profile_Id', __('User Profile Id'));
        $show->field('Wallet_Id', __('Wallet Id'));
        $show->field('Status', __('Status'));
        $show->field('Account_Number', __('Account Number'));
        $show->field('Account_Name', __('Account Name'));
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
        $form = new Form(new UserWalletAccount());

        $form->number('User_Profile_Id', __('User Profile Id'));
        $form->number('Wallet_Id', __('Wallet Id'));
        $form->text('Status', __('Status'));
        $form->text('Account_Number', __('Account Number'));
        $form->text('Account_Name', __('Account Name'));

        return $form;
    }
}
