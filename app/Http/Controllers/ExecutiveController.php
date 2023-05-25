<?php

namespace App\Http\Controllers;

use App\Models\Executive;
use Illuminate\Http\Request;

class ExecutiveController extends Controller
{
    //
    public function registerExecutive(Request $request)
    {
        $requestData = $request->all();
        $executiveData = $requestData['executiveData'];
        $executive = new Executive($executiveData);
        $executive->save();
    }
}
