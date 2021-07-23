<?php

namespace App\Http\Controllers;

use App\Models\operation;
use Illuminate\Http\Request;

class OperationController extends Controller
{
    public function index(){
        return view("registerOperation");
    }

    public function create(Request $request){
        $data = [
            "order" => $request->order,
            "subscription" => $request->subscription,
            "lat" => 0,
            "long" => 0,
            "order" => $request->order,
            "address" => $request->street.",".$request->number." - CEARA MIRIM/RN",
            "completed" => false
        ];
        $operation = Operation::create($data);
        dd($operation);
    }
}
