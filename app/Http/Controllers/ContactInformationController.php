<?php

namespace App\Http\Controllers;

use App\ContactInformation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ContactInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = ContactInformation::get()->first();
        
        return response()->json([
            'success' => true,
            'message' => 'Conact Information Fetched Successfully',
            'data' => $rows
        ], 200); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = ContactInformation::findorFail($id);

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
        try {
            $validator = Validator::make($request->all(), [
                'en_contact_title' => 'required|string|max:255',
                'ar_contact_title' => 'required|string|max:255',
                'en_contact_text' => 'required|string|max:255',
                'ar_contact_text' => 'required|string|max:255',

                'en_address' => 'required|string|max:255',
                'ar_address' => 'required|string|max:255',

                'en_meta_title' => 'required|string|max:255',
                'ar_meta_title' => 'required|string|max:255',
                'en_meta_description' => 'required|string|max:255',
                'ar_meta_description' => 'required|string|max:255',

                'first_phone' => 'string|max:255',
                'second_phone' => 'string|max:255',
                'third_phone' => 'string|max:255',
                'fourth_phone' => 'string|max:255',

                'whatsapp' => 'string|max:255',
                'email' => 'required|string|max:255',

                'facebook' => 'nullable|url|max:255',
                'instagram' => 'nullable|url|max:255',
                'twitter' => 'nullable|url|max:255',
                'linkedin' => 'nullable|url|max:255',
                'youtube' => 'nullable|url|max:255',
                'snapchat' => 'nullable|url|max:255',
                'telegram' => 'nullable|url|max:255',
                'tiktok' => 'nullable|url|max:255',

                'google_plus' => 'nullable|url|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }


            $contact = ContactInformation::findOrFail($id);
            $requestArray = $request->all();

            $contact->update($requestArray);

            return response()->json([
                'success' => true,
                'message' => 'Contact Information updated successfully!',
                'contact' => $contact
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating Contact Information: ' . $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
