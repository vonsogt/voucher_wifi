<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PackagePrice;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\InfoBox;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        // dump(config('theme'));
        return $content
            ->title('Dasbor')
            ->description('Voucher WiFi')
            // ->row(Dashboard::title())
            ->row(function (Row $row) {


                $row->column(3, function (Column $column) {
                    $count_admin_users = \DB::table('admin_users')->count();
                    $infoBox = new InfoBox('Total Admin', 'users', 'aqua', route('admin.auth.users.index'), $count_admin_users);

                    $column->append($infoBox);
                });

                $row->column(3, function (Column $column) {
                    $count_package_price = PackagePrice::count();
                    $infoBox = new InfoBox('Total Paket', 'cubes', 'green', route('admin.package-price.index'), $count_package_price);

                    $column->append($infoBox);
                });

                $row->column(3, function (Column $column) {
                    $count_admin_users = \DB::table('admin_users')->count();
                    $infoBox = new InfoBox('Total voucher sukses', 'credit-card', 'yellow', '/admin/users', $count_admin_users);

                    $column->append($infoBox);
                });

                $row->column(3, function (Column $column) {
                    $count_admin_users = \DB::table('admin_users')->count();
                    $infoBox = new InfoBox('Total Penjualan', 'money', 'red', '/admin/users', $count_admin_users);

                    $column->append($infoBox);
                });
            });
    }
}
