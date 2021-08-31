<?php

namespace App\Http\Controllers;

use App\Helpers\SMS;
use App\Models\Client;
use App\Models\Operation;
use App\Models\OperationType;
use App\Models\Service;
use Brian2694\Toastr\Facades\Toastr;
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
        return view("admin.registerOperation", ["operation" => $operation, 'address' => $address, "operation_types" => $operation_types]);
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
        return view("admin.archivedOpearations", ["all_operations" => $allOperations, "userType" => $userType]);
    }

    public function create(Request $request){
        
        $lat = 0; 
        $long = 0;
        if (empty($request->lat) or empty($request->long)){
            $addressFull = "$request->street $request->number, Ceará-Mirim - Rio Grande do Norte,, Brazil";
            $apiKey = config("app.google_geocoding_api_key");
            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$addressFull&key=$apiKey";
            
            $responseLocation = Http::get($url)->json();
            $lat = $responseLocation['results'][0]['geometry']['location']['lat'];
            $long = $responseLocation['results'][0]['geometry']['location']['lng'];
        } else{
            $lat = $request->lat;
            $long = $request->long;
        } 
        
        $person = Client::where('subscription', $request->subscription)->first();
        if ($person){
            $msg = "";
            if($request->operation_type == 1){
                $msg = "FOI EMITIDA UMA ORDEM DE CORTE PARA SEU IMÓVEL ($request->subscription). Por favor, procurar o SAAE - Ceará-Mirim/RN para regularizar sua situação.";
            } else{
                $msg = "FOI EMITIDA UMA ORDEM DE RELIGACÃO PARA SEU IMÓVEL ($request->subscription). O prazo é de 24h. (SAAE - Ceará-mirim/RN)";
            }
            $sms = SMS::sendSMS($person->phone, $msg);
            if ($sms["status"] == "success"){
                Toastr::success("SMS enviado com sucesso", "Sucesso");
            }
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

        Toastr::success("Ordem de serviço cadastrada com sucesso", "Sucesso");
        return redirect('/dashboard')->with('message', ["type" => "success", "text" => "Criado com sucesso"]);;
    }

    public function delete($id = null){
        Operation::destroy($id);
        Toastr::success("Ordem de serviço deletada com sucesso", "Sucesso");
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
        Toastr::success("Ordem de serviço editada com sucesso", "Sucesso");
        return redirect('/dashboard')->with('message', ["type" => "success", "text" => "Alterado com sucesso"]);;
    }

    public function finish($id){
        $order = Operation::find($id)->order;
        return view("admin.finishOperation", ["order" => $order]);
    }

    public function archive($id){
        $operation = Operation::find($id);
        if ($operation->completed == 1){
            $operation->archived = 1;
            $operation->save();
        }

        Toastr::success("Ordem de serviço arquivada com sucesso", "Sucesso");
        return redirect('/dashboard')->with('message', ["type" => "success", "text" => "Arquivado com sucesso"]);
    }

    public function unarchive($id){
        $operation = Operation::find($id);
        $operation->archived = 0;
        $operation->save();

        Toastr::success("Ordem de serviço desarquivada com sucesso", "Sucesso");
        return redirect('/operation/archived')->with('message', ["type" => "success", "text" => "Desarquivado com sucesso"]);
    }

    public function finishHandler($id){
        $operation = Operation::find($id);

        if ($operation->completed == 1){
            return redirect('/dashboard')->with('message', ["type" => "success", "text" => "Já finalizada"]);;
        }

        $operation->completed = 1;
        $operation->save();

        $data = [
            "user_id" => Auth::user()->id,
            "operation_id" => $operation->id
        ];

        Service::create($data);

        Toastr::success("Ordem de serviço finalizada com sucesso", "Sucesso");
        return redirect('/dashboard')->with('message', ["type" => "success", "text" => "Finalizado com sucesso"]);;
    }
}
