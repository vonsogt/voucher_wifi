<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Voucher\PrintVoucher;
use App\Enums\PaymentStatus;
use App\Models\Package;
use App\Models\Voucher;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Request;

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

        // Order by `id` DESC
        $grid->model()->orderBy('id', 'desc');

        $grid->column('id', 'ID');
        $grid->column('package.name', 'Paket');
        $grid->column('package.price', 'Harga Paket')->display(function ($val) {
            return 'Rp' . number_format($val, 2);
        });
        $grid->column('username', 'Username Voucher');
        $grid->column('password', 'Password Voucher');
        $grid->column('customer_email', 'Email Pelanggan');
        $grid->column('payment_method', 'Metode Pembayaran');
        $grid->column('payment_status', 'Status Pembayaran')->display(function ($payment_status) {
            return PaymentStatus::getDescription($payment_status);
        })->label([
            PaymentStatus::getValue('BelumBayar') => 'info',
            PaymentStatus::getValue('SudahBayar') => 'success',
            PaymentStatus::getValue('Kadaluarsa') => 'default',
            PaymentStatus::getValue('Dikembalikan') => 'warning',
            PaymentStatus::getValue('Gagal') => 'danger',
        ]);
        $grid->column('payment_date', 'Tanggal Pembayaran');

        $grid->actions(function ($actions) {
            $actions->add(new PrintVoucher);
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
        $show->field('package.name', 'Paket');
        $show->field('package.price', 'Harga Paket')->as(function ($val) {
            return 'Rp' . number_format($val, 2);
        });;
        $show->field('username', 'Username Voucher');
        $show->field('password', 'Password Voucher');
        $show->field('customer_email', 'Email Pelanggan');
        $show->field('payment_method', 'Metode Pembayaran');
        $show->field('payment_status', 'Status Pembayaran')->as(function ($payment_status) {
            return PaymentStatus::getDescription($payment_status);
        });
        $show->field('payment_date', 'Tanggal Pembayaran');
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
        $form = new Form(new Voucher());

        $home = new \App\Http\Controllers\HomeController;
        $payment_methods = $home->paymentMethods();

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
        $form->text('customer_email', 'Email Pelanggan')->required();
        $form->select('payment_method', 'Metode Pembayaran')
            ->options(function () use ($payment_methods) {
                $options = [];
                foreach ($payment_methods as $payment_method) {
                    $options[$payment_method->code] = $payment_method->name;
                }

                return $options;
            })->rules('required', ['required' => 'Metode pembayaran wajib di isi.']);
        $form->datetime('payment_date', 'Tanggal Pembayaran')
            ->rules('required_if:payment_status,' . PaymentStatus::SudahBayar(), ['required_if' => 'Tanggal pembayaran wajib di isi jika status sudah dibayar.']);
        $form->radio('payment_status', 'Status Pembayaran')->options(PaymentStatus::asSelectArray())->stacked()->required();

        if ($form->isEditing()) {
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        }

        return $form;
    }

    /**
     * voucherPrint
     *
     * @param  mixed $request
     * @return void
     */
    public function voucherPrint(Request $request)
    {
        $voucher = Voucher::findOrFail($request->id);

        return view('admin.vouchers.print', compact('voucher'));
    }
}
