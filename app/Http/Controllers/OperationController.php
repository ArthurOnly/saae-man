<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class OperationController extends Controller
{
    public function index($operationNumber = null){
        $operation = [];
        $address = null;
        if ($operationNumber){
            $operation = Operation::firstWhere('order', $operationNumber);
            $inputAddress = explode("-", $operation->address)[0];
            $address = explode(",", $inputAddress);
        }

        return view("registerOperation", ["operation" => $operation, 'address' => $address]);
    }

    public function archived(){
        $allOperations = DB::table('operations')
            ->join('services', 'operations.id', '=', 'services.operation_id')
            ->join('users', 'users.id', '=', 'services.user_id')
            ->select('operations.order', 'operations.address', 'users.email', 'services.created_at')
            ->get()->toArray();
        $userType = Auth::user()->type;
        return view("archivedOpearations", ["all_operations" => $allOperations, "userType" => $userType]);
    }

    public function create(Request $request){
        
        $lat = 0; 
        $long = 0;
        if (empty($request->lat) or empty($request->long)){
            $addressFull = "$request->street $request->number, Ceará-Mirim - Rio Grande do Norte,, Brazil";
            $apiKey = config("app.position_api_key");
            $url = "http://api.positionstack.com/v1/forward?access_key=$apiKey&query=$addressFull";
            
            $responseLocation = Http::get($url)->json();
            $lat = $responseLocation['data'][0]['latitude'];
            $long = $responseLocation['data'][0]['longitude'];
        } else{
            $lat = $request->lat;
            $long = $request->long;
        } 
        

        $data = [
            "order" => $request->order,
            "subscription" => $request->subscription,
            "lat" => $lat,
            "long" => $long,
            "order" => $request->order,
            "address" => $request->street.",".$request->number." - CEARA MIRIM/RN",
            "completed" => false
        ];
        
        Operation::create($data);
        
        return redirect('/')->with('message', ["type" => "success", "text" => "Criado com sucesso"]);;
    }

    public function update(Request $request){
        $operation = Operation::firstWhere('order', $request->order);

        $data = [
            "order" => $request->order,
            "subscription" => $request->subscription,
            "lat" => $request->lat,
            "long" => $request->long,
            "order" => $request->order,
            "address" => $request->street.",".$request->number." - CEARA MIRIM/RN",
        ];

        $operation->fill($data);
        $operation->save();
        return redirect('/')->with('message', ["type" => "success", "text" => "Alterado com sucesso"]);;
    }

    public function finish($order){
        return view("finishOperation", ["order" => $order]);
    }

    public function archive($order){
        $operation = Operation::firstWhere('order', $order);
        if ($operation->completed == 1){
            $operation->archived = 1;
            $operation->save();
        }

        return redirect('/')->with('message', ["type" => "success", "text" => "Arquivado com sucesso"]);
    }

    public function finishHandler($order){
        $operation = Operation::firstWhere('order', $order);
        $operation->completed = 1;
        $operation->save();

        $data = [
            "user_id" => Auth::user()->id,
            "operation_id" => $operation->id
        ];

        Service::create($data);

        return redirect('/')->with('message', ["type" => "success", "text" => "Finalizado com sucesso"]);;
    }
}
