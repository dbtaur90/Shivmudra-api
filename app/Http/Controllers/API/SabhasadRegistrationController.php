<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SabhasadDocumentModel;
use App\Models\SabhasadEducationModel;
use App\Models\SabhasadEmploymentModel;
use App\Models\SabhasadModel;
use App\Models\SabhasadVerificationModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
class SabhasadRegistrationController extends Controller
{
    public function registerSabhasad(Request $request ){
        $requestData = $request->all();
        $employementData = $requestData['employee_data'];
        $educationData = $requestData['education_data'];
        unset($requestData['employee_data']);
        unset($requestData['education_data']);
        unset($requestData['current_address']);
        unset($requestData['permanent_address']);
        unset($requestData['document_data']);
        
         if($employementData){
               $employementData['employmentType'] = implode(", ", $employementData['employmentType']);
           }
          $requestData['helpForOrg'] = implode(", ", $requestData['helpForOrg']);
        if(array_key_exists("sabhasadID",$requestData) && $requestData['sabhasadID'] && $requestData['sabhasadID']>0){
            unset($requestData['educationID']);
            unset($requestData['businessID']);
            $sabhasad = SabhasadModel::find($requestData['sabhasadID']);
            foreach ($requestData as $key => $value) {
               $sabhasad[$key] = $value;
            }
            $sabhasadEdu = SabhasadEducationModel::find($educationData['id']);
            foreach ($educationData as $key => $value) {
               $sabhasadEdu[$key] = $value;
            }
            $sabhasadEmp = SabhasadEmploymentModel::find($employementData['id']);
            foreach ($employementData as $key => $value) {
               $sabhasadEmp[$key] = $value;
            }
            
        }
        else{
            
            $sabhasad = new SabhasadModel($requestData);
            $sabhasadEdu = new SabhasadEducationModel($educationData);
            $sabhasadEmp = new SabhasadEmploymentModel($employementData);
            $sabhasadEdu->save();
            $sabhasadEmp->save();
        }
        $sabhasad->educationData()->associate($sabhasadEdu);
        $sabhasad->employeeData()->associate($sabhasadEmp);
       $sabhasad->save();
       return response($sabhasad->sabhasadID);
    }
    public function submitDocument(Request $request){
        if( !$request->file('aadharImage')){
            return response(['message'=>'Bad Request'], 400);
        }
        if($request->id && $request->id > 0){
           $sabhasad = SabhasadDocumentModel::find($request->id);
           Storage::delete([$sabhasad->aadharImage, $sabhasad->photoImage, $sabhasad->signImage,]);
           if($request->tcImage != null)
                Storage::delete($sabhasad->tcImage);
        }
        $sabhasadID = $request->sabhasadID;
        if($request->firstName && $request->lastName && $request->firstName != ''){
            $sbdata = [
                'aadhar'=> $request->aadhar,
                'firstName'=> $request->firstName,
                'middleName'=> $request->middleName,
                'lastName'=> $request->lastName,
                'dob'=> $request->dob
            ];
            
            SabhasadModel::where('sabhasadID', $sabhasadID)->update($sbdata);
        }
        $aadharImage = $request->file('aadharImage')->store('aadhar', 'public');
        $tcImage = $request->file('tcImage')->store('tc', 'public');
        $photoImage = $request->file('photoImage')->store('photo', 'public');
        $signImage = $request->file('signImage')->store('sign', 'public');
        $data = [
            'sabhasadID' => $sabhasadID,
            'aadharImage' => $aadharImage,
            'tcImage' => $tcImage,
            'photoImage' => $photoImage,
            'signImage' => $signImage,
        ];
        $data1 = SabhasadDocumentModel::updateOrCreate(['sabhasadID' => $sabhasadID], $data);

        return response($data1);
    }
    public function getSabhasadList(){
      $dbSabhasadList =  SabhasadModel::with(['verificationData', 'documentData'])->orderByDesc('sabhasadID',)->get();
      $sabhasadList = [];
      foreach ($dbSabhasadList as $dbSabhasad) {
        $sabhasad = new \stdClass();
        $sabhasad->sabhasadID = $dbSabhasad->sabhasadID;
        $sabhasad->isDocumentUploaded = $dbSabhasad->documentData != null;
        $sabhasad->name = $dbSabhasad->firstName.' '.$dbSabhasad->middleName.' '.$dbSabhasad->lastName;
        $sabhasad->verification = $dbSabhasad->verificationData;
        array_push($sabhasadList,$sabhasad);
      }
      return $sabhasadList;
      //return SabhasadModel::with(['educationData','employeeData','documentData','currentAddress','permanentAddress'])->orderByDesc('sabhasadID',)->get();
      //return SabhasadModel::select('sabhasadID', 'lastName','firstName')->orderByDesc('sabhasadID',)->get();
    }

    public function getSabhasadNameAddress($sabhsadNumber){
        $result = DB::select('CALL get_sabhasad_name_address(?)',array($sabhsadNumber));
        return $result;
    }
    public function generateSabhasadNumber(Request $request){
        $user = [];
        Mail::send('send_registration_success_mail',[],function($messages) use ($user){
            $messages->to('dbtaur90@gmail.com');
            $messages->subject('Testing Email');
        });
    }
    public function updateVerificationStatus(Request $request){
        $requestData = $request->all();
        if(array_key_exists("id",$requestData) && $requestData['id'] && $requestData['id']>0){
            $sabhasad = SabhasadVerificationModel::find($requestData['sabhasadID']);
            foreach ($requestData as $key => $value) {
               $sabhasad[$key] = $value;
            }
        }
        else{
            $sabhasad = new SabhasadVerificationModel($requestData);
        }
        $sabhasad->save();
        return response($sabhasad->id);
    }
    public function getSabhasadDetails($id){
       $sabhasadDetails = SabhasadModel::with(['educationData','employeeData','documentData','currentAddress','permanentAddress'])->where('sabhasadID', $id)->orderByDesc('sabhasadID')->first();
       if($sabhasadDetails){
           if($sabhasadDetails->documentData){
               $sabhasadDetails->documentData->aadharImage = 'https://marathashivmudra.co.in/storage/'. $sabhasadDetails->documentData->aadharImage;
               $sabhasadDetails->documentData->tcImage = 'https://marathashivmudra.co.in/storage/'. $sabhasadDetails->documentData->tcImage;
               $sabhasadDetails->documentData->photoImage = 'https://marathashivmudra.co.in/storage/'. $sabhasadDetails->documentData->photoImage;
               $sabhasadDetails->documentData->signImage = 'https://marathashivmudra.co.in/storage/'. $sabhasadDetails->documentData->signImage;
           }
           if($sabhasadDetails->employeeData){
               $sabhasadDetails->employeeData->employmentType = explode(", ", $sabhasadDetails->employeeData->employmentType);
           }
           $sabhasadDetails->helpForOrg = explode(", ", $sabhasadDetails->helpForOrg);
           
        
       }
       return $sabhasadDetails ;
    }
    public function isPhoneNumberNew($value){
      return response()->json(SabhasadModel::where('mobileNumber', $value)->orWhere('whatsappNumber', $value)->count()==0);
    }
    public function isAadharNumberNew($value){
      return response()->json(SabhasadModel::where('aadhar', $value)->count()==0);
    }

    
    //
}
