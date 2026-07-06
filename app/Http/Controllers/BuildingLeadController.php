<?php

namespace App\Http\Controllers;

use App\BuildingLead;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BuildingLeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = BuildingLead::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Building Leads Fetched Successfully',
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
            'building_type_id' => 'exists:building_types,id',
            'building_type' => 'string|max:255',
            'building_country_id' => 'exists:building_countries,id',
            'building_country' => 'string|max:255',
            'building_city' => 'string|max:255',
            'building_price' => 'numeric',
            'need_call' => 'string|max:255',
            'active_status' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $requestArray = $request->all();

        $buildingLead = BuildingLead::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Building Lead Added Successfully',
            'data' => $buildingLead
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
        $row = BuildingLead::with('category')->findorfail($id);

        return response()->json([
            'success' => true,
            'message' => 'Building Lead Fetched Successfully',
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
        $row = BuildingLead::findorFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Building Lead Fetched Successfully',
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
        $buildingLead = BuildingLead::findorFail($id);
        
        $requestArray = $request->all();

        $buildingLead->update($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Building Lead Updaded Successfully',
            'data' => $buildingLead
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
