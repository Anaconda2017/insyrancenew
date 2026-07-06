<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthSignInController extends Controller
{
    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(Request $request)
    {
        $email = $request->email;

        $findUser = User::where('email', $email)->first();
        
        
        if($findUser) {
                $findUser->manager;
                 if($findUser->active_status == 0) {

                    if(Hash::check($request->password, $findUser->password)) {
                        $findUser->update([
                            'active_status' =>1 , 
                            'device_token' => $request->device_token,
                            ]);
                        $token = auth()->login($findUser);
                        return $this->respondWithToken($token);
                        
                    } else {
                        return response()->json([
                            'error' => 'Incorrect Password. Please try again.', 
                            'user' => $findUser
                            ] , 200);
                    }  

                } else if($findUser->deactive_status == 1) {
                        
                    if(Hash::check($request->password, $findUser->password)) {
                        $findUser->update([
                            'deactive_status' =>0 , 
                            'device_token' => $request->device_token,
                            ]);
                        $token = auth()->login($findUser);
                        return $this->respondWithToken($token);
                        
                    } else {
                        return response()->json([
                            'error' => 'Incorrect Password. Please try again.', 
                            'user' => $findUser
                            ] , 200);
                    }    
                     
    
                } else if($findUser->delete_status == 1) {
                        
                        return response()->json([
                            'error' => 'Your Account Has been Deleted', 
                            'user' => $findUser
                            ] , 200);
                     
                } else if($findUser->admin_status == 0) {
                        
                        return response()->json([
                            'error' => 'Your Account Has been Stopped', 
                            'user' => $findUser
                            ] , 200);
                     
                } else if ($findUser->device_token == null || $findUser->device_token != null) {
                    
                    $findUser->update([
                        'device_token' => $request->device_token,
                    ]);

                if(Hash::check($request->password, $findUser->password)) {
                    $token = auth()->login($findUser);
                    return $this->respondWithToken($token);
                } else {
                    return response()->json([
                        'error' => 'Incorrect Password. Please try again.', 
                        'user' => $findUser
                        ] , 200);
                }

            } else {
                if(Hash::check($request->password, $findUser->password)) {
                    $token = auth()->login($findUser);
                    return $this->respondWithToken($token);
                    
                } else {
                    return response()->json([
                        'error' => 'Incorrect Password. Please try again.', 
                        'user' => $findUser
                        ] , 200);
                }
            }

        } else {

            return response()->json([
                'error' => 'Incorrect email. Please try again.', 
                ] , 200);
        }
        

    }
    
   
    public function signinApple(Request $request) {
        $email = $request->email;

        $findAppleuser = User::where('apple_id' , $request->apple_id)->first();
        
        if($request->apple_id) {
            
            if($findAppleuser) {
                     if($findAppleuser->admin_status == 0) {
    
                        return response()->json([
                        'en_error' => 'Your Account Has been Stopped', 
                        'user' => $findAppleuser
                        ] , 200);   
    
                    } else if ($findAppleuser->active_status == 0) {
                        
                            $findAppleuser->update([
                                'active_status' =>1 , 
                                'device_token' => $request->device_token,
                                ]);
                                $token = auth()->login($findAppleuser);
                                return $this->respondWithToken($token);
                        
                        
                        
                    } else if($findAppleuser->deactive_status == 1) {
                            
                        
                                $findAppleuser->update([
                                    'deactive_status' =>0,
                                    'device_token' => $request->device_token,
                                    ]);
                                $token = auth()->login($findAppleuser);
                                return $this->respondWithToken($token);
                                
                            
                             
        
                    } else if($findAppleuser->delete_status == 1) {
                            
                            return response()->json([
                                'en_error' => 'Your Account Has been Deleted', 
                                'user' => $findAppleuser
                                ] , 200);
                         
                    } else if ($findAppleuser->device_token == null || $findAppleuser->device_token != null) {
                        
                        $findAppleuser->update([
                        'device_token' => $request->device_token,
                            ]);
        

                            $token = auth()->login($findAppleuser);
                            return $this->respondWithToken($token);
                        
                
                }
    
            } else {
                
                $user = User::create([
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'apple_id' => $request->apple_id,
                    'device_token' => $request->device_token,
                    'role' => 'user' ,
                    'password' => '' , 
                    'name' => $request->name
                    ]);
                    
                $token = auth()->login($user);
                return $this->respondWithToken($token);   
            }
            
        } else {
            return response()->json([
                            'error' => 'Incorrect Email Or Password. Please try again.', 
                            ] , 200);
        }
    }
    
    public function signinGoogle(Request $request) {
        $email = $request->email;

        $findAppleuser = User::where('google_id' , $request->google_id)->first();
        
        if($request->google_id) {
            
            if($findAppleuser) {
                    if($findAppleuser->admin_status == 0) {
    
                        return response()->json([
                        'en_error' => 'Your Account Has been Stopped', 
                        'user' => $findAppleuser
                        ] , 200);   
    
                    } else if ($findAppleuser->active_status == 0) {
                        
                            $findAppleuser->update([
                                'active_status' =>1 , 
                                'device_token' => $request->device_token,
                                ]);
                                $token = auth()->login($findAppleuser);
                                return $this->respondWithToken($token);
                        
                        
                        
                    } else if($findAppleuser->deactive_status == 1) {
                            
                        
                                $findAppleuser->update([
                                    'deactive_status' =>0 ,
                                    'device_token' => $request->device_token,
                                    ]);
                                $token = auth()->login($findAppleuser);
                                return $this->respondWithToken($token);
                                
                            
                             
        
                    } else if($findAppleuser->delete_status == 1) {
                            
                            return response()->json([
                                'en_error' => 'Your Account Has been Deleted', 
                                'user' => $findAppleuser
                                ] , 200);
                         
                    } else if ($findAppleuser->device_token == null || $findAppleuser->device_token != null) {
                        
                        $findAppleuser->update([
                        'device_token' => $request->device_token,
                            ]);
        
                            $token = auth()->login($findAppleuser);
                            return $this->respondWithToken($token);
                        
                    }
    
            } else {
                
                $findUser = User::where('email', $request->email)->first();
                
                if($findUser) {
                    $token = auth()->login($findUser);
                    return $this->respondWithToken($token);
                } else {
                    
                    $user = User::create([
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'google_id' => $request->google_id,
                        'device_token' => $request->device_token,
                        'role' => 'user' ,
                        'password' => '', 
                        'name' => $request->name
                        ]);
                        
                    $token = auth()->login($user);
                    return $this->respondWithToken($token);    
                } 
            }
            
        } else {
            return response()->json([
                            'error' => 'Incorrect Email Or Password. Please try again.', 
                            ] , 200);
        }
    }
    
    public function createuserpass(Request $request) {
        $userdata = $request->user_id;
        $password = $request->password;
        
        $user = User::where('id' , $userdata)->get()->first();
        
        $user->update([
            'password' => Hash::make($password)
            ]);
            
        return response()->json([
                            'success' => 'User Password Created Successfully', 
                            ] , 200);
    }
    
    
    public function updateuserpass(Request $request) {
        
        $userdata = $request->user_id;
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        
        $user = User::where('id' , $userdata)->get()->first();
        
        if($request->email) {
            
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:100|unique:users',
    
            ]);
            
            if($validator->fails()){
                return response()->json(['errors' => $validator->errors()], 400);
            }
            
            
        
            $user->update([
            'email' => $email,
            ]);
            
        }
        
        if($request->phone) {
            $validator = Validator::make($request->all(), [
            'phone' => 'required|unique:users',

            ]);
            
            if($validator->fails()){
                return response()->json(['errors' => $validator->errors()], 400);
            }
            
            $user->update([
            'phone' => $phone,
            ]);
        }
        
        
        if($request->name) {
            $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',

            ]);
            
            if($validator->fails()){
                return response()->json(['errors' => $validator->errors()], 400);
            }
            
            $user->update([
            'name' => $name,
            ]);
        }
        
        
            
        return response()->json([
                            'success' => 'User profile updated Successfully', 
                            ] , 200);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 600000000,
            'message' => 'sucess',
            'user' => auth()->user(),
            'password' => auth()->user()->password
        ]);
    }
}