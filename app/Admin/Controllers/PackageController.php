<?php

namespace App\Admin\Controllers;

use App\Models\Package;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class PackageController extends Controller
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
            ->header('Paket')
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
            ->header('Paket')
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
            ->header('Paket')
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
            ->header('Paket')
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
        $grid = new Grid(new Package);

        // Order by `id` DESC
        $grid->model()->orderBy('id', 'desc');

        $grid->id('ID');
        $grid->name('Nama');
        $grid->price('Harga')->display(function ($val) {
            return 'Rp' . number_format($val, 2);
        });
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
        $show = new Show(Package::findOrFail($id));

        $show->id('ID');
        $show->name('Nama');
        $show->price('Harga')->as(function ($val) {
            return 'Rp' . number_format($val, 2);
        });;
        $show->notes('Catatan');
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
        $form = new Form(new Package);

        if ($form->isEditing())
            $form->display('id', 'ID');

        $form->text('name', 'Nama');
        $form->text('price', 'Harga')->icon('fa-dollar');
        $form->text('time_limit', 'Batas Waktu')->help('[wdhm] Example : 30d = 30days; 12h = 12hours; 30m = 30minutes; 5h30m = 5hours 30minutes');
        $form->image('featured_image', 'Gambar')->removable();;
        $form->textarea('notes', 'Catatan');

        if ($form->isEditing()) {
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        }

        return $form;
    }
}
