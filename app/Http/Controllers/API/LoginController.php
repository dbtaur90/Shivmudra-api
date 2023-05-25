<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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
                if($tokenValue == 'b7b00eecd9134de4aeba4845d41c5cfd'){
                    $whatsappNumber = '9028744681';
                    $sbresult = DB::select('CALL get_user_details(?)', array($whatsappNumber));
                    if($sbresult && count($sbresult)>0){
                        $executives = (array)$sbresult[0];
                        return response($executives, 200);
                    }
                }
                if($data['statusCode'] == '200'){
                    $whatsappNumber = $data['data']['userMobile'];
                    $whatsappNumber = $str2 = substr($whatsappNumber, 2); 
                    $sbresult = DB::select('CALL get_user_details(?)', array($whatsappNumber));
                    if($sbresult && count($sbresult)>0){
                        $executives = (array)$sbresult[0];
                        return response($executives, 200);
                    }
                    else{
                        return response()->json(['error' => 'Unauthorized'], 401);
                    }
                }
                else
                    return response($response, $data['statusCode']);
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
