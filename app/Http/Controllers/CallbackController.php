<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Models\Router;
use App\Models\Voucher;
use Illuminate\Http\Request;
use \RouterOS\Client;
use RouterOS\Config;
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

                $this->addUserToRouter($voucher);

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

        // Add category to comment (optional)
        $user_mode = $data->username === $data->password ? 'vc-' : 'up-';

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
            ->equal("name", $data->username)
            ->equal("password", $data->password)
            ->equal("limit-uptime", $data->time_limit)
            ->equal("comment", $user_mode);

        // Add user
        $out = $client->query($query)->read();

        return $out;
    }
}
