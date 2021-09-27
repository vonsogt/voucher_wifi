<?php

namespace App\Observers;

use App\Enums\PaymentStatus;
use App\Jobs\ProcessVoucher;
use App\Models\Router;
use App\Models\Voucher;
use Illuminate\Support\Facades\Http;
use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Query;

class VoucherObserver
{
    /**
     * Handle the Voucher "creating" event.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return void
     */
    public function creating(Voucher $voucher)
    {
        $rand_string = $this->generateRandomString(8);
        $voucher->username = $rand_string;
        $voucher->password = $rand_string;
    }

    /**
     * Handle the Voucher "created" event.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return void
     */
    public function created(Voucher $voucher)
    {
        // Add transaction
        if ($voucher->payment_method == 'TUNAI')
            $this->cashPaymentTransaction($voucher);
        else
            $this->closedPaymentTransaction($voucher);

        // Add username & password to connected Router
        if ($voucher->payment_status == PaymentStatus::SudahBayar())
            $this->addUserToRouter($voucher);
    }

    /**
     * Handle the Voucher "updated" event.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return void
     */
    public function updated(Voucher $voucher)
    {
        // Add username & password to connected Router
        if ($voucher->payment_status == PaymentStatus::SudahBayar())
            $this->addUserToRouter($voucher);
    }

    /**
     * closedPaymentTransaction
     *
     * @param  mixed $voucher
     * @return void
     */
    public function closedPaymentTransaction($voucher)
    {
        $apiKey = env('TRIPAY_API_KEY', 'api_key_anda');
        $privateKey = env('TRIPAY_PRIVATE_KEY', 'private_key_anda');
        $merchantCode = env('TRIPAY_MERCHANT_CODE', 'kode_merchant_anda');
        $merchantRef = 'INV' . str_pad($voucher->id, 8, '0', STR_PAD_LEFT); // INV00000001
        $amount = $voucher->package->price;

        $data = [
            'method'            => $voucher->payment_method,
            'merchant_ref'      => $merchantRef,
            'amount'            => $amount,
            'customer_name'     => $voucher->customer_email,
            'customer_email'    => $voucher->customer_email,
            'order_items'       => [
                [
                    'sku'       => 'PAKET' . $voucher->package->id,
                    'name'      => $voucher->package->name,
                    'price'     => $amount,
                    'quantity'  => 1
                ]
            ],
            'callback_url'      => env('TRIPAY_CALLBACK_URL', 'callback_url_anda'),
            'return_url'        => env('TRIPAY_RETURN_URL', 'return_url_anda'),
            'expired_time'      => (time() + (24 * 60 * 60)), // 24 jam
            'signature'         => hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey)
        ];

        $response = Http::withToken($apiKey)->post(env('TRIPAY_CLOSED_PAYMENT_URL', 'closed_payment_url_anda'), $data);
        $body = json_decode($response->body());

        // Send notification
        if ($body->success) {
            $body->data->voucher_code = $voucher->username;
            ProcessVoucher::dispatch($body->data);
        }

        return $body;
    }

    public function cashPaymentTransaction($voucher)
    {
        $data['customer_email'] = $voucher->customer_email;
        $data['payment_name'] = $voucher->payment_method;
        $data['fee_customer'] = 0;
        $data['pay_code'] = 'INV' . str_pad($voucher->id, 8, '0', STR_PAD_LEFT);
        $data['order_items'] = [
            [
                'sku'       => 'PAKET' . $voucher->package->id,
                'name'      => $voucher->package->name,
                'price'     => $voucher->package->price,
                'quantity'  => 1
            ]
        ];
        $data['voucher_code'] = $voucher->username;
        $data['instructions'] = [
            [
                'title' => 'Datang ke merchant',
                'steps' => [
                    'Datang ke merchant yang didukung',
                    'Perlihatkan kode pembayaran',
                    'Kasih uang tunai sesuai dengan harga voucher',
                    'Transaksi sukses, anda akan diberikan lembaran voucher'
                ]
            ]
        ];

        ProcessVoucher::dispatch(json_decode(collect($data)));
    }

    /**
     * Generate random string
     *
     * @param  mixed $length
     * @return void
     */
    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++)
            $randomString .= $characters[rand(0, $charactersLength - 1)];

        return $randomString;
    }

    /**
     * addUserToRouter
     *
     * @param  mixed $data
     * @return void
     */
    public function addUserToRouter($voucher)
    {
        // Pilih router dari config
        $router = Router::where('name', config('active_router'))->first();

        // Add category to comment (optional)
        $user_mode = $voucher->username === $voucher->password ? 'vc-' : 'up-';

        // Create config object with parameters
        $config =
            (new Config())
            ->set('host', $router->ip_device)
            ->set('port', 8728)
            ->set('pass', $router->password)
            ->set('user', $router->username);

        // Initiate client with config object
        $client = new Client($config);

        // Build query for details about user profile
        $query = (new Query('/ip/hotspot/user/add'))
            ->equal("name", $voucher->username)
            ->equal("password", $voucher->password)
            ->equal("limit-uptime", $voucher->package->time_limit)
            ->equal("comment", $user_mode);

        // Add user
        $out = $client->query($query)->read();

        return $out;
    }
}
