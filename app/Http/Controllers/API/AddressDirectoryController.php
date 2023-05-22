<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AddressDirectoryController extends Controller
{
    public function districtList(){
        
        return DB::table('AddressDirectory')->select('District','DistrictMr')->distinct()->get();
    }

    public function talukaList($district){
        return DB::table('AddressDirectory')->where('District',$district)->select('SubDistrict','SubDistrictMr')->distinct()->get();
    }

    public function villageList(Request $request){
        $district = $request->district;
        $taluka = $request->taluka;
        return DB::table('AddressDirectory')->where([['District',$district],['SubDistrict',$taluka]])->select('AddressDirectoryID','Village','VillageMr')->distinct()->get();
    }

    public function getAddressDirectory($id){
        return DB::table('AddressDirectory')->where('AddressDirectoryID',$id)->get();
    }
    
    public function getOpArea($level, Request $request){
        
        $tables = ['','','vibhagiy', 'districts', 'talukas'];
        if($level && $level<7){
            $tname = $tables[$level];
            if($tname && strlen($tname)>2)
                if($request->colName && $request->colValue)
                    return DB::table($tname)->where($request->colName, $request->colValue)->get();
                else
                    return DB::table($tname)->get();
        }
        return response(["error"=>"Bad Request"], 400);
    }
}
