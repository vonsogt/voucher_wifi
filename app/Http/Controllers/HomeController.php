<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['packages'] = Package::all();

        return view('index', compact('data'));
    }

    public function about()
    {
        return view('about');
    }
}
