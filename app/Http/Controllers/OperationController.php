<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use App\Models\OperationType;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class OperationController extends Controller
{
    public function index($id = null){
        $operation = [];
        $address = null;
        $operation_types = OperationType::all()->toArray();
        if ($id){
            $operation = Operation::find($id);
            $inputAddress = explode("-", $operation->address)[0];
            $address = explode(",", $inputAddress);
        }
        return view("registerOperation", ["operation" => $operation, 'address' => $address, "operation_types" => $operation_types]);
    }

    public function archived(){
        $allOperations = DB::table('operations')
            ->join('services', 'operations.id', '=', 'services.operation_id')
            ->join('users', 'users.id', '=', 'services.user_id')
            ->join("operation_types", "operation_types.id", "=", "operations.operation_type")
            ->select('operations.order', 'operations.address', 'users.email', 'services.created_at', 'operations.id', "operation_types.name")
            ->where('operations.archived','=','1')
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
            "completed" => false,
            "operation_type" => $request->operation_type
        ];
        
        Operation::create($data);
        
        return redirect('/')->with('message', ["type" => "success", "text" => "Criado com sucesso"]);;
    }

    public function delete($id = null){
        Operation::destroy($id);
        return redirect('/operation/archived');
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
            "operation_type" => $request->operation_type
        ];

        $operation->fill($data);
        $operation->save();
        return redirect('/')->with('message', ["type" => "success", "text" => "Alterado com sucesso"]);;
    }

    public function finish($id){
        $order = Operation::find($id)->order;
        return view("finishOperation", ["order" => $order]);
    }

    public function archive($id){
        $operation = Operation::find($id);
        if ($operation->completed == 1){
            $operation->archived = 1;
            $operation->save();
        }

        return redirect('/')->with('message', ["type" => "success", "text" => "Arquivado com sucesso"]);
    }

    public function unarchive($id){
        $operation = Operation::find($id);
        $operation->archived = 0;
        $operation->save();
        return redirect('/operation/archived')->with('message', ["type" => "success", "text" => "Desarquivado com sucesso"]);
    }

    public function finishHandler($id){
        $operation = Operation::find($id);

        if ($operation->completed == 1){
            return redirect('/')->with('message', ["type" => "success", "text" => "Já finalizada"]);;
        }

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
