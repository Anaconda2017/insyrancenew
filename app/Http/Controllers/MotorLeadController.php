<?php

namespace App\Http\Controllers;

use App\MotorLead;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MotorLeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = MotorLead::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Motor Leads Fetched Successfully',
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
            'name' => 'string|max:255',
            'email' => 'email|max:255',
            'phone' => 'string|max:255',
            'birthdate' => 'date',
            'gender' => 'string|max:255',
            'car_type_id' => 'exists:car_types,id',
            'car_type' => 'string|max:255',
            'car_brand_id' => 'exists:car_brands,id',
            'car_brand' => 'string|max:255',
            'car_model_id' => 'exists:car_models,id',
            'car_model' => 'string|max:255',
            'car_year_id' => 'exists:car_years,id',
            'car_year' => 'string|max:255',
            'car_price' => 'numeric',
            'need_call' => 'string|max:255',
            'active_status' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $requestArray = $request->all();

        $motorLead = MotorLead::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Motor Lead Added Successfully',
            'data' => $motorLead
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
        $row = MotorLead::with('category')->findorfail($id);

        return response()->json([
            'success' => true,
            'message' => 'Motor Lead Fetched Successfully',
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
        $row = MotorLead::findorFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Motor Lead Fetched Successfully',
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
        $motorLead = MotorLead::findorFail($id);
        
        $requestArray = $request->all();

        $motorLead->update($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Motor Lead Updaded Successfully',
            'data' => $motorLead
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
