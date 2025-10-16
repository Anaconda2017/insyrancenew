<?php

namespace App\Http\Controllers;

use App\AboutCounter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class AboutCounterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = AboutCounter::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'About Counter Fetched Successfully',
            'data' => $rows
        ], 200); 
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'en_name' => 'required',
            'ar_name' => 'required',
            'counter_value' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $requestArray = $request->all();

        $feature = AboutCounter::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'About Counter Added Successfully',
            'data' => $feature
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
        $row = AboutCounter::findorFail($id);
        return response()->json(['row' => $row], 200);
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
        $feature = AboutCounter::findorFail($id);

        $requestArray = $request->all();

        $validator = Validator::make($request->all(), [
            'en_name' => 'required',
            'ar_name' => 'required',
            'counter_value' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $feature->update($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'About Counter Updated Successfully',
            'data' => $feature
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
