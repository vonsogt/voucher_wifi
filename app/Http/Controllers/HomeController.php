<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $data['payment_methods'] = $this->paymentMethods();

        // Ambil daftar paket dari database
        $data['packages'] = Package::all();

        // Return view index with $data
        return view('index', compact('data'));
    }

    /**
     * about
     *
     * @return void
     */
    public function about()
    {
        return view('about');
    }

    /**
     * paymentMethods
     *
     * @return array
     */
    public function paymentMethods() : array
    {
        $payment_methods = [
            json_decode(collect([
                'group'         => null,
                'code'          => 'TUNAI',
                'name'          => 'Tunai',
                'type'          => 'direct',
                'fee_merchant'  => [
                    'flat'      => 0,
                    'percent'   => '0.00',
                ],
                'fee_customer'  => [
                    'flat'      => 0,
                    'percent'   => '0.00',
                ],
                'total_fee'     => [
                    'flat'      => 0,
                    'percent'   => '0.00',
                ],
                'active'        => true
            ])),
        ];

        // Ambil semua metode pembayaran yang ada di TriPay
        try {
            $response = json_decode(Http::withToken(env('TRIPAY_API_KEY', 'api_key_anda'))
                ->get(env('TRIPAY_PAYMENT_CHANNEL_URL', 'https://tripay.co.id/api-sandbox/merchant/payment-channel'))
                ->body());

            foreach ($response->data as $payment_method) {
                // Take only active status
                if ($payment_method->active)
                    $payment_methods[] = $payment_method;
            }
        } catch (\Throwable $th) {
            // throw $th;
            \Log::error($th);
        }

        return $payment_methods;
    }
}
