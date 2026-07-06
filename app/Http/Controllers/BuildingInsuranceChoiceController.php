<?php

namespace App\Http\Controllers;

use App\BuildingInsuranceChoice;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BuildingInsuranceChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = BuildingInsuranceChoice::with('category' ,'buildinginsurance')->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Building Insurance Choices Fetched Successfully',
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
            'building_insurance_id' => 'required|exists:building_insurances,id',
            'en_title' => 'string|max:255',
            'ar_title' => 'string|max:255',
            'en_description' => 'string|max:255',
            'ar_description' => 'string|max:255',
            'active_status' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $requestArray = $request->all();

        $buildingInsuranceChoice = BuildingInsuranceChoice::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Building Insurance Choice Added Successfully',
            'data' => $buildingInsuranceChoice
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
        $row = BuildingInsuranceChoice::with('category' ,'buildinginsurance')->findorfail($id);

        return response()->json([
            'success' => true,
            'message' => 'Building Insurance Choice Fetched Successfully',
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
        $row = BuildingInsuranceChoice::with('category' ,'buildinginsurance')->findorFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Building Insurance Choice Fetched Successfully',
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
        $buildingInsuranceChoice = BuildingInsuranceChoice::findorFail($id);
        
        $requestArray = $request->all();

        $buildingInsuranceChoice->update($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Building Insurance Choice Updaded Successfully',
            'data' => $buildingInsuranceChoice
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
        $buildingInsuranceChoice = BuildingInsuranceChoice::findorFail($id);
        $buildingInsuranceChoice->update(['active_status' => '0']);

        
        return response()->json([
            'success' => true,
            'message' => 'Building Insurance Choice Deleted Successfully',
            'data' => $buildingInsuranceChoice
        ], 200);

    }

    public function recover($id)
    {
        $buildingInsuranceChoice = BuildingInsuranceChoice::findorFail($id);
        $buildingInsuranceChoice->update(['active_status' => '1']);

        return response()->json([
            'success' => true,
            'message' => 'Building Insurance Choice Recovered Successfully',
            'data' => $buildingInsuranceChoice
        ], 200);
    }
    
}
