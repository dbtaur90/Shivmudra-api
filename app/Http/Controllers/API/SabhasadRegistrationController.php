<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SabhasadDocumentModel;
use App\Models\SabhasadEducationModel;
use App\Models\SabhasadEmploymentModel;
use App\Models\SabhasadModel;
use Illuminate\Support\Facades\DB;

class SabhasadRegistrationController extends Controller
{
    public function registerSabhasad(Request $request ){
        $requestData = $request->all();
        $personalData = $requestData['personalData'];
        $employementData = $requestData['employementData'];
        $educationData = $requestData['educationData'];
        //return response($employementData);
      //  return response()->json($requestData);
        $employementData['employmentType'] = implode(", ",$employementData['employmentTypeArray']);
        unset($employementData['employmentTypeArray']);

        $personalData['helpForOrg'] = implode(", ",$personalData['helpForOrgArray']);
        unset($personalData['helpForOrgArray']);
        //response($employementData);
        $businessID = DB::table('tbSabhasadEmployment')->insertGetId($employementData);
        $educationID = DB::table('tbSabhasadEducation')->insertGetId($educationData);
        $personalData['businessID'] = $businessID;
        $personalData['educationID'] = $educationID;
        $sabhasadID = DB::table('tbSabhasad')->insertGetId($personalData);
      //  $documentData->sabhasadID = $sabhasadID;
        return response($sabhasadID);
    }
    public function submitDocument(Request $request)
    {
        $sabhasadID = $request->sabhasadID;
        $aadharImage = $request->file('aadharImage')->store('aadhar', 'public');
        $tcImage = $request->file('tcImage')->store('tc', 'public');
        $photoImage = $request->file('photoImage')->store('photo', 'public');
        $signImage = $request->file('signImage')->store('sign', 'public');

        $data = SabhasadDocumentModel::create([
            'sabhasadID' => $sabhasadID,
            'aadharImage' => $aadharImage,
            'tcImage' => $tcImage,
            'photoImage' => $photoImage,
            'signImage' => $signImage,
        ]);

        return response($data, Response::HTTP_CREATED);
    }
    //
}
