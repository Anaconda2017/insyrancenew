<?php

namespace App\Http\Controllers;

use App\AboutDownload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AboutDownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $downloads = AboutDownload::latest()->get()->first();
        return response()->json([
            'success' => true,
            'message' => 'About Downloads Fetched Successfully',
            'data' => $downloads
        ], 200);
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
            'en_title' => 'required|string|max:255',
            'ar_title' => 'required|string|max:255',
            'en_text' => 'required|string',
            'ar_text' => 'required|string',
            'android_download_link' => 'required|url',
            'ios_download_link' => 'required|url' , 
            'huawei_download_link' => 'required|url' ,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $download = AboutDownload::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'About Download Added Successfully',
            'data' => $download
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
        $download = AboutDownload::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $download
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
        $download = AboutDownload::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'en_title' => 'sometimes|required|string|max:255',
            'ar_title' => 'sometimes|required|string|max:255',
            'en_text' => 'sometimes|required|string',
            'ar_text' => 'sometimes|required|string',
            'android_download_link' => 'sometimes|required|url',
            'ios_download_link' => 'sometimes|required|url' , 
            'huawei_download_link' => 'sometimes|required|url' ,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $download->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'About Download Updated Successfully',
            'data' => $download
        ], 200);
    }
} 