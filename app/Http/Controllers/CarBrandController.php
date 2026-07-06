<?php

namespace App\Http\Controllers;

use App\CarBrand;
use App\CarType;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CarBrandController extends Controller
{
    public function index()
    {
        $brands = CarBrand::with('carType')->latest()->get();

         return response()->json([
            'success' => true,
            'message' => 'Build Brands Fetched Successfully',
            'data' => $brands
        ], 200); 
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_type_id' => '',
            'en_title' => 'required|string|max:255',
            'ar_title' => 'nullable|string|max:255',
            'active_status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $brand = CarBrand::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Car Brand Created Successfully',
            'data' => $brand
        ], 200);
    }

    public function show($id)
    {
        $brand = CarBrand::findorFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Car Brand Fetched Successfully',
            'data' => $brand
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'car_type_id' => '',
            'en_title' => 'sometimes|required|string|max:255',
            'ar_title' => 'nullable|string|max:255',
            'active_status' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $brand = CarBrand::findorFail($id);
        $brand->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Car Brand Updated Successfully',
            'data' => $brand
        ], 200);
    }

    public function destroy($id)
    {
        $brand = CarBrand::findorFail($id);
        $brand->update(['active_status' => 0]);
        return response()->json([
            'success' => true,
            'message' => 'Car Brand Deleted Successfully',
            'data' => $brand
        ], 200);
    }

    public function recover($id)
    {
        $brand = CarBrand::findorFail($id);
        $brand->update(['active_status' => 1]);
        return response()->json([
            'success' => true,
            'message' => 'Car Brand Active Successfully',
            'data' => $brand
        ], 200);
    }
} 
    