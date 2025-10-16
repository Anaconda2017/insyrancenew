<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use App\UserAddress;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $rows = User::where('role' , 'user')->latest()->get();
        
        
        return response()->json([
            'success' => true,
            'message' => 'Users Fetched Successfully',
            'data' => $rows
        ], 200);
        

    }
    
    
    public function companyindex(Request $request)
    {
        
        $rows = User::where('role' , 'Corporate')->latest()->get();
        
        
        return response()->json([
            'success' => true,
            'message' => 'Corporates Fetched Successfully',
            'data' => $rows
        ], 200);
        

    }
    
    
    public function employeeindex(Request $request)
    {
        
        $rows = User::where('role' , 'employee')->latest()->get();
        
        
        return response()->json([
            'success' => true,
            'message' => 'Employees Fetched Successfully',
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
            'name' => 'required|string|between:2,100',
            'phone' => 'required|digits:11|unique:users',
            'email' => 'required|string|email|max:100|unique:users',
            'role' => '' ,
        ]);
        
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $randomString =  'capital-123456789'; 

        $dateNow = Carbon::now('Africa/Cairo')->format('Y-m-d');
        $timeNow = Carbon::now('Africa/Cairo')->format('h:i:s');

        $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'role' => $request->role,
                'admin_status' => 1 ,
                'active_status' => 1,
                'deactive_status' => 0,
                'password' =>  Hash::make($randomString),
                'delete_status' => 0,
        ]);

        
            return response()->json([
            'message' => 'User Successfully Registered',
            'data' => $user
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
        $row = User::with(['medicalclaims' , 'motorclaims' , 'buildingclaims' , 'medicalpolicy' , 'motorpolicy' , 'buildingpolicy'])->findOrFail($id);
       
       
       return response()->json([
            'success' => true,
            'message' => 'User Data Fetched Successfully',
            'data' => $row
        ], 200);

    }
    
  
 
    public function activeuser($id) {
        $row = User::findorFail($id);
        $row->update([
               'delete_status' => 0
            ]);
            
        return response()->json(['data' => $row , 'success' => 'User Activated Successfully'], 200);        
    }
    
    public function deleteuser($id) {
        $row = User::findorFail($id);
        $row->update([
                'delete_status' => 1
            ]);
            
        return response()->json(['data' => $row , 'success' => 'User Deleted Successfully'], 200);        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $row = User::findorFail($id);
        // return view('backend.users.edit', compact('row'));
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
        $userids  = $request->users_ids;
        if($userids) {
            
            foreach($userids as $userid) {
                
                $user = User::findorFail($userid);
        
                $user->update([
                    'admin_status' => $request->admin_status
               ]);
            }
        } else {
            $user = User::findorFail($id);
        
                $user->update([
                    'admin_status' => $request->admin_status
               ]);
            
        }

       Session::flash('flash_message', 'User updated successfully!');
       return response()->json([ 'success' => 'User updated successfully!'], 200); 
    }
    
    public function updateprofile($id , Request $request) {
        $user = User::find($id);
        
        
        if($request->password) {
            
            $user->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password)
                ]);
                
        } else {
            $user->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                ]);
        }
        
        
        return response()->json([ 'success' => 'User updated successfully!'], 200); 
        
    } 

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findorFail($id);
        $user->update([
            'active_status' => 0
        ]);

        return response()->json(['success' => 'User Disabled Successfully'], 200); 

    }

    public function recover($id)
    {
        $user = User::findorFail($id);
        $user->update([
            'active_status' => 1
        ]);

        return response()->json(['success' => 'User Enabled Successfully'], 200); 

    }
}
