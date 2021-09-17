<?php

namespace App\Admin\Controllers;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Router;
use App\Models\Voucher;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\InfoBox;
use \RouterOS\Client;
use \RouterOS\Query;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('Dasbor')
            ->description('Voucher WiFi')
            ->row(function (Row $row) {

                // Admin User's widgets
                $row->column(3, function (Column $column) {
                    $count_admin_users = \DB::table('admin_users')->count();
                    $infoBox = new InfoBox('Total Admin', 'users', 'aqua', route('admin.auth.users.index'), $count_admin_users);

                    $column->append($infoBox);
                });

                // Package's widgets
                $row->column(3, function (Column $column) {
                    $count_packages = Package::count();
                    $infoBox = new InfoBox('Total Paket', 'cubes', 'green', route('admin.packages.index'), $count_packages);

                    $column->append($infoBox);
                });

                // Voucher sold's widgets
                $row->column(3, function (Column $column) {
                    $count_vouchers = Voucher::where('payment_status', PaymentStatus::SudahBayar())->count();
                    $infoBox = new InfoBox('Total Voucher Terjual', 'credit-card', 'yellow', '/admin/users', $count_vouchers);

                    $column->append($infoBox);
                });

                // Voucher Sell's widgets
                $row->column(3, function (Column $column) {
                    $sum_voucher_sells = Voucher::where('payment_status', PaymentStatus::SudahBayar())->with('package')->get()->sum('package.price');
                    $infoBox = new InfoBox('Total Penjualan', 'money', 'red', '/admin/users', 'Rp' . number_format($sum_voucher_sells));

                    $column->append($infoBox);
                });
            });
            // ->row(function (Row $row) {
            //     // Pilih router dari config
            //     $router = Router::where('name', config('active_router'))->first();

            //     // Initiate client with config object
            //     $client = new Client([
            //         'host' => $router->ip_device,
            //         'user' => $router->username,
            //         'pass' => $router->password,
            //         'port' => 8728,
            //     ]);

            //     // Build query for details about user profile
            //     $query = new Query('/ip/hotspot/user/print');

            //     // Send query and read response from RouterOS
            //     $response = $client->query($query)->read();

            //     dump($response);
            // });
    }
}
