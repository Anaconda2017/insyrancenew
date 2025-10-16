<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class AuthSignUpController extends Controller
{
    

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'phone' => 'required|unique:users',
            'email' => 'required|string|email|max:100|unique:users',

        ]);
        

    
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lenthNumber = 10;
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $lenthNumber; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $randomString =  $randomString;
        
        
        
        $name = $request->name;
        $phone = $request->phone ;
        $email = $request->email ;
        $password = $randomString;


        $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'role' => 'user',
                'admin_status' => 1 ,
                'active_status' => 1,
                'deactive_status' => 0,
                'password' =>  Hash::make($password),
                'delete_status' => 0,
        ]);
        
        
        Mail::send('frontend.newRegistration' , [
                'name' => $name , 
                'phone' => $phone,
                'email' => $email,
                'password' => $password,
                ], function($message) use (
                    $name , 
                    $phone,
                    $email , 
                    $password
                    )
                {
                    $message->from('bonder@digitalbondmena.com', "Capital Insurance");
                    $message->subject('Your Capital Insurance Account');
                    $message->to($email);
                    
                }); 


        return response()->json([
            'message' => 'User Successfully Registered',
            'user' => $user
        ], 200);
        
    }
    

    public function resetUserCode(Request $request){
        $characters = '0123456789';
        $lenthNumber = 6;
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $lenthNumber; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $randomString =  $randomString; 
        

        $useremail = $request->email;

        $user = User::where('email' , $useremail)->first();
        
        if($user) {
            
                 $user->update([
                    'forget_code' => $randomString
                 ]);


                $username = $user->name;
                $userphone = $user->phone;
                $useremail = $user->email;
                $usercode = $user->forget_code;


                Mail::send('frontend.resetCode' , [
                    'username' => $username , 
                    'userphone' => $userphone,
                    'useremail' => $useremail,
                    'usercode' => $usercode,
                    ], function($message) use (
                        $username , 
                        $userphone,
                        $useremail
                        )
                    {
                        $message->from('bonder@digitalbondmena.com', "Capital Insurance");
                        $message->subject('Reset Your Capital Insurance Password');
                        $message->to($useremail);
                        
                    });  


                    return response()->json([
                        'success' => 'ُEmail Sent Successfully',
                    ], 200); 
                    
        } else {
            return response()->json([
                'error' => 'Your Email Is Wrong',
            ], 200);   
        }
    }

    public function resetUserPassword(Request $request){
        $userEmail = $request->email;
        $resetCode = $request->reset_code;
        $user = User::where('email' , $userEmail)->get()->first();
        
        if($user) {
           $userpassword = $request->password;
           if($user->forget_code == $resetCode){
               if($userpassword) {
                   
                   $user->update([
                        'password' => Hash::make($userpassword)
                   ]);
                   
                   return response()->json([
                    'success' => 'Password Changed Successfully',
                     ], 200);
                     
               } else {
                  return response()->json([
                        'error' => 'Correct OTP.',
                    ], 200);
               }

           } else {
                return response()->json([
                    'error' => 'Incorrect OTP. Please try again.',
                ], 200);   
           }
        } else {
            return response()->json([
                'error' => 'Your Email Is Wrong',
            ], 200);   
        }
    }
}