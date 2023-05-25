<?php

namespace App\Http\Controllers;

use App\Models\Executive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExecutiveController extends Controller
{
    //
    public function registerExecutive(Request $request)
    {
        $requestData = $request->all();
        $executiveData = $requestData['executiveData'];
        $executive = new Executive($executiveData);
        $executive->requestedBy = $request->tokensn;
        $executive->save();
        return DB::select('CALL executive_letter_request(?)', array($request->tokensn, $executive->id, $requestData['addressText']));
    }
    public function getOpArea(Request $request){
        $reArray = [$request->level, $request->ftrLevel, $request->ftrValue];
        $result = DB::select('CALL get_opArea(?,?,?)', $reArray);
        return $result;
    }
}
