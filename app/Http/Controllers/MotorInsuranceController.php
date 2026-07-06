<?php

namespace App\Http\Controllers;

use App\MotorInsurance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MotorInsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = MotorInsurance::with('category' ,'motorchoices')->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Motor Insurances Fetched Successfully',
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
            'en_title' => 'string|max:255',
            'ar_title' => 'string|max:255',
            'year_money' => 'numeric',
            'month_money' => 'numeric',
            'company_name' => 'string|max:255',
            'active_status' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $requestArray = $request->all();

        $motorInsurance = MotorInsurance::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Motor Insurance Added Successfully',
            'data' => $motorInsurance
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
        $row = MotorInsurance::with('category' ,'motorchoices')->findorfail($id);

        return response()->json([
            'success' => true,
            'message' => 'Motor Insurance Fetched Successfully',
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
        $row = MotorInsurance::with('category' ,'motorchoices')->findorFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Motor Insurance Fetched Successfully',
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
        $motorInsurance = MotorInsurance::findorFail($id);
        
        $requestArray = $request->all();

        $motorInsurance->update($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Motor Insurance Updaded Successfully',
            'data' => $motorInsurance
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $motorInsurance = MotorInsurance::findorFail($id);
        $motorInsurance->update(['active_status' => '0']);

        
        return response()->json([
            'success' => true,
            'message' => 'Motor Insurance Deleted Successfully',
            'data' => $motorInsurance
        ], 200);

    }

    public function recover($id)
    {
        $motorInsurance = MotorInsurance::findorFail($id);
        $motorInsurance->update(['active_status' => '1']);

        return response()->json([
            'success' => true,
            'message' => 'Motor Insurance Recovered Successfully',
            'data' => $motorInsurance
        ], 200);
    }
    
}
