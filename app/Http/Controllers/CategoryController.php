<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    
    private function make_slug($string, $separator = '-') {
        $string = trim($string);
        $string = mb_strtolower($string, 'UTF-8');

        $string = preg_replace("/[^a-z0-9_\s\-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]/u", "", $string);

        $string = preg_replace("/[\s\-]+/", " ", $string);
        $string = preg_replace("/[\s_]/", $separator, $string);

        return $string;
    }
    
    
    public function index()
    {
        $categories = Category::latest()
            ->get();
            
        return response()->json([
            'success' => true,
            'message' => 'Categories Fetched Successfully',
            'data' => $categories
        ]);
        
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'en_title' => 'required|string',
            'ar_title' => 'required|string',
            'en_small_description' => 'required|string',
            'ar_small_description' => 'required|string',
            'en_main_description' => 'required|string',
            'ar_main_description' => 'required|string',
            'network_link' => 'string',
            'counter_number' => 'required|integer',
            'en_meta_title' => 'required|string',
            'ar_meta_title' => 'required|string',
            'en_meta_description' => 'required|string',
            'ar_meta_description' => 'required|string',
            'active_status' => 'required|boolean',
        ]);
        
            

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $ar_slug = $this->make_slug($request->ar_title);
        $en_slug = $this->make_slug($request->en_title);

        $requestArray['ar_slug'] = $ar_slug;
        $requestArray['en_slug'] = $en_slug;
        
        $requestArray = [
            'ar_slug' => $ar_slug,
            'en_slug' => $en_slug
        ] + $request->all();    

        $category = Category::create($requestArray);
        
        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);


        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'en_title' => 'required|string',
            'ar_title' => 'required|string',
            'en_small_description' => 'required|string',
            'ar_small_description' => 'required|string',
            'en_main_description' => 'required|string',
            'ar_main_description' => 'required|string',
            'network_link' => 'string',
            'counter_number' => 'required|integer',
            'en_meta_title' => 'required|string',
            'ar_meta_title' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
        

        $requestArray =  $request->all();    

        $category->update($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully',
            'data' => $category
        ]);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $category->update([
            'active_status' => 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category deactivated successfully' ,
            'data' => $category 
        ]);
    }

    public function recover($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
            ], 404);
        }

        $category->update([
            'active_status' => 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category recovered successfully',
            'data' => $category
        ]);
    }

} 