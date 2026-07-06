<?php

namespace App\Http\Controllers;

use App\BuildCountry;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class BuildCountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = BuildCountry::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Build Countries Fetched Successfully',
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
            'build_type_id' => 'required|exists:build_types,id',
            'en_title' => 'required|string|max:255',
            'ar_title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {  
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $requestArray = $request->all();

        $buildCountry = BuildCountry::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Build Country Added Successfully',
            'data' => $buildCountry
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
        $row = BuildCountry::findorfail($id);

        return response()->json([
            'success' => true,
            'message' => 'Build Country Fetched Successfully',
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
        $row = BuildCountry::findorFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Build Country Fetched Successfully',
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
        $buildCountry = BuildCountry::findorFail($id);
        
        $requestArray = $request->all();

        $buildCountry->update($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Build Country Updaded Successfully',
            'data' => $buildCountry
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
        $buildCountry = BuildCountry::findorFail($id);

        $buildCountry->update([
            'active_status' => 0
            ]);  

        return response()->json([
            'success' => true,
            'message' => 'Build Country Disabled Successfully',
            'data' => $buildCountry
        ], 200); 
    }
    
    public function recover($id)
    {
        $buildCountry = BuildCountry::findorFail($id);

        $buildCountry->update([
            'active_status' => 1
            ]);
         
        return response()->json([
            'success' => true,
            'message' => 'Build Country Enabled Successfully',
            'data' => $buildCountry
        ], 200); 
    }
}
