<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class SMS {
    static function sendSMS($number, $message){
        $token = config('app.sms_api_key');
        $login = config('app.sms_api_login');
        $baseUrl = "http://sms.kingtelecom.com.br/kingsms/api.php?acao=sendsms";

        $url = "$baseUrl&login=$login&token=$token&numero=$number&msg=$message";
        return Http::get($url)->json();
    }
}