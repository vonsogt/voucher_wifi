<?php

namespace App\Http\Controllers;

use App\Models\PackagePrice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['package_prices'] = PackagePrice::all();

        return view('index', compact('data'));
    }
}
