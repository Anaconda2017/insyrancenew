<?php

namespace App\Http\Controllers;

use App\CarType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarTypeController extends Controller
{
    public function index()
    {
        $types = CarType::latest()->get();            
        

        return response()->json([
            'success' => true,
            'message' => 'Build Types Fetched Successfully',
            'data' => $types
        ], 200); 
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'en_title' => 'required|string|max:255',
            'ar_title' => 'nullable|string|max:255',
            'active_status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {  
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $type = CarType::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Car Type Created Successfully',
            'data' => $type
        ], 200);
    }

    public function show($id)
    {
        $type = CarType::findorFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Car Type Fetched Successfully',
            'data' => $type
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'en_title' => 'sometimes|required|string|max:255',
            'ar_title' => 'nullable|string|max:255',
            'active_status' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $type = CarType::findorFail($id);
        $type->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Car Type Updated Successfully',
            'data' => $type
        ], 200);
    }

    public function destroy($id)
    {
        $type = CarType::findorFail($id);
        $type->update(['active_status' => 0]);
        return response()->json([
            'success' => true,
            'message' => 'Car Type Deleted Successfully',
            'data' => $type
        ], 200);
    }

    public function recover($id)
    {
        $type = CarType::findorFail($id);
        $type->update(['active_status' => 1]);
        return response()->json([
            'success' => true,  
            'message' => 'Car Type Active Successfully',
            'data' => $type
        ], 200);
    }
    

} 