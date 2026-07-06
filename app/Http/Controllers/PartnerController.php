<?php

namespace App\Http\Controllers;

use App\Partner;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Partner::with('category')->latest()->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Partners Fetched Successfully',
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
        return view('backend.job-category.create');  
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
            'partner_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'en_partner_name' => 'required|string|max:255',
            'ar_partner_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {  
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $requestArray = $request->all();

        if ($request->hasFile('partner_image')) {
            $file = $request->file('partner_image');
            $fileName = time() . Str::random(10) . '.webp';

            // Create directories if they don't exist
            if (!file_exists(public_path('uploads/partner'))) {
                mkdir(public_path('uploads/partner'), 0777, true);
            }
            
            
            // Process image
            $image = Image::make($file->getRealPath());
            $image->encode('webp', 80)->save(public_path('uploads/partner/' . $fileName));

            $requestArray['partner_image'] = 'uploads/partner/' . $fileName;
        }

        $partner = Partner::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Partner Added Successfully',
            'data' => $partner
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
        $row = Partner::findorfail($id);

        return response()->json([
            'success' => true,
            'message' => 'Partner Fetched Successfully',
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
        $row = Partner::findorFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Partner Fetched Successfully',
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
        $service = Partner::findorFail($id);
        
        $requestArray = $request->all();

        if ($request->hasFile('partner_image')) {
            $file = $request->file('partner_image');
            $fileName = time() . Str::random(10) . '.webp';

            // Delete old image if exists
            if ($service->partner_image) {
                $oldImage = public_path('uploads/partner/' . $service->partner_image);
                if (file_exists($oldImage)) unlink($oldImage);
            }

            // Process image
            $image = Image::make($file->getRealPath()); 
            $image->encode('webp', 80)->save(public_path('uploads/partner/' . $fileName));

            $requestArray['partner_image'] = 'uploads/partner/' . $fileName;
        }

        $requestArray = ['partner_image' => $request->hasFile('partner_image') ? 'uploads/partner/'.$fileName: $service->partner_image , 'partner_type' => 'partner'] + $request->all();

        $service->update($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Partner Updaded Successfully',
            'data' => $service
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
        $service = Partner::findorFail($id);

        $service->update([
            'active_status' => 0
            ]);  

        return response()->json([
            'success' => true,
            'message' => 'Partner Disabled Successfully',
            'data' => $service
        ], 200); 
    }
    
    public function recover($id)
    {
        $service = Partner::findorFail($id);

        $service->update([
            'active_status' => 1
            ]);
         
        return response()->json([
            'success' => true,
            'message' => 'Partner Enabled Successfully',
            'data' => $service
        ], 200); 
    }
}
