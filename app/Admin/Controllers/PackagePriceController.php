<?php

namespace App\Admin\Controllers;

use App\Models\PackagePrice;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class PackagePriceController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Harga Paket')
            ->description(trans('admin.list'))
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Harga Paket')
            ->description(trans('admin.show'))
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Harga Paket')
            ->description(trans('admin.edit'))
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Harga Paket')
            ->description(trans('admin.create'))
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PackagePrice);

        $grid->id('ID');
        $grid->name('Nama');
        $grid->price('Harga');
        $grid->created_at(trans('admin.created_at'))->display(function ($created_at) {
            return Carbon::make($created_at)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s');
        });
        $grid->updated_at(trans('admin.updated_at'))->display(function ($updated_at) {
            return Carbon::make($updated_at)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s');
        });

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
        $show = new Show(PackagePrice::findOrFail($id));

        $show->id('ID');
        $show->name('name');
        $show->price('price');
        $show->notes('notes');
        $show->created_at(trans('admin.created_at'));
        $show->updated_at(trans('admin.updated_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PackagePrice);

        if ($form->isEditing())
            $form->display('ID');

        $form->text('name', 'Nama');
        $form->text('price', 'Harga')->icon('fa-dollar');
        $form->textarea('notes', 'Catatan');

        if ($form->isEditing()) {
            $form->display(trans('admin.created_at'));
            $form->display(trans('admin.updated_at'));
        }

        return $form;
    }
}
