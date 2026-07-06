<?php

namespace App\Http\Controllers;

use App\JopLead;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class JopLeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = JopLead::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Jop Leads Fetched Successfully',
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
            'jop_main_id' => 'mimes:jpg,jpeg,png,gif,svg,pdf,svg|max:2048',
            'jop_second_id' => 'mimes:jpg,jpeg,png,gif,svg,pdf,svg|max:2048',
            'need_call' => 'string|max:255',
            'active_status' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $requestArray = $request->all();
        
        
        if($request->hasFile('jop_main_id')){
            $file = $request->file('jop_main_id');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/jop_requests'), $fileName);
            $requestArray['jop_main_id'] = 'uploads/jop_requests/'.$fileName;
        }
        
        
        if($request->hasFile('jop_second_id')){
            $file1 = $request->file('jop_second_id');
            $fileName1 = time().'.'.$file->getClientOriginalExtension();
            $file1->move(public_path('uploads/jop_requests'), $fileName1);
            $requestArray['jop_second_id'] = 'uploads/jop_requests/'.$fileName1;
        }
        
        

        $jopLead = JopLead::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Jop Lead Added Successfully',
            'data' => $jopLead
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
        $row = JopLead::with('category')->findorfail($id);

        return response()->json([
            'success' => true,
            'message' => 'Jop Lead Fetched Successfully',
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
        $row = JopLead::findorFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Jop Lead Fetched Successfully',
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
        $jopLead = JopLead::findorFail($id);
        
        $requestArray = $request->all();

        $jopLead->update($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Jop Lead Updaded Successfully',
            'data' => $jopLead
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
