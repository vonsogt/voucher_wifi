<?php

namespace App\Admin\Controllers;

use App\Models\Router;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class RouterController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Router';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Router());

        // Order by `id` DESC
        $grid->model()->orderBy('id', 'desc');

        $grid->column('id', 'ID');
        $grid->column('name', 'Nama');
        $grid->column('ip_device', 'IP Perangkat');
        $grid->column('username', 'Username');
        $grid->column('password', 'Password');
        $grid->column('hotspot_name', 'Nama Hotspot');
        $grid->column('dns_name', 'Nama DNS');

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
        $show = new Show(Router::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('name', 'Nama');
        $show->field('ip_device', 'IP Perangkat');
        $show->field('username', 'Username');
        $show->field('password', 'Password');
        $show->field('hotspot_name', 'Nama Hotspot');
        $show->field('dns_name', 'Nama DNS');
        $show->field('created_at', trans('admin.created_at'));
        $show->field('updated_at', trans('admin.updated_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Router());

        $form->text('name', 'Nama');
        $form->ip('ip_device', 'IP Perangkat');
        $form->text('username', 'Username');
        $form->password('password', 'Password');
        $form->text('hotspot_name', 'Nama Hotspot');
        $form->text('dns_name', 'Nama DNS');

        return $form;
    }
}
