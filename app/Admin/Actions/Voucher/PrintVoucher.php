<?php

namespace App\Admin\Actions\Voucher;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class PrintVoucher extends RowAction
{
    public $name = 'Print';

    public function handle(Model $model)
    {
        return $this->response()->open(route('admin.voucher-print', ['id' => $model->id]));
    }
}
