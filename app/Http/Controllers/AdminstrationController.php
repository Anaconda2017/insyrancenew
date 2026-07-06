<?php

namespace App\Http\Controllers;

use App\Adminstration;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class AdminstrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Adminstration::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Adminstration Fetched Successfully',
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
            'admin_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $requestArray = $request->all();

        if ($request->hasFile('admin_image')) {
            $file = $request->file('admin_image');
            $fileName = time() . Str::random(10) . '.webp';

            // Create directories if they don't exist
            if (!file_exists(public_path('uploads/adminstration'))) {
                mkdir(public_path('uploads/adminstration'), 0777, true);
            }

            // Process image
            $image = Image::make($file->getRealPath());
            $image->encode('webp', 80)->save(public_path('uploads/adminstration/' . $fileName));

            $requestArray['admin_image'] = 'uploads/adminstration/' . $fileName;
        }

        $feature = Adminstration::create($requestArray);

        return response()->json(['success' => true,
            'message' => 'Adminstration Added Successfully',
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
        $row = Adminstration::findorFail($id);
        
        return response()->json([
            'success' => true,
            'message' => 'Adminstration Fetched Successfully',
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
        $feature = Adminstration::findorFail($id);

        $validator = Validator::make($request->all(), [
            'en_name' => 'required',
            'ar_name' => 'required',
            'en_job' => 'required',
            'ar_job' => 'required',
            'admin_image' => 'mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $requestArray = $request->all();
        
        if ($request->hasFile('admin_image')) {
            $file = $request->file('admin_image');
            $fileName = time() . Str::random(10) . '.webp';

            // Delete old image if exists
            if ($feature->admin_image) {
                $oldImage = public_path('uploads/adminstration/' . $feature->admin_image);
                if (file_exists($oldImage)) unlink($oldImage);
            }

            // Process image
            $image = Image::make($file->getRealPath()); 
            $image->encode('webp', 80)->save(public_path('uploads/adminstration/' . $fileName));

            $requestArray['admin_image'] = 'uploads/adminstration/' . $fileName;
        }


        $feature->update($requestArray);

        return response()->json(['success' => true,
            'message' => 'Adminstration Updated Successfully',
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
        $feature = Adminstration::findorFail($id);
        $feature->update(['active_status' => 0]);
        return response()->json([
            'success' => true,
            'message' => 'Adminstration Deleted Successfully',
            'data' => $feature
        ], 200);
    }

    public function recover($id)
    {
        $feature = Adminstration::findorFail($id);
        $feature->update(['active_status' => 1]);
        return response()->json([
            'success' => true,
            'message' => 'Adminstration Active Successfully',
            'data' => $feature
        ], 200);
    }
}
