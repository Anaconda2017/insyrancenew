<?php

namespace App\Http\Controllers;

use App\CarModel;
use App\CarBrand;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CarModelController extends Controller
{
    public function index()
    {
        $models = CarModel::with('carBrand')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Build Models Fetched Successfully',
            'data' => $models
        ], 200); 
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_brand_id' => 'required|exists:car_brands,id',
            'en_title' => 'required|string|max:255',
            'ar_title' => 'nullable|string|max:255',
            'active_status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $model = CarModel::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Car Model Created Successfully',
            'data' => $model
        ], 201);
    }

    public function show($id)
    {
        $model = CarModel::findorFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Car Model Fetched Successfully',
            'data' => $model
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'car_brand_id' => 'sometimes|required|exists:car_brands,id',
            'en_title' => 'sometimes|required|string|max:255',
            'ar_title' => 'nullable|string|max:255',
            'active_status' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $model = CarModel::findorFail($id);
        $model->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Car Model Updated Successfully',
            'data' => $model
        ], 200);
    }

    public function destroy($id)
    {
        $model = CarModel::findorFail($id);
        $model->update(['active_status' => 0]);
        return response()->json([
            'success' => true,
            'message' => 'Car Model Deleted Successfully',
            'data' => $model
        ], 200);
    }

    public function recover($id)
    {
        $model = CarModel::findorFail($id);
        $model->update(['active_status' => 1]);
        return response()->json([
            'success' => true,
            'message' => 'Car Model Active Successfully',
            'data' => $model
        ], 200);
    }
} 
          