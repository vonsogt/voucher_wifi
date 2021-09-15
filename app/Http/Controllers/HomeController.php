<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua metode pembayaran yang ada di TriPay
        $response = json_decode(Http::withToken(env('TRIPAY_API_KEY', 'api_key_anda'))
            ->get(env('TRIPAY_PAYMENT_CHANNEL_URL', 'https://tripay.co.id/api-sandbox/merchant/payment-channel'))
            ->body());

        $data['payment_methods'] = $response->success ? $response->data : [];

        // Pilih metode pembayaran yang kita mau, Kode ada disini: https://tripay.co.id/developer?tab=channels
        $data['support_payment_method'] = ['BCAVA', 'ALFAMART'];

        // Ambil daftar paket dari database
        $data['packages'] = Package::all();

        // Return view index with $data
        return view('index', compact('data'));
    }

    public function about()
    {
        return view('about');
    }
}
