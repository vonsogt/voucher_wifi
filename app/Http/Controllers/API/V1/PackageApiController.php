<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageApiController extends Controller
{
    public function index()
    {
        $packages = Package::all()->pluck('name', 'id');

        return response()->json($packages);
    }
}
