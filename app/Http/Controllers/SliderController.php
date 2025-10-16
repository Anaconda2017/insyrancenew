<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $sliders = Slider::latest()->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Sliders Fetched Successfully',
            'data' => $sliders
        ], 200);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'en_title' => 'required|string|max:255',
            'ar_title' => 'nullable|string|max:255',
            'en_description' => 'nullable|string',
            'ar_description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $requestArray = $request->all(); 

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . Str::random(10) . '.webp';

            // Create directories if they don't exist
            if (!file_exists(public_path('uploads/slider'))) {
                mkdir(public_path('uploads/slider'), 0777, true);
            }
            
            // Process image
            $image = Image::make($file->getRealPath());
            $image->encode('webp', 80)->save(public_path('uploads/slider/' . $fileName));

            $requestArray['image'] = 'uploads/slider/' . $fileName;
        }

        $slider = Slider::create($requestArray);
        return response()->json([
            'success' => true,
            'message' => 'Slider Added Successfully',
            'data' => $slider
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
        $slider = Slider::findorFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Slider Fetched Successfully',
            'data' => $slider
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
        $slider = Slider::findorFail($id);
        $validator = Validator::make($request->all(), [
            'en_title' => 'sometimes|required|string|max:255',
            'ar_title' => 'nullable|string|max:255',
            'en_description' => 'nullable|string',
            'ar_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $requestArray = $request->all(); 

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . Str::random(10) . '.webp';

            // Create directories if they don't exist
            if (!file_exists(public_path('uploads/slider'))) {
                mkdir(public_path('uploads/slider'), 0777, true);
            }       

            // Process image
            $image = Image::make($file->getRealPath());
            $image->encode('webp', 80)->save(public_path('uploads/slider/' . $fileName));

            $requestArray['image'] = 'uploads/slider/' . $fileName;
        }

        $slider->update($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Slider Updated Successfully',
            'data' => $slider
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
        $slider = Slider::findorFail($id);
        $slider->update(['active_status' => 0]);
        return response()->json([
            'success' => true,
            'message' => 'Slider Deleted Successfully',
            'data' => $slider
        ], 200);
    }
    
    public function recover($id)
    {
        $slider = Slider::findorFail($id);

        $slider->update([
            'active_status' => 1
            ]);
         
        return response()->json([
            'success' => true,
            'message' => 'Slider Restored Successfully',
            'data' => $slider
        ], 200); 
    }
}
