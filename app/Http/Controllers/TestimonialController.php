<?php

namespace App\Http\Controllers;

use App\Testimonial;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Testimonial::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Testimonials Fetched Successfully',
            'data' => $rows
        ], 200);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'en_name' => 'required',
            'ar_name' => 'required',
            'en_job' => 'required',
            'ar_job' => 'required',
            'en_text' => 'required',
            'ar_text' => 'required',
            'active_status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $requestArray = $request->all();

        $feature = Testimonial::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Testimonial Added Successfully',
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
        $row = Testimonial::findorFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Testimonial Fetched Successfully',
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
        $feature = Testimonial::findorFail($id);

        $requestArray = $request->all();

        $validator = Validator::make($request->all(), [
            'en_name' => 'required',
            'ar_name' => 'required',
            'en_job' => 'required',
            'ar_job' => 'required',
            'en_text' => 'required',
            'ar_text' => 'required',
            'active_status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $feature->update($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Testimonial Updated Successfully',
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
        $feature = Testimonial::findorFail($id);
        $feature->update(['active_status' => 0]);
        return response()->json([
            'success' => true,  
            'message' => 'Testimonial Deleted Successfully',
            'data' => $feature
        ], 200);
    }

    public function recover($id)    
    {
        $feature = Testimonial::findorFail($id);
        $feature->update(['active_status' => 1]);
        return response()->json([
            'success' => true,
            'message' => 'Testimonial Restored Successfully',
            'data' => $feature
        ], 200);
    }
}
