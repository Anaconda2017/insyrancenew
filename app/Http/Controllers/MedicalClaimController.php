<?php

namespace App\Http\Controllers;

use App\MedicalClaim;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use App\Services\NotificationDispatchService;

class MedicalClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = MedicalClaim::with('category' ,'user' ,'medicalInsurance' ,'comments')->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Medical Claims Fetched Successfully',
            'data' => $rows
        ], 200); 
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.client.create');  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'medical_insurance_id' => '',  
            'medical_insurance_number' => 'string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'birthdate' => '',
            'gender' => 'string|max:255',
            'status' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $characters = '0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lenthNumber = 10;
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $lenthNumber; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $randomString =  $randomString; 

        $requestArray = $request->all();
        $requestArray['claim_number'] = $randomString;

        $medicalClaim = MedicalClaim::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Medical Claim Added Successfully',
            'data' => $medicalClaim
        ], 200);
    }        
     
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = MedicalClaim::with('category', 'user', 'medicalInsurance' ,'comments')->findorfail($id);

        return response()->json([
            'success' => true,
            'message' => 'Medical Claim Fetched Successfully',
            'data' => $row
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = MedicalClaim::findorFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Medical Claim Fetched Successfully',
            'data' => $row
        ], 200); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $medicalClaim = MedicalClaim::findorFail($id);
        
        $requestArray = $request->all();

        if($request->status != $medicalClaim->status) {
            app(NotificationDispatchService::class)->dispatchSingleClaim([
                'titlemessage' => 'Update Alert!',
                'textmessage' => 'Your status has been updated.',
                'artitlemessage' => 'تنبيه تحديث!',
                'artextmessage' => 'تم تحديث حالتك. ',
                'user_id' => $medicalClaim->user_id,
                'request_id' => $medicalClaim->id,
                'request_type' => 'medical',
            ]);
        }
        
        $medicalClaim->update($requestArray);
        

        return response()->json([
            'success' => true,
            'message' => 'Medical Claim Updaded Successfully',
            'data' => $medicalClaim
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
