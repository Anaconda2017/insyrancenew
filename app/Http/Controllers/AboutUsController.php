<?php

namespace App\Http\Controllers;

use App\AboutUs;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aboutUs = AboutUs::get()->first();
        
        return response()->json([
            'success' => true,
            'message' => 'About Us Fetched Successfully',
            'data' => $aboutUs
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AboutUs $aboutUs)
    {
        return response()->json($aboutUs);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = AboutUs::findorFail($id);

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
        $about = AboutUs::findorFail($id);

        $validator = Validator::make($request->all(), [
            'en_main_title' => 'required|required|string|max:255',
            'ar_main_title' => 'required|string|max:255',
            'en_main_content' => 'required|required|string',
            'ar_main_content' => 'required|string',
            'main_image' => 'mimes:jpeg,png,jpg,webp|max:2048',
            'en_mission' => 'required|string|max:255',
            'ar_mission' => 'required|string|max:255',
            'en_vision' => 'required|string|max:255',
            'ar_vision' => 'required|string|max:255',
            'en_history_title' => 'required|string|max:255',
            'ar_history_title' => 'required|string|max:255',
            'en_history_text' => 'required|string',
            'ar_history_text' => 'required|string',
            'history_image' => 'nullable|mimes:jpeg,png,jpg,webp|max:2048',
            'en_meta_title' => 'required|string|max:255',
            'ar_meta_title' => 'required|string|max:255',
            'en_meta_description' => 'required|string',
            'ar_meta_description' => 'required|string',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $requestArray = $request->all();

        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $fileName = time() . Str::random(10) . '.webp';
            
            // Create directories if they don't exist
            if (!file_exists(public_path('uploads/about'))) {
                mkdir(public_path('uploads/about'), 0777, true);
            }
          

            // Delete old image if exists
            if ($about->main_image) {
                $oldImage = public_path('uploads/about/' . $about->main_image);
                
                if (file_exists($oldImage)) unlink($oldImage);
            }

            // Process main image
            $mainImage = Image::make($file->getRealPath());
            $mainImage->encode('webp', 80)->save(public_path('uploads/about/' . $fileName));
            
           
            $requestArray['main_image'] = 'uploads/about/'.$fileName;
        }

        if ($request->hasFile('history_image')) {
            $file1 = $request->file('history_image');
            $fileName2 = time() . Str::random(10) . '.webp';

            // Create directories if they don't exist
            if (!file_exists(public_path('uploads/about'))) {   
                mkdir(public_path('uploads/about'), 0777, true);
            }

            // Delete old image if exists
            if ($about->history_image) {
                $oldImage = public_path('uploads/about/' . $about->history_image);  
        
                if (file_exists($oldImage)) unlink($oldImage);
            }

            // Process history image
            $historyImage = Image::make($file1->getRealPath());
            $historyImage->encode('webp', 80)->save(public_path('uploads/about/' . $fileName2));
            
            $requestArray['history_image'] = 'uploads/about/'.$fileName2;
        }


        $about->update($requestArray);

        return response()->json(
            [
                'success' => true,
                'message' => 'About Us updated successfully',
                'data' => $about
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AboutUs $aboutUs)
    {
        if ($aboutUs->image) {
            Storage::disk('public')->delete($aboutUs->image);
        }
        
        $aboutUs->delete();
        return response()->json(null, 204);
    }
}
