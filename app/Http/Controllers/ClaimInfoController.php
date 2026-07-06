<?php

namespace App\Http\Controllers;

use App\ClaimInfo;
use App\Features;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;


class ClaimInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = ClaimInfo::latest()->get()->first();
        
        $features = Features::where('active_status' , 1)->latest()->get();
        
        
        return response()->json([
            'success' => true,
            'message' => 'Claim Information Fetched Successfully',
            'data' => $rows ,
            'features' => $features
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = ClaimInfo::findorfail($id);

        return response()->json([
            'success' => true,
            'message' => 'Claim Information Fetched Successfully',
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
        $row = ClaimInfo::findorFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Claim Information Fetched Successfully',
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
        $client = ClaimInfo::findorFail($id);
        
        $validator = Validator::make($request->all(), [
            'main_image' => 'mimes:jpeg,png,jpg,gif,webp|max:2048',
            'en_main_title'  => 'required', 
            'ar_main_title'  => 'required', 
            'en_main_text'   => 'required', 
            'ar_main_text'   => 'required',
            
            'en_second_title' => 'required', 
            'ar_second_title' => 'required', 
            'en_second_text'  => 'required', 
            'ar_second_text'  => 'required',
    
            'en_meta_title'  => 'required', 
            'ar_meta_title'  => 'required', 
            'en_meta_text'   => 'required', 
            'ar_meta_text'   => 'required', 
        ]);

        if ($validator->fails()) {  
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $requestArray = $request->all();
        
        
        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $fileName = time() . Str::random(10) . '.webp';

            // Delete old image if exists
            // if ($client->main_image) {
            //     $oldImage = public_path('uploads/claim/' . $client->main_image);
            //     if (file_exists($oldImage)) unlink($oldImage);
            // }

            // Process image
            $image = Image::make($file->getRealPath()); 
            $image->encode('webp', 80)->save(public_path('uploads/claim/' . $fileName));

            $requestArray['main_image'] = 'uploads/claim/' . $fileName;
        }

        $client->update($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Claim Information Updaded Successfully',
            'data' => $client
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  
}
