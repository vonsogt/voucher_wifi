<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Models\Router;
use App\Models\Voucher;
use Illuminate\Http\Request;
use \RouterOS\Client;
use \RouterOS\Query;

class CallbackController extends Controller
{
    public function voucherPayment(Request $request)
    {
        // ambil callback signature
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE') ?? '';

        // ambil data JSON
        $json = $request->getContent();

        // generate signature untuk dicocokkan dengan X-Callback-Signature
        $signature = hash_hmac('sha256', $json, env('TRIPAY_PRIVATE_KEY', 'private_key_anda'));

        // validasi signature
        if ($callbackSignature !== $signature) {
            return "Invalid Signature"; // signature tidak valid, hentikan proses
        }

        $data = json_decode($json);
        $event = $request->server('HTTP_X_CALLBACK_EVENT');

        if ($event == 'payment_status') {
            $merchantRef = $data->merchant_ref; // INV00000001
            $id = ltrim(str_replace('INV', '', $merchantRef), '0'); // 1

            // pembayaran sukses, lanjutkan proses sesuai sistem Anda, contoh:
            $voucher = Voucher::where('id', $id)
                ->where('payment_status', PaymentStatus::BelumBayar())
                ->first();

            if (!$voucher) {
                return "Order not found or current status is not UNPAID";
            }

            // Lakukan validasi nominal
            if (intval($data->total_amount) !== intval($voucher->package->price) + $data->total_fee) {
                return "Invalid amount";
            }

            if ($data->status == 'PAID') // handle status PAID
            {
                $voucher->payment_status = PaymentStatus::SudahBayar();
                $voucher->payment_date = now();
                $voucher->save();

                // $this->addUserToRouter($voucher);

                return response()->json([
                    'success' => true
                ]);
            } elseif ($data->status == 'EXPIRED') // handle status EXPIRED
            {
                $voucher->payment_status = PaymentStatus::Kadaluarsa();
                $voucher->save();

                return response()->json([
                    'success' => true
                ]);
            } elseif ($data->status == 'FAILED') // handle status FAILED
            {
                $voucher->payment_status = PaymentStatus::Gagal();
                $voucher->save();

                return response()->json([
                    'success' => true
                ]);
            }
        }

        return "No action was taken";
    }

    public function addUserToRouter($data)
    {
        // Pilih router dari config
        $router = Router::where('name', config('active_router'))->first();

        // Initiate client with config object
        $client = new Client([
            'host' => $router->ip_device,
            'user' => $router->username,
            'pass' => $router->password,
            'port' => 8728,
        ]);

        dump($client);

        // Akun voucher atau user biasa
        $user_mode = $data->username === $data->password ? 'vc-' : 'up-';

        // Build query for creating new user
        // $query =
        //     (new Query('/ip/hotspot/user/profile/add'))
        //     ->equal('name', 'test-' . $i);

        // Build query for details about user profile
        $query = new Query('/ip/hotspot/user/add', [
            'name'              => $data->username,
            'password'          => $data->password,
            'disabled'          => 'no',
            'limit-uptime'      => 0, // TODO
            'comment'           => $user_mode,
        ]);

        // Send query and read response from RouterOS
        $response = $client->query($query)->read();

        dd($response);
    }
}
