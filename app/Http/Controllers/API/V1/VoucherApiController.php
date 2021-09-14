<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherApiController extends Controller
{
    public function buyVoucher(Request $request)
    {
        $voucher = new Voucher();

        $voucher->package_id = $request->package_id;
        $voucher->costumer_email = $request->costumer_email;

        $voucher->save();

        return response()->json(['status' => true, 'msg' => 'Voucher berhasil dipesan, silahkan cek email untuk pembayaran.']);
    }
}
