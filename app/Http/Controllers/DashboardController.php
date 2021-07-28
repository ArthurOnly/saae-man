<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $mapsKey = config('app.maps_api_key');
        $allOperations = Operation::where('archived', 0)->get()->toArray();
        $userType = Auth::user()->type;
        return view("dashboard", ["maps_key" => $mapsKey, "all_operations" => $allOperations, "userType" => $userType]);
    }
}
