<?php

namespace App\Http\Controllers;

use App\MedicalLead;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MedicalLeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = MedicalLead::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Medical Leads Fetched Successfully',
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'birthdate' => 'date',
            'gender' => 'string|max:255',
            'need_call' => 'string|max:255',
            'active_status' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $requestArray = $request->all();

        $medicalLead = MedicalLead::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Medical Lead Added Successfully',
            'data' => $medicalLead
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
        $row = MedicalLead::with('category')->findorfail($id);

        return response()->json([
            'success' => true,
            'message' => 'Medical Lead Fetched Successfully',
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
        $row = MedicalLead::findorFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Medical Lead Fetched Successfully',
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
        $medicalLead = MedicalLead::findorFail($id);
        
        $requestArray = $request->all();

        $medicalLead->update($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Medical Lead Updaded Successfully',
            'data' => $medicalLead
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
