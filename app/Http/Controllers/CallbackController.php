<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Models\Voucher;
use Illuminate\Http\Request;

class CallbackController extends Controller
{
    public function voucherPayment(Request $request)
    {
        // ambil callback signature
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE') ?? '';

        // ambil data JSON
        $json = $request->getContent();

        $merchantCode = env('TRIPAY_MERCHANT_CODE', 'kode_merchant_anda');
        $merchantRef = json_decode($json)->merchant_ref;
        $amount = json_decode($json)->amount_received;

        // generate signature untuk dicocokkan dengan X-Callback-Signature
        // $signature = hash_hmac('sha256', $json, env('TRIPAY_PRIVATE_KEY', 'private_key_anda'));
        $signature = hash_hmac('sha256', $merchantCode . $merchantRef . $amount, env('TRIPAY_PRIVATE_KEY', 'private_key_anda'));

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
                $voucher->save();

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
}
