<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $mapsKey = config('app.maps_api_key');
        $allOperations = Operation::all()->toArray();
        return view("dashboard", ["maps_key" => $mapsKey, "all_operations" => $allOperations]);
    }
}
