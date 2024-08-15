<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\User;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('User_Profile_Id', __('User Profile Id'));
        $grid->column('Login_Phone', __('Login Phone'));
        $grid->column('First_Name', __('First Name'));
        $grid->column('Last_Name', __('Last Name'));
        $grid->column('Gender', __('Gender'));
        $grid->column('Date_of_Birth', __('Date of Birth'));
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
        $show = new Show(User::findOrFail($id));

        $show->field('User_Profile_Id', __('User Profile Id'));
        $show->field('Login_Phone', __('Login Phone'));
        $show->field('First_Name', __('First Name'));
        $show->field('Last_Name', __('Last Name'));
        $show->field('Gender', __('Gender'));
        $show->field('Date_of_Birth', __('Date of Birth'));
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
        $form = new Form(new User());

        $form->number('User_Profile_Id', __('User Profile Id'));
        $form->text('Login_Phone', __('Login Phone'));
        $form->text('First_Name', __('First Name'));
        $form->text('Last_Name', __('Last Name'));
        $form->text('Gender', __('Gender'));
        $form->date('Date_of_Birth', __('Date of Birth'))->default(date('Y-m-d'));

        return $form;
    }
}
