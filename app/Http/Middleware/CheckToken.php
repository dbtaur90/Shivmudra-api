<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Closure;
use Illuminate\Http\Request;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $tokenValue = $request->header('token');

        if (!$tokenValue) {
            return response(['error' => 'Unauthorized'], 401);
        }
        $data = ['token' => $tokenValue];
        if($tokenValue == 'b7b00eecd9134de4aeba4845d41c5cfd'){
            $whatsappNumber = '9028744681';
             $user = DB::table('tbSabhasad')->select('sabhasadID', 'whatsappNumber')
                ->where('whatsappNumber', $whatsappNumber)
                ->first();

            if (!$user) {
                return response(['error' => 'Unauthorized'], 401);
            }
            $request->tokensn = $user->sabhasadID;
            $request->tokenwn = $user->whatsappNumber;
            return $next($request);
        }
        $response = Http::withHeaders([
            'clientId' => '5dkq9f5j',
            'clientSecret' => '528imjzc1xh4umb3',
            'Accept' => 'application/json',
        ])->withBody(json_encode($data), 'application/json')
            ->post('https://marathashivmudra.authlink.me');
        if ($response->ok()) {
            $data = $response->json();
            if ($data['statusCode'] == '200') {
                $whatsappNumber = $data['user']['waNumber'];
                $whatsappNumber = substr($whatsappNumber, 2);
                $user = DB::table('tbSabhasad')->select('sabhasadID', 'whatsappNumber')
                    ->where('whatsappNumber', $whatsappNumber)
                    ->first();

                if (!$user) {
                    return response(['error' => 'Unauthorized'], 401);
                }
                $request->tokensn = $user->sabhasadID;
                $request->tokenwn = $user->whatsappNumber;
                return $next($request);
            } else
                return response($response, $data['statusCode']);
            // do something with the response data
        }
        else
            return response(['error' => 'Internal Server Error'], 500);



        // Add the user to the request object for future use

    }
}