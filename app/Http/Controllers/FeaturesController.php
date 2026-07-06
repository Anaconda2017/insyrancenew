<?php

namespace App\Http\Controllers;

use App\Features;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FeaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $features = Features::latest()->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Features Fetched Successfully',
            'data' => $features
        ], 200);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'en_description' => 'required|string',
            'ar_description' => 'required|string',
            'active_status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
    

        $feature = Features::create($requestArray);
        return response()->json([
            'success' => true,
            'message' => 'Feature Added Successfully',
            'data' => $feature
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $feature = Features::findorFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Feature Fetched Successfully',
            'data' => $feature
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
        $feature = Features::findorFail($id);
        $validator = Validator::make($request->all(), [
            
            'en_description' => 'nullable|string',
            'ar_description' => 'nullable|string',
            'active_status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $requestArray = $request->all();


        $feature->update($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Feature Updated Successfully',
            'data' => $feature
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
        $feature = Features::findorFail($id);
        $feature->update(['active_status' => 0]);
        return response()->json([
            'success' => true,
            'message' => 'Feature Deleted Successfully',
            'data' => $feature
        ], 200);
    }
    
    public function recover($id)
    {
        $feature = Features::findorFail($id);

        $feature->update([
            'active_status' => 1
            ]);
         
        return response()->json([
            'success' => true,
            'message' => 'Feature Restored Successfully',
            'data' => $feature
        ], 200); 
    }
}
