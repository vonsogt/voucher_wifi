<?php

namespace App\Observers;

use App\Jobs\ProcessVoucher;
use App\Models\Voucher;

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
        $this->enqueue($voucher);
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
        $details = [
            'email' => $voucher->costumer_email,
        ];

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
