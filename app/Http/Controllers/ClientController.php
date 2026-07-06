<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Client::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Clients Fetched Successfully',
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
        return view('backend.client.create');  
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
            'client_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'en_client_name' => 'required|string|max:255',
            'ar_client_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {  
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $requestArray = $request->all();

        if ($request->hasFile('client_image')) {
            $file = $request->file('client_image');
            $fileName = time() . Str::random(10) . '.webp';

            // Create directories if they don't exist
            if (!file_exists(public_path('uploads/client'))) {
                mkdir(public_path('uploads/client'), 0777, true);
            }
            
            
            // Process image
            $image = Image::make($file->getRealPath());
            $image->encode('webp', 80)->save(public_path('uploads/client/' . $fileName));

            $requestArray['client_image'] = 'uploads/client/' . $fileName;
        }

        $client = Client::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Client Added Successfully',
            'data' => $client
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
        $row = Client::findorfail($id);

        return response()->json([
            'success' => true,
            'message' => 'Client Fetched Successfully',
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
        $row = Client::findorFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Client Fetched Successfully',
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
        $client = Client::findorFail($id);
        
        $requestArray = $request->all();

        if ($request->hasFile('client_image')) {
            $file = $request->file('client_image');
            $fileName = time() . Str::random(10) . '.webp';

            // Delete old image if exists
            if ($client->client_image) {
                $oldImage = public_path('uploads/client/' . $client->client_image);
                if (file_exists($oldImage)) unlink($oldImage);
            }

            // Process image
            $image = Image::make($file->getRealPath()); 
            $image->encode('webp', 80)->save(public_path('uploads/client/' . $fileName));

            $requestArray['client_image'] = 'uploads/client/' . $fileName;
        }

        $requestArray = ['client_image' => $request->hasFile('client_image') ? 'uploads/client/'.$fileName: $client->client_image] + $request->all();

        $client->update($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Client Updaded Successfully',
            'data' => $client
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
        $client = Client::findorFail($id);

        $client->update([
            'active_status' => 0
            ]);  

        return response()->json([
            'success' => true,
            'message' => 'Client Disabled Successfully',
            'data' => $client
        ], 200); 
    }
    
    public function recover($id)
    {
        $client = Client::findorFail($id);

        $client->update([
            'active_status' => 1
            ]);
         
        return response()->json([
            'success' => true,
            'message' => 'Client Enabled Successfully',
            'data' => $client
        ], 200); 
    }
}
