<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Executive;
class LoginController extends Controller
{
    public function login(Request $request){
        $tokenValue = $request->header('token');
        if($tokenValue){
            $data = ['token'=>$tokenValue];
            $response = Http::withHeaders([
                'clientId' => '5dkq9f5j',
                'clientSecret'=> '528imjzc1xh4umb3',
                'Accept' => 'application/json',
            ])->withBody(json_encode($data), 'application/json')
            ->post('https://marathashivmudra.authlink.me');
            if ($response->ok()) {
                $data = $response->json();
                if($data['statusCode'] == '200'){
                    $whatsappNumber = $data['user']['waNumber'];
                    $whatsappNumber = $str2 = substr($whatsappNumber, 2); 
                    $executives = Executive::whereIn('sabhasadID', function ($query) use ($whatsappNumber) {
                        $query->select('sabhasadID')
                              ->from('tbSabhasad')
                              ->where('whatsappNumber', $whatsappNumber);
                    })->get();
                    return response($executives);
                }
                else
                    return response($response);
                // do something with the response data
            }
            else {
                return response($response);
            }

        }
        else{
            return response(['message'=>'Bad Request'], 400);
        }
    }
}
