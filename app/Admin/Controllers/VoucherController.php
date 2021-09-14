<?php

namespace App\Admin\Controllers;

use App\Enums\PaymentStatus;
use App\Models\Package;
use App\Models\Voucher;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VoucherController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Voucher';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Voucher());

        $grid->column('id', 'ID');
        $grid->column('package.name', 'Paket');
        $grid->column('username', 'Username Voucher');
        $grid->column('password', 'Password Voucher');
        $grid->column('costumer_email', 'Email Kostumer');
        $grid->column('payment_date', 'Tanggal Pembayaran');
        $grid->column('payment_status', 'Status Pembayaran')->display(function ($payment_status) {
            return PaymentStatus::getDescription($payment_status);
        })->label([
            PaymentStatus::getValue('BelumBayar') => 'info',
            PaymentStatus::getValue('SudahBayar') => 'success',
            PaymentStatus::getValue('Kadaluarsa') => 'default',
            PaymentStatus::getValue('Dikembalikan') => 'warning',
            PaymentStatus::getValue('Gagal') => 'danger',
        ]);
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
        $show = new Show(Voucher::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('package_id', __('Package id'));
        $show->field('username', __('Username'));
        $show->field('password', __('Password'));
        $show->field('costumer_email', __('Costumer email'));
        $show->field('payment_date', __('Payment date'));
        $show->field('payment_status', __('Payment status'));
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
        $form = new Form(new Voucher());

        if ($form->isEditing()) {
            $form->display('id', 'ID');
        } else {
            // Add info card
            $form->html('
                <div class="callout callout-info">
                    <h4>Info!</h4>
                    <p><code>username</code> dan <code>password</code> akan dibuat secara otomatis.</p>
                </div>
            ');
        }

        $form->select('package_id', 'Paket')->options(Package::get()->pluck('name', 'id'))->required();
        if ($form->isEditing()) {
            $form->display('username');
            $form->display('password');
        } else {
            $form->hidden('username');
            $form->hidden('password');
        }
        $form->text('costumer_email', 'Email Kostumer')->required();
        $form->datetime('payment_date', 'Tanggal Pembayaran')->rules('required_if:payment_status,' . PaymentStatus::SudahBayar(), ['required_if' => 'Tanggal pembayaran wajib di isi jika status sudah dibayar.']);
        $form->radio('payment_status', 'Status Pembayaran')->options(PaymentStatus::asSelectArray())->stacked()->required();

        if ($form->isEditing()) {
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        }

        return $form;
    }
}
