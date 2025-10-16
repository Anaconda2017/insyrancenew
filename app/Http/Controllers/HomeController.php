<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\NotificationSender;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\ArregationSystem;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use App\ContactInformation;
use App\ContactUsForm;
use App\Partner;
use App\Slider;
use App\AboutUs;
use App\Category;
use App\AboutCounter;
use App\BlogArabic;
use App\BlogEnglish;
use App\MedicalRequest;
use App\MotorRequest;
use App\BuildingRequest;
use App\JopRequest;
use App\BuildingClaim;
use App\MedicalClaim;
use App\MotorClaim;
use App\JopClaim;
use App\Features;
use App\BuildingInsurance;
use App\BuildingLead;
use App\MedicalInsurance;
use App\MedicalLead;
use App\JopInsurance;
use App\JopLead;
use App\MotorInsurance;
use App\MotorLead;
use App\CarBrand;
use App\CarModel;
use App\CarType;
use App\CarYear;
use App\BuildType;
use App\BuildCountry;
use App\Client;
use App\PrivacyPolicy;
use App\Testimonial;
use Illuminate\Support\Facades\Http;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
     
     
     function sendAllUsersNotification(Request $request)
    {
        $message = $request->textmessage;
        $title = $request->titlemessage;
        
        $client = new Client();

        // Prepare the data to send in the POST request
        // dd($title , $message);

    
        
        
        $client = new \GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json',
                        'Accept' => '*/*',
                                ]
                                    ]);
                            $URI = 'https://digitalbondmena.com/insurancenotification/sendPushNotification';
                            $body['titlemessage'] = $title;
                            $body['textmessage'] = $message;
                            
                            $URI_Response = $client->request('GET',$URI,['body'=>json_encode($body)]);
                            $URI_Response =json_decode($URI_Response->getBody(), true);

    
        return response()->json(['success' => 'Notifications sent to all users'], 200);
    }
     
     
     public function stathome() {
         $users = User::where('role' , 'user')->get()->count();
         $medicalPolicy = MedicalRequest::where('request_type' , '!=' , 'corporate-empolyee')->orwhere('request_type' , null)->latest()->get()->count();
         $motorPolicy = MotorRequest::latest()->get()->count();
         $buildingPolicy = BuildingRequest::where('request_type' ,  '!=' , 'corporate-empolyee')->orwhere('request_type' , null)->latest()->get()->count();
         $jopPolicy = JopRequest::where('request_type' ,  '!=' , 'corporate-empolyee')->orwhere('request_type' , null)->latest()->get()->count();
         
         $medicalClaim = MedicalClaim::latest()->get()->count();
         $motorClaim = MotorClaim::latest()->get()->count();
         $buildingClaim = BuildingClaim::latest()->get()->count();
         $jopClaim = JopClaim::latest()->get()->count();
         
         $medicalPolicyConfirmed = MedicalRequest::where('request_type'  ,  '!=' , 'corporate-empolyee')->orwhere('request_type' , null)->where('active_status' , 'confirmed')->latest()->get()->count();
         $motorPolicyConfirmed = MotorRequest::where('active_status' , 'confirmed')->latest()->get()->count();
         $buildingPolicyConfirmed = BuildingRequest::where('request_type' ,  '!=' , 'corporate-empolyee')->orwhere('request_type' , null)->where('active_status' , 'confirmed')->latest()->get()->count();
         $jopPolicyConfirmed = JopRequest::where('request_type' ,  '!=' , 'corporate-empolyee')->orwhere('request_type' , null)->where('active_status' , 'confirmed')->latest()->get()->count();

         
         $medicalPolicyCancelled = MedicalRequest::where('request_type' ,  '!=' , 'corporate-empolyee')->orwhere('request_type' , null)->where('active_status' , 'cancelled')->latest()->get()->count();
         $motorPolicyCancelled = MotorRequest::where('active_status' , 'cancelled')->latest()->get()->count();
         $buildingPolicyCancelled = BuildingRequest::where('request_type' ,  '!=' , 'corporate-empolyee')->orwhere('request_type' , null)->where('active_status' , 'cancelled')->latest()->get()->count();
         $jopPolicyCancelled = JopRequest::where('request_type' ,  '!=' , 'corporate-empolyee')->orwhere('request_type' , null)->where('active_status' , 'cancelled')->latest()->get()->count();

         
         $medicalPolicyPending = MedicalRequest::where('request_type' ,  '!=' , 'corporate-empolyee')->orwhere('request_type' , null)->where('active_status' , 'pending')->latest()->get()->count();
         $motorPolicyPending = MotorRequest::where('active_status' , 'pending')->latest()->get()->count();
         $buildingPolicyPending = BuildingRequest::where('request_type' ,  '!=' , 'corporate-empolyee')->orwhere('request_type' , null)->where('active_status' , 'pending')->latest()->get()->count();
         $jopPolicyPending = JopRequest::where('request_type' ,  '!=' , 'corporate-empolyee')->orwhere('request_type' , null)->where('active_status' , 'pending')->latest()->get()->count();
         
         
         $medicalClaimConfirmed = MedicalClaim::where('status' , 'confirmed')->latest()->get()->count();
         $motorClaimConfirmed = MotorClaim::where('status' , 'confirmed')->latest()->get()->count();
         $buildingClaimConfirmed = BuildingClaim::where('status' , 'confirmed')->latest()->get()->count();
         $jopClaimConfirmed = JopClaim::where('status' , 'confirmed')->latest()->get()->count();

         
         $medicalClaimCancelled = MedicalClaim::where('status' , 'cancelled')->latest()->get()->count();
         $motorClaimCancelled = MotorClaim::where('status' , 'cancelled')->latest()->get()->count();
         $buildingClaimCancelled = BuildingClaim::where('status' , 'cancelled')->latest()->get()->count();
         $jopClaimCancelled = JopClaim::where('status' , 'cancelled')->latest()->get()->count();

         
         $medicalClaimPending = MedicalClaim::where('status' , 'pending')->latest()->get()->count();
         $motorClaimPending = MotorClaim::where('status' , 'pending')->latest()->get()->count();
         $buildingClaimPending = BuildingClaim::where('status' , 'pending')->latest()->get()->count();
         $jopClaimPending = JopClaim::where('status' , 'pending')->latest()->get()->count();
         
         
         
         return response()->json([
            'users' => $users,
        
            // Policies
            'medicalPolicy' => $medicalPolicy,
            'motorPolicy' => $motorPolicy,
            'buildingPolicy' => $buildingPolicy,
            'jobPolicy' => $jopPolicy,
        
            // Claims
            'medicalClaim' => $medicalClaim,
            'motorClaim' => $motorClaim,
            'buildingClaim' => $buildingClaim,
            'jobClaim' => $jopClaim,
        
            // Policy Statuses
            'medicalPolicyConfirmed' => $medicalPolicyConfirmed,
            'motorPolicyConfirmed' => $motorPolicyConfirmed,
            'buildingPolicyConfirmed' => $buildingPolicyConfirmed,
            'jobPolicyConfirmed' => $jopPolicyConfirmed,
        
            'medicalPolicyCancelled' => $medicalPolicyCancelled,
            'motorPolicyCancelled' => $motorPolicyCancelled,
            'buildingPolicyCancelled' => $buildingPolicyCancelled,
            'jobPolicyCancelled' => $jopPolicyCancelled,
        
            'medicalPolicyPending' => $medicalPolicyPending,
            'motorPolicyPending' => $motorPolicyPending,
            'buildingPolicyPending' => $buildingPolicyPending,
            'jobPolicyPending' => $jopPolicyPending,
        
            // Claim Statuses
            'medicalClaimConfirmed' => $medicalClaimConfirmed,
            'motorClaimConfirmed' => $motorClaimConfirmed,
            'buildingClaimConfirmed' => $buildingClaimConfirmed,
            'jobClaimConfirmed' => $jopClaimConfirmed,
        
            'medicalClaimCancelled' => $medicalClaimCancelled,
            'motorClaimCancelled' => $motorClaimCancelled,
            'buildingClaimCancelled' => $buildingClaimCancelled,
            'jobClaimCancelled' => $jopClaimCancelled,
        
            'medicalClaimPending' => $medicalClaimPending,
            'motorClaimPending' => $motorClaimPending,
            'buildingClaimPending' => $buildingClaimPending,
            'jobClaimPending' => $jopClaimPending,
        ], 200);
       
         
     }

     public function getHomeData(Request $request)
    {
        // Get latest 9 active products
        $userID = $request->user_id;
        
        if($userID) {
            $medicalPolicy = MedicalRequest::where('user_id' , $userID)->latest()->get();
            $motorPolicy = MotorRequest::where('user_id' , $userID)->latest()->get();
            $buildingPolicy = BuildingRequest::where('user_id' , $userID)->latest()->get();
            $jopPolicy = JopRequest::where('user_id' , $userID)->latest()->get();
        } else {
            $medicalPolicy = [];
            $motorPolicy = [] ;
            $buildingPolicy = [] ;
            $jopPolicy = [] ;
        }
        
        $slider = Slider::where('active_status' , 1)->latest()->get();
        
        $categories = Category::where('active_status' , 1)->latest()->get();
        $counters = AboutCounter::where('active_status' , 1)->latest()->get();
        
        $ArabicBlog = BlogArabic::where('active_status' , 1)->latest()->limit(3)->get();
        $EnglishBlog = BlogEnglish::where('active_status' , 1)->latest()->limit(3)->get();
        
        $partners = Partner::where('home_status' , 1)->where('active_status' , 1)->latest()->get();
        
        $clients = Client::where('active_status' , 1)->latest()->get();
        
        $testimonials = Testimonial::where('active_status'  , 1)->latest()->get();
        


        return response()->json([
            'medicalPolicy' => $medicalPolicy,
            'motorPolicy' => $motorPolicy,
            'buildingPolicy' => $buildingPolicy,
            'jopPolicy' => $jopPolicy,
            'categories' => $categories,
            'counters' => $counters,
            'ArabicBlog' => $ArabicBlog,
            'EnglishBlog' => $EnglishBlog,
            'partners' => $partners,
            'clients' => $clients,
            'slider' => $slider,
            'testimonials' => $testimonials,
        ], 200);
        
    }
    
    public function getAboutData() {
        
        $about = AboutUs::get()->first();
        $aboutCounters = AboutCounter::where('active_status' , 1)->get();
        
        return response()->json(['about' => $about , 'counters' => $aboutCounters], 200);     
        
    }
    
    public function getContactData() {
        
        $about = ContactInformation::get()->first();
        
        return response()->json(['contact' => $about ], 200);     
        
    }
    
    public function submitform(Request $request) {
         $validator = Validator::make($request->all(), [
             'name' => 'required|string',
             'email' => 'required|email',
             'phone' => 'required',
             'message' => 'required'
         ]);

         if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 200);
        }
        
        
        
            
            $requestArray = $request->all();
            ContactUsForm::create($requestArray);
            
            
            $name = $request->name;
            $phone = $request->phone ;
            $email = $request->email ;
            $newmessage = $request->message ;
            
            Mail::send('frontend.contactform' , [
                'name' => $name , 
                'phone' => $phone,
                'email' => $email,
                'newmessage' => $newmessage,
                ], function($message) use (
                    $name , 
                    $phone,
                    $email , 
                    $newmessage
                    )
                {
                    $message->from('bonder@digitalbondmena.com', "Capital Insurance | You Have a New Message");
                    $message->subject('Capital Insurance | New Message');
                    $message->to('Yousra.Magdy@capital-ib.com');
                    
                }); 
                
                
            Mail::send('frontend.contactform' , [
                'name' => $name , 
                'phone' => $phone,
                'email' => $email,
                'newmessage' => $newmessage,
                ], function($message) use (
                    $name , 
                    $phone,
                    $email , 
                    $newmessage
                    )
                {
                    $message->from('bonder@digitalbondmena.com', "Capital Insurance | You Have a New Message");
                    $message->subject('Capital Insurance | New Message');
                    $message->to('o.mansour@capital-ib.com');
                    
                });     

            return response()->json(['success' => 'Form Added Successfully'], 200); 

     }
     
    public function getArabicBlogs() {
         $rows = BlogArabic::where('active_status' , 1)->latest()->paginate(9);
         
         return response()->json(['rows' => $rows], 200); 
     }
     
    public function getSingleArabicBlogs($slug) {
         $row = BlogArabic::where('ar_slug', $slug)
                ->where('active_status', 1)
                ->first();
    
        $rows = BlogArabic::where('active_status', 1)
                    ->where('id', '!=', $row->id)
                    ->inRandomOrder()
                    ->limit(9)
                    ->get();
                    
        return response()->json([ 'blog' => $row , 'blogs' => $rows], 200);             
     }
     
     
    public function getEnglishBlogs() {
         $rows = BlogEnglish::where('active_status' , 1)->latest()->paginate(9);
         
         return response()->json(['rows' => $rows], 200); 
     }
     
    public function getSingleEnglishBlogs($slug) {
         $row = BlogEnglish::where('en_slug', $slug)
                ->where('active_status', 1)
                ->first();
    
        $rows = BlogEnglish::where('active_status', 1)
                    ->where('id', '!=', $row->id)
                    ->inRandomOrder()
                    ->limit(9)
                    ->get();
                    
        return response()->json([ 'blog' => $row , 'blogs' => $rows], 200);             
     }
    
    public function userdata($id) {
        $row = User::findorFail($id);
            
        return response()->json(['user' => $row], 200);        
    }
    
    public function userclaims($id , Request $request) {
        
        $row = User::findorFail($id);
        if($request->type == 'all') {
        
            $medical = MedicalClaim::where('user_id' , $id)->latest()->get();
            
            $motor = MotorClaim::where('user_id' , $id)->latest()->get();
            
            $building = BuildingClaim::where('user_id' , $id)->latest()->get();
            
            $jop = JopClaim::where('user_id' , $id)->latest()->get();
            
        } else if($request->type == 'medical') {
            
            $medical = MedicalClaim::where('user_id' , $id)->latest()->get();
            
            $motor = [] ;
            
            $building = [];
            
            $jop = [];
            
        } else if($request->type == 'motor') {
            
            $medical = [];
            
            $motor = MotorClaim::where('user_id' , $id)->latest()->get();
            
            $building = [];
            
            $jop = [];
            
        } else if($request->type == 'building') {
            $medical = [];
            
            $motor = [];
            
            $building = BuildingClaim::where('user_id' , $id)->latest()->get();
            
            $jop = [];
        } else if($request->type == 'jop') {
            $medical = [];
            
            $motor = [];
            
            $building = [];
            
            $jop =  JopClaim::where('user_id' , $id)->latest()->get();
        }
            
        return response()->json(['user' => $row , 'medical' => $medical , 'motor' => $motor , 'building' => $building , 'jop' => $jop], 200);        
    }
    
    public function userpolicy($id , Request $request) {
        $row = User::findorFail($id);
        if($request->type == 'all') {
            $medical = MedicalRequest::where('user_id' , $id)->latest()->get();
            
            $motor = MotorRequest::where('user_id' , $id)->latest()->get();
            
            $building = BuildingRequest::where('user_id' , $id)->latest()->get();
            
            $jop = JopRequest::where('user_id' , $id)->latest()->get();
            
        } else if($request->type == 'medical') {
            
            $medical = MedicalRequest::where('user_id' , $id)->latest()->get();
            
            $motor = [] ;
            
            $building = [];
            
            $jop = [] ;
            
        } else if($request->type == 'motor') {
            
            $medical = [];
            
            $motor = MotorRequest::where('user_id' , $id)->latest()->get();
            
            $building = [];
            
            $jop = [] ;
            
        } else if($request->type == 'building') {
            $medical = [];
            
            $motor = [];
            
            $jop = [] ;
            
            $building = BuildingRequest::where('user_id' , $id)->latest()->get();   
        } else if ($request->type == 'jop') {
            $medical = [];
            
            $motor = [];
            
            $jop = JopRequest::where('user_id' , $id)->latest()->get();
            
            $building = [];   
        }
            
        return response()->json(['user' => $row , 'medical' => $medical , 'motor' => $motor , 'building' => $building , 'jop' => $jop], 200);        
    }
    
    public function getUserPolicy($id , Request $request) {
        
        // dd($id , $request->type);
        if($request->type == 'medical') {
            
            $row = MedicalRequest::where('id' , $id)->get()->first();
            
            $row->comments;

        } else if($request->type == 'motor') {
            
            $row = MotorRequest::where('id' , $id)->get()->first();
            $row->comments;
            
        } else if($request->type == 'building') {
            
            $row = BuildingRequest::where('id' , $id)->get()->first();   
            $row->comments;
            
        } else if($request->type == 'jop' || $request->type == 'job') {
            $row = JopRequest::where('id' , $id)->get()->first();   
            $row->comments;
        }
            
        return response()->json(['policy' => $row ], 200);        
    }
    
    public function getUserClaim($id , Request $request) {
        if($request->type == 'medical') {
            
            $row = MedicalClaim::where('id' , $id)->get()->first();
            
            $row->comments;

        } else if($request->type == 'motor') {
            
            $row = MotorClaim::where('id' , $id)->get()->first();
            $row->comments;
            
        } else if($request->type == 'building') {
            
            $row = BuildingClaim::where('id' , $id)->get()->first();   
            $row->comments;
            
        } else if ($request->type == 'jop' || $request->type == 'job') {
            $row = JopClaim::where('id' , $id)->get()->first();   
            $row->comments;   
        }
            
        return response()->json(['claim' => $row ], 200);      
    }
    
    public function storeClaimComment($id , Request $request) {
        
    }
    
    
    public function deactiveuser($id) {
        $row = User::findorFail($id);
        
        $row->update([
               'deactive_status' => 1 
            ]);
            
        return response()->json(['row' => $row , 'success' => 'User Deactivated Successfully'], 200);        
    }
    
    public function deleteuser($id) {
        $row = User::findorFail($id);
        
        $row->update([
                'delete_status' => 1
            ]);
            
        return response()->json(['row' => $row , 'success' => 'User Deleted Successfully'], 200);        
    }
    
    public function updateprofile($id , Request $request) {
        $row = User::findorFail($id);
        
        $gender = $request->gender;
        $birth = $request->birthdate;
        $name = $request->name;
        
        $row->update([
            'gender' => $gender ,
            'birth_date' => $birth ,
            'name' => $name,
            ]);
            
            
        return response()->json(['row' => $row , 'success' => 'User Updated Successfully'], 200);    
    }
    
    public function updatepassword($id , Request $request) {
        $row = User::findorFail($id);
        
        $userpassword = $request->password;
        
        $row->update([
                        'password' => Hash::make($userpassword)
                   ]);
                   
        return response()->json(['row' => $row , 'success' => 'User Password Updated Successfully'], 200);              
    }
    
    
    //  Insurances and Claims
    
    public function getCategories() {
        $categories = Category::where('active_status' , 1)->latest()->get();
     
        return response()->json(['categories' => $categories], 200);      
    }


    public function getsingleCategory($id , Request $request) {
        $categories = Category::where('id' , $id)->latest()->get()->first();
        
        $categories->partners;
        
        
        $requesttype= $request->type;
        $requestemployeenumber = $request->employee_number;
        if($requestemployeenumber) {
            
        } else {
            $requestemployeenumber = 1;
        }
        
        if($requesttype == 'medical') {
            $type = null;
            $polices = $categories->medicalinsurances;
            foreach($polices as $police) {
                $police->medicalchoices   ; 
                $police->year_money = $police->year_money * $requestemployeenumber;
                $police->month_money = $police->month_money * $requestemployeenumber;
            }
        } else if ($requesttype == 'motor') {
            $type = CarType::where('active_status' , 1)->latest()->get();
            $brands = CarBrand::where('active_status', 1)
            ->with(['carModels' => function ($q) {
                    $q->where('active_status', 1);
                }])
            ->latest()
            ->get();
            
            $currentYear = Carbon::now()->year;
            $years = [];
            
            for ($i = 0; $i <= 10; $i++) {
                $years[] = $currentYear - $i;
            }
            
            $polices = $categories->motorinsurances;
            foreach($polices as $police) {
                $police->motorchoices   ; 
                
                $police->year_money = $police->year_money * $requestemployeenumber;
                $police->month_money = $police->month_money * $requestemployeenumber;
            }
            
            return response()->json([
                'category' => $categories , 
                'types' => $type ,
                'brands' => $brands,
                'years' => $years,
                ], 200);
        } else if ($requesttype == 'building') {
            $type = BuildType::where('active_status' , 1)->latest()->get();
            $polices =  $categories->buildinginsurances;
            foreach($polices as $police) {
                $police->buildingchoices   ; 
                
                $police->year_money = $police->year_money * $requestemployeenumber;
                $police->month_money = $police->month_money * $requestemployeenumber;
            }
        } else if ($requesttype == 'jop') {
            $type = null;
            $polices = $categories->jopinsurances;
            foreach($polices as $police) {
                $police->jopchoices   ; 
                
                $police->year_money = $police->year_money * $requestemployeenumber;
                $police->month_money = $police->month_money * $requestemployeenumber;
            }
        }
        
        
        return response()->json(['category' => $categories , 'types' => $type], 200);
    }    
    
    
    
    public function getInsurancesPolicies($id , Request $request) {
        $categories = Category::where('id' , $id)->latest()->get()->first();
        $requesttype = $request->type;
        
        $requestemployeenumber = $request->employee_number;
        if($requestemployeenumber) {
            
        } else {
            $requestemployeenumber = 1;
        }
        
        if($requesttype == 'medical') {
            $type = null;
            $polices = $categories->medicalinsurances;
            foreach($polices as $police) {
                $police->medicalchoices   ; 
                
                $police->year_money = $police->year_money * $requestemployeenumber;
                $police->month_money = $police->month_money * $requestemployeenumber;
            }
        } else if ($requesttype == 'motor') {
            $type = CarType::where('active_status' , 1)->latest()->get();
            $brands = CarBrand::where('active_status', 1)
            ->with(['carModels' => function ($q) {
                    $q->where('active_status', 1);
                }])
            ->latest()
            ->get();
            
            $currentYear = Carbon::now()->year;
            $years = [];
            
            for ($i = 0; $i <= 10; $i++) {
                $years[] = $currentYear - $i;
            }
            
            $polices = $categories->motorinsurances;
            foreach($polices as $police) {
                $police->motorchoices   ; 
                
                $police->year_money = $police->year_money * $requestemployeenumber;
                $police->month_money = $police->month_money * $requestemployeenumber;
            }
            
            return response()->json([
                'category' => $categories , 
                'types' => $type ,
                'brands' => $brands,
                'years' => $years,
                ], 200);
            
        } else if ($requesttype == 'building') {
            $type = BuildType::where('active_status' , 1)->latest()->get();
            $countries = BuildCountry::where('active_status' , 1)->latest()->get();
            $polices = $categories->buildinginsurances;
            foreach($polices as $police) {
                $police->buildingchoices   ; 
                
                $police->year_money = $police->year_money * $requestemployeenumber;
                $police->month_money = $police->month_money * $requestemployeenumber;
            }
            
            return response()->json([
                'category' => $categories , 
                'types' => $type , 
                'countries' => $countries
                ], 200);
        } else if ($requesttype == 'jop') {
            $type = null;
            $polices = $categories->jopinsurances;
            foreach($polices as $police) {
                $police->jopchoices   ; 
                
                $police->year_money = $police->year_money * $requestemployeenumber;
                $police->month_money = $police->month_money * $requestemployeenumber;
            }
        }
        
        return response()->json(['category' => $categories , 'types' => $type], 200);
    }
    
    
    public function getIPoliciesChoices($id , Request $request) {
        $requesttype = $request->type; 
        if($requesttype == 'medical') {
            
            $categories = MedicalInsurance::where('id' , $id)->latest()->get()->first();
            
            $categories->medicalchoices;
        } else if ($requesttype == 'motor') {
            
            $categories = MotorInsurance::where('id' , $id)->latest()->get()->first();
            
            $categories->motorchoices;
            
        } else if ($requesttype == 'building') {
            
            $categories = BuildingInsurance::where('id' , $id)->latest()->get()->first();
            
            $categories->buildingchoices;
            
        } else if ($requesttype == 'jop') {
            $categories = JopInsurance::where('id' , $id)->latest()->get()->first();
            
            $categories->jopchoices;
        }
        
        return response()->json(['ploicy' => $categories ], 200);
    }
    
    public function getMotorBrands($id) {
        $type = CarType::where('id' , $id)->get()->first();
        
        $type->carBrands;
        
        return response()->json(['types' => $type], 200);
    }
    
    public function getMotorModels($id) {
        $type = CarBrand::where('id' , $id)->get()->first();
        
        $type->carBrand;
        
        return response()->json(['types' => $type], 200);
    }
    
    public function getMotorYears($id) {
        $type = CarModel::where('id' , $id)->get()->first();
        
        $type->carYears;
        
        return response()->json(['types' => $type], 200);
    }
    
    public function updateMedicalLead($id , Request $request) {
        
    }
    
     
    public function getCategoriesWithSubcategories()
    {
        // Get active categories with their active subcategories
        $categories = Category::where('active_status', 1)
            ->latest()
            ->with(['subcategories' => function($query) {
                $query->where('active_status', 1)
                    ->latest();
            }])
            ->get();

        return response()->json([
            'categories' => $categories
        ], 200);
    }
    
    
    public function getProductsByCategory($categoryId)
    {
        $categories = Category::where('id', $categoryId)
            ->latest()
            ->with(['subcategories' => function($query) {
                $query->where('active_status', 1)
                    ->latest();
            }])
            ->get()
            ->first();
            
        $products = Product::where('category_id', $categoryId)
            ->where('active_status', 1)
            ->with(['category', 'subcategory'])
            ->latest()
            ->get();
            
        foreach($products as $product) {
            $product->firstChoice;
        }        

        return response()->json([
            'products' => $products,
            'categories' => $categories
        ], 200);
    }

    public function getProductsBySubcategory($subcategoryId)
    {
        $products = Product::where('subcategory_id', $subcategoryId)
            ->where('active_status', 1)
            ->with(['category', 'subcategory'])
            ->latest()
            ->get();
            
            
        foreach($products as $product) {
            $product->firstChoice;
        }    

        return response()->json([
            'products' => $products
        ], 200);
    }

    public function getAllActiveProducts()
    {
        $products = Product::where('active_status', 1)
            ->with(['category', 'subcategory'])
            ->latest()
            ->get();
            
        foreach($products as $product) {
            $product->firstChoice;
        }        

        return response()->json([
            'products' => $products
        ], 200);
    }
    
    public function getSingleProducts($slug)
    {
        $products = Product::where('ar_slug', $slug)->orwhere('en_slug' , $slug)
            ->with(['additional_images', 'choices', 'category', 'subcategory'])
            ->get()
            ->first();
            
            
        $relatedProducts = Product::where('subcategory_id', $products->subcategory_id)
            ->where('active_status', 1)
            ->with(['category', 'subcategory'])
            ->limit(3)
            ->get();    

        return response()->json([
            'product' => $products,
            'relatedProducts' => $relatedProducts
        ], 200);
    }
    
    public function getLocations() {
        $locations = Location::where('active_status' , 1)->get();
        
        return response()->json([
            'locations' => $locations
        ], 200);
    }
    
    public function wishListStore(Request $request) {
        $user = $request->user_id; 
        $product = $request->product_id;
        $userdata = User::where('id' , $request->user_id)->get()->first(); 
        if($userdata) {
            $productdata = Product::where('id' , $product)->get()->first();
            if($productdata) {
                
                $wish = WishList::create([
                        'user_id' => $user,
                        'product_id' => $product,
                    ]);
                    
                return response()->json([
                    'wish' => $wish,
                    'product' => $productdata,
                    'user' => $userdata,
                ], 200); 
                
                
            } else {
               return response()->json([
                'error' => 'No Product Found'
                ], 200);   
            }
                
        } else {
            return response()->json([
            'error' => 'No User Found'
            ], 200);       
        }
        
    }
    
    public function getWishListData($id) {
        $user = User::where('id' , $id)->get()->first();
        
        if($user) {
            
            $wishlists = WishList::where('user_id' , $id)->get();
            foreach($wishlists as $wishlist) {
                $wishlist->product;
            }
            
            return response()->json([
                    'wishs' => $wishlists,
                ], 200); 
            
        } else {
            return response()->json([
            'error' => 'No User Found'
            ], 200); 
        }
    }
    
    public function deleteWishListData($id , Request $request) {
        
            if($id == 'all') {
                $wishlists = WishList::where('user_id' , $request->user_id)->get();
                foreach($wishlists as $wishlist) {
                    $wishlist->delete();
                } 
            } else {
                
                $wishlists = WishList::where('id' , $id)->get()->first();
                $wishlists->delete();
            }
            
            
            
            
            return response()->json([
                    'wishs' => 'Deleted Successfully',
                ], 200); 
            
        
    }
    
    
     


     public function getcontact() {
        $contact = ContactInformation::get()->first();

        return response()->json(['contact' => $contact], 200); 

     }

    
     public function getabout() {
        $aboutdata = AboutUs::get()->first();
        $features = Features::get();
        $faqs = Faq::where('active_status' , 1)->latest()->get();
        
        return response()->json([
            'aboutdata' => $aboutdata , 
            'features' => $features ,
            'faqs' => $faqs ,
            ], 200); 

     }
     
     
     public function getFeatures() {
         $features = Features::where('active_status' , 1)->latest()->get();
         
         return response()->json([
            'features' => $features 
            ], 200); 
     }

     

    
    public function cacheurl() {
        

        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');        

        return response()->json( 200);    

    }


    public function checkCart($id) {
        $user = User::find($id); 
        
        if($user) {
            
            $order = $user->unConfirmedOrder();
            
            if($order) {
                $orderDetails = $order->details()->get();
                foreach($orderDetails as $orderDetail) {
                    
                    $orderDetail->product;
                }
                $promocode = $order->promo_code_id ? PromoCode::find($order->promo_code_id) : null;
                
                return response()->json([
                    'user' => $user,
                    'order' => $order,
                    'orderDetails' => $orderDetails,
                    'promocode' => $promocode
                ], 200);
            } else {
                 return response()->json(['error' => 'No Order Found'], 200);
            }
            
        } else {
            return response()->json([
                    'error' => 'No User Found'
                ], 200);
        }
    }
    
    
    public function addToCart($id , Request $request)
    {
        $user = User::find($id); 
        
        
        if(!$user) {
            return response()->json([
                    'error' => 'No User Found'
                ], 200);
        }
        
        $order = $user->unConfirmedOrder(); 
        
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'choice_id' => 'nullable|exists:product_choices,id'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 200);
        }
        
        if($order) {
            $product = Product::where('id'  , $request->product_id)->get()->first();
            $checkValid = OrderDetail::where('order_id' , $order->id)->where('product_id' , $product->id)->get()->first();
            if(!$product) {
                return response()->json([
                    'error' => 'No Product Found'
                ], 200);
            }
            
            if (!$product->stock_status) {
                return response()->json([
                    'message' => 'Product is out of stock'
                ], 200);
            }
            
            $price = $product->price;
            $choice = null;

            if ($request->choice_id) {
                $choice = ProductChoice::where('product_id', $product->id)
                    ->findOrFail($request->choice_id);

                if ($choice && $choice->cuurent_value > 0) {
                    $price = $choice->cuurent_value;
                }
            } elseif ($product->price_after_sale > 0) {
                $price = $product->price_after_sale;
            }
            
            
            
            if($checkValid) {
                
                $checkValid->update([
                    'quantity' =>  $checkValid->quantity + $request->quantity,
                    'subtotal' => $checkValid->subtotal+ $price*$request->quantity,
                    ]);
                
            } else {
                
                $orderDetails = OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_choice_id' => $request->choice_id,
                        'quantity' => $request->quantity,
                        'unit_price' => $price,
                        'subtotal' => $price*$request->quantity,
                    ]);
                    
            }
            
            $order->update([
                    'subtotal' => $order->subtotal + ($price*$request->quantity)
                ]);
                
            $orderDetails = $order->details;    
                
            return response()->json([
                'message' => 'Product added to cart successfully',
                'cart' => $order,
            ], 200);    
            
        } else {
            $dateNow = Carbon::now('Africa/Cairo')->format('Y-m-d');
            $timeNow = Carbon::now('Africa/Cairo')->format('h:i:s');
            
            $dateNownew = Carbon::now('Africa/Cairo')->format('Ymd');
            $timeNownew = Carbon::now('Africa/Cairo')->format('his');
            
            $product = Product::where('id'  , $request->product_id)->get()->first();
            
            
            if(!$product) {
                return response()->json([
                    'error' => 'No Product Found'
                ], 200);
            }
            
            if (!$product->stock_status) {
                return response()->json([
                    'message' => 'Product is out of stock'
                ], 200);
            }
            
            $price = $product->price;
            $choice = null;

            if ($request->choice_id) {
                $choice = ProductChoice::where('product_id', $product->id)
                    ->findOrFail($request->choice_id);

                if ($choice && $choice->cuurent_value > 0) {
                    $price = $choice->cuurent_value;
                }
            } elseif ($product->price_after_sale > 0) {
                $price = $product->price_after_sale;
            }
            
            
            
            $order = Order::create([
                'order_number' => $dateNownew.''.$timeNownew,
                'user_id' => $id , 
                'subtotal' => $price * $request->quantity,
                'active_status' => 0,
                'order_date' => $dateNow ,
                'order_time' => $timeNow ,
                ]);
                
            $orderDetails = OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_choice_id' => $request->choice_id,
                        'quantity' => $request->quantity,
                        'unit_price' => $price,
                        'subtotal' => $price*$request->quantity,
                    ]);    
                    
            $order->details;        
                    
            return response()->json([
                'message' => 'Product added to cart successfully',
                'cart' => $order,
            ], 200);         
        }

    }
    
    public function updateQuantity($id , Request $request) {
        $checkValid = OrderDetail::where('id' , $id)->get()->first();
            
            if(!$checkValid) {
                return response()->json([
                    'error' => 'Error Updating Item Quantity',
                ], 200);
            } 
            
        $oldprice =  $checkValid->subtotal;
        
        $newprice = $checkValid->unit_price*$request->quantity;
        
        $order = Order::where('id' , $checkValid->order_id)->get()->first();
       
        $order->update([
            'subtotal' => ($order->subtotal - $oldprice) + $newprice     
            ]);
        
        $checkValid->update([
                'quantity' => $request->quantity,
                'subtotal' => $newprice,
            ]);    
            
        $orderDetails = $order->details;      
            
        return response()->json([
                'message' => 'Quantity Updated successfully',
                '$order' => $order,
            ], 200);    
    }
    
    public function removeFromCart($id)
    {
       
            $checkValid = OrderDetail::where('id' , $id)->get()->first();
            
            if(!$checkValid) {
                return response()->json([
                    'error' => 'Error removing item from cart',
                ], 200);
            } 
            
            $checkValid->delete();

            return response()->json([
                'message' => 'Item removed from cart successfully',
            ], 200);

    }
    
    public function removeAllCart($id) {
        $order = Order::where('id' , $id)->get()->first();
        if(!$order) {
            return response()->json(['error' => 'No Order Found'], 200);
        }
        
        $order->delete();
        
        return response()->json([
                'message' => 'Items removed from cart successfully',
            ], 200);
    }
    
    public function checkPromoCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'promo_code' => 'required',
        ]);
        
        $user = User::where('id' , $request->user_id)->get()->first();

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 200);
        }
        
        
            $promoCode = PromoCode::where('code', $request->promo_code)
                ->where('active_status', 1)
                ->first();
                
            if (!$promoCode) {
                return response()->json([
                    'available' => false,
                    'message' => 'Promo code is not active'
                ], 200);
            }    
            // Check if user has used this promo code before
            $hasUsedPromoCode = Order::where('user_id', $request->user_id)
                ->where('promo_code_id', $promoCode->id)
                ->exists();

            if ($hasUsedPromoCode) {
                return response()->json([
                    'available' => false,
                    'message' => 'You have already used this promo code before'
                ], 200);
            }

            // Check promo code validity
            $promoCode = PromoCode::where('code', $request->promo_code)
                ->where('active_status', true)
                ->first();

            
            
            $order = $user->unConfirmedOrder();
            
            if(!$order) {
                return response()->json([
                    'message' => 'No Order Found'
                ], 200);
            }
            
            


            // Calculate potential discount
            $discount = $promoCode->calculateDiscount($order->subtotal);
            
            $discount = $order->subtotal - $discount;
            
            $order->update([
                    'promo_code_id' => $promoCode->id,
                    'promo_code_value' => $discount
                ]);

            return response()->json([
                'available' => true,
                'message' => 'Promo code is valid',
                'discount' => $discount,
                'promo_code' => [
                    'code' => $promoCode->code,
                    'type' => $promoCode->type,
                    'value' => $promoCode->value
                ]
            ], 200);

        
    }

    public function placeOrder($id ,Request $request) {
        $order = Order::where('id' , $id)->get()->first();
        if(!$order) {
            return response()->json(['error' => 'No Order Found'], 200);
        }
        
        $dateNow = Carbon::now('Africa/Cairo')->format('Y-m-d');
        $timeNow = Carbon::now('Africa/Cairo')->format('h:i:s');
            
        $order->update([
                'order_status' => 'placed' ,
                'active_status' => 1,
                'order_date' => $dateNow,
                'order_time' => $timeNow,
            ]);
            
        return response()->json([
                    'message' => 'Order Placed Successfully'
                ], 200);    
    }
    
    public function checkout($id ,Request $request) {
        $order = Order::where('id' , $id)->get()->first();
        if(!$order) {
            return response()->json(['error' => 'No Order Found'], 200);
        }
        
        $address = UserAddress::where('id' , $request->address_id)->get()->first();
        $location = $address->location;
        
        $delivry = $location->delivery_amount;
        $tax = $order->subtotal*(15/100);
        
        
        
        $totalprice = $order->subtotal + $delivry + $tax - $order->promo_code_value;
        $dateNow = Carbon::now('Africa/Cairo')->format('Y-m-d');
            $timeNow = Carbon::now('Africa/Cairo')->format('h:i:s');
            
        $order->update([
                'tax' => $tax ,
                'shipping' => $delivry,
                'user_address_id' => $address->id,
                'total' => $totalprice,
                'order_date' => $dateNow,
                'order_time' => $timeNow,
            ]);
            
        $order->details;    
            
        return response()->json([
                    'order' => $order ,
                    
                ], 200);   
    }
    
    public function getprivacy() {
        $privacy = PrivacyPolicy::get()->first();
        
        return response()->json([
            'success' => true,
            'message' => 'Privacy Policy Fetched Successfully',
            'data' => $privacy
        ], 200);
    }
    
    public function updateprivacy(Request $request) {
        $privacy = PrivacyPolicy::get()->first();
        
        $validator = Validator::make($request->all(), [
            'en_title' => 'required|string',
            'ar_title' => 'required|string',
            'en_description' => 'required|string',
            'ar_description' => 'required|string',
        ]);

        if ($validator->fails()) {  
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $requestArray = $request->all();


        $privacy->update($requestArray);
        
        return response()->json([
            'success' => true,
            'message' => 'Privacy Policy Updated Successfully',
            'data' => $privacy
        ], 200);
    }

}
