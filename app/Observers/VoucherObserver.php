<?php

namespace App\Observers;

use App\Jobs\ProcessVoucher;
use App\Models\Voucher;
use Illuminate\Support\Facades\Http;

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
        $this->closedPaymentTransaction($voucher);
        $this->enqueue($voucher);
    }

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
            'customer_name'     => $voucher->costumer_email,
            'customer_email'    => $voucher->costumer_email,
            'order_items'       => [
                [
                    'sku'       => 'PAKET' . $voucher->package->id,
                    'name'      => $voucher->package->name,
                    'price'     => $amount,
                    'quantity'  => 1
                ]
            ],
            'callback_url'      => env('TRIPAY_CALLBACK_URL'),
            'return_url'        => env('TRIPAY_RETURN_URL'),
            'expired_time'      => (time() + (24 * 60 * 60)), // 24 jam
            'signature'         => hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey)
        ];

        $response = Http::withToken($apiKey)->post(env('TRIPAY_CLOSED_PAYMENT_URL'), $data);

        return $response;
    }

    /**
     * enqueue
     *
     * @param $voucher
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function enqueue($voucher)
    {
        $details = ['email' => $voucher->costumer_email];

        ProcessVoucher::dispatch($details);
    }

    /**
     * Generate random string
     *
     * @param  mixed $length
     * @return void
     */
    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++)
            $randomString .= $characters[rand(0, $charactersLength - 1)];

        return $randomString;
    }
}
