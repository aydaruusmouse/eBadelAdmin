<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\WalletProfile;

class WalletProfileController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'WalletProfile';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WalletProfile());

        $grid->column('Wallet_Id', __('Wallet Id'));
        $grid->column('Wallet_Name', __('Wallet Name'));
        $grid->column('Wallet_Provider', __('Wallet Provider'));
        $grid->column('Wallet_Type', __('Wallet Type'));
        $grid->column('Wallet_Logo', __('Wallet Logo'));
        $grid->column('Merchant_Number', __('Merchant Number'));
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
        $show = new Show(WalletProfile::findOrFail($id));

        $show->field('Wallet_Id', __('Wallet Id'));
        $show->field('Wallet_Name', __('Wallet Name'));
        $show->field('Wallet_Provider', __('Wallet Provider'));
        $show->field('Wallet_Type', __('Wallet Type'));
        $show->field('Wallet_Logo', __('Wallet Logo'));
        $show->field('Merchant_Number', __('Merchant Number'));
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
        $form = new Form(new WalletProfile());

        $form->text('Wallet_Name', __('Wallet Name'));
        $form->text('Wallet_Provider', __('Wallet Provider'));
        $form->text('Wallet_Type', __('Wallet Type'));
        $form->text('Wallet_Logo', __('Wallet Logo'));
        $form->text('Merchant_Number', __('Merchant Number'));
        $form->text('Status', __('Status'));

        return $form;
    }
}
