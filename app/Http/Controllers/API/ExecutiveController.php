<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Executive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

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
        return DB::select('CALL executive_letter_request(?,?,?)', array($request->tokensn, $executive->id, $requestData['addressText']));
    }
    public function getOpArea(Request $request)
    {
        $reArray = [$request->level, $request->ftrLevel, $request->ftrValue];
        $result = DB::select('CALL get_opArea(?,?,?)', $reArray);
        return $result;
    }

    public function getPostRequestList(Request $request)
    {
        $result = DB::select('CALL get_posting_request_list()');
        return $result;
    }

    public function approveRequest(Request $request)
    {
        $flight = Executive::find($request->executiveID);
        $flight->status = $request->status;
        $flight->approvedBy = $request->tokensn;
        $flight->save();
        $user = DB::table('users')
                ->select('id')
                ->where('executiveId', '=', $request->executiveID)
                ->where('letterType', '=', 3)
                ->first();
        return response($user);
    }

    public function getPostingLetter($lid)
    {

        $result = DB::select('CALL get_execute_letterData(?)', array($lid));
        $data = (array) $result[0];
        return view('posting_letter', $data);
        // $pdf = Pdf::loadView('posting_letter', $data);
        // return $pdf->download('invoice.pdf');
        /*  $html = view('posting_letter', $data)->render();

         // Instantiate a new Dompdf instance
         $pdf = new \Dompdf\Dompdf();

         // Load the HTML into Dompdf
         $pdf->loadHtml($html);

         // Set paper size and orientation
         $pdf->setPaper('A4', 'portrait');

         // Render the PDF
         $pdf->render();

         // Return the PDF as a response
         return response($pdf->output())
             ->header('Content-Type', 'application/pdf'); */
    }
}