<?php

namespace App\Http\Controllers;

use App\CarYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarYearController extends Controller
{
    public function index()
    {
        $years = CarYear::with('carModel')->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Build Years Fetched Successfully',
            'data' => $years
        ], 200); 
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_model_id' => 'required|exists:car_models,id',
            'year_date' => 'required|array',
            'year_date.*' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        
        $createdYears = []; // Use a separate array to store created models

        foreach ($request->year_date as $year) {
            $createdYears[] = CarYear::create([
                'car_model_id' => $request->car_model_id,
                'year_date' => $year,
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Car Year Created Successfully',
            'data' => $createdYears
        ], 201);
    }

    public function show($id)
    {
        $year = CarYear::findorFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Car Year Fetched Successfully',
            'data' => $year
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'car_model_id' => 'sometimes|required|exists:car_models,id',
            'en_title' => 'sometimes|required|string|max:255',
            'ar_title' => 'nullable|string|max:255',
            'active_status' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $year = CarYear::findorFail($id);
        $year->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Car Year Updated Successfully',
            'data' => $year
        ], 200);
    }

    public function destroy($id)
    {
        $year = CarYear::findorFail($id);
        $year->update(['active_status' => 0]);
        return response()->json([
            'success' => true,
            'message' => 'Car Year Deleted Successfully',
            'data' => $year
        ], 200);
    }

    public function recover($id)
    {
        $year = CarYear::findorFail($id);
        $year->update(['active_status' => 1]);
        return response()->json([
            'success' => true,
            'message' => 'Car Year Recovered Successfully',
            'data' => $year
        ], 200);
    }
} 
    
