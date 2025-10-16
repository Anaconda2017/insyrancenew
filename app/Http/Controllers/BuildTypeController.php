<?php

namespace App\Http\Controllers;

use App\BuildType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class BuildTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = BuildType::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Build Types Fetched Successfully',
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
            'en_title' => 'required|string|max:255',
            'ar_title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {  
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $requestArray = $request->all();

        $buildType = BuildType::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Build Type Added Successfully',
            'data' => $buildType
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
        $row = BuildType::findorfail($id);

        return response()->json([
            'success' => true,
            'message' => 'Build Type Fetched Successfully',
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
        $row = BuildType::findorFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Build Type Fetched Successfully',
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
        $buildType = BuildType::findorFail($id);
        
        $requestArray = $request->all();

        $buildType->update($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Build Type Updaded Successfully',
            'data' => $buildType
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
        $buildType = BuildType::findorFail($id);

        $buildType->update([
            'active_status' => 0
            ]);  

        return response()->json([
            'success' => true,
            'message' => 'Build Type Disabled Successfully',
            'data' => $buildType
        ], 200); 
    }
    
    public function recover($id)
    {
        $buildType = BuildType::findorFail($id);

        $buildType->update([
            'active_status' => 1
            ]);
         
        return response()->json([
            'success' => true,
            'message' => 'Build Type Enabled Successfully',
            'data' => $buildType
        ], 200); 
    }
}
