<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicalRequestCommentController;
use App\Http\Controllers\MedicalRequestController;
use App\Http\Controllers\MotorRequestController;
use App\Http\Controllers\BuildingRequestController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\CarTypeController;
use App\Http\Controllers\CarBrandController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\CarYearController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\AboutUsController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

    // Health check endpoint for monitoring
    Route::get('/health', function () {
        try {
            DB::connection()->getPdo();
            return response()->json([
                'status' => 'ok',
                'database' => 'connected',
                'timestamp' => now()->toIso8601String()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'database' => 'disconnected',
                'message' => 'Database connection failed',
                'timestamp' => now()->toIso8601String()
            ], 500);
        }
    });

    // features routes



    Route::prefix('auth')->group(function () {
        Route::post('/signin', 'AuthSignInController@signin');
        Route::post('/signinGoogle', 'AuthSignInController@signinGoogle');
        Route::post('/signinApple', 'AuthSignInController@signinApple');
        
        Route::post('/signup', 'AuthSignUpController@signup');
        Route::post('/resetUserCode', 'AuthSignUpController@resetUserCode');
        Route::post('/resetUserPassword', 'AuthSignUpController@resetUserPassword');
        
        
        Route::post('/create-password', 'AuthSignInController@createuserpass');
        Route::post('/update-data', 'AuthSignInController@updateuserpass');
    });
    
    
    
    Route::post('/sendAllUsersNotification', 'DashboardController@sendAllUsersNotification');
    Route::get('/getNotificationLog', 'DashboardController@getNotificationLog');
    
    Route::get('/admincommecnts', 'DashboardController@admincommecnts');
    
    
    
    Route::get('/getExpirePolicy', 'DashboardController@getExpirePolicy');
    
    
    
    Route::prefix('users')->group(function () {
        Route::get('/', 'UsersController@index');
        Route::get('/company', 'UsersController@index');
        Route::get('/employee', 'UsersController@employeeindex');
        Route::post('/', 'UsersController@store');
        Route::get('/{id}', 'UsersController@show');
        Route::post('/{id}/delete', 'UsersController@deleteuser');
        Route::post('/{id}/enable', 'UsersController@activeuser');
    });
    
    
    Route::prefix('app-home')->group(function () {
        Route::get('/getHomeData', 'HomeController@getHomeData');
        Route::get('/getAboutData', 'HomeController@getAboutData');
        Route::get('/getContactData', 'HomeController@getContactData');
        Route::post('/submitContact', 'HomeController@submitform');
        Route::get('/getFeatures', 'HomeController@getFeatures');
        
    });
    
    Route::prefix('company-medical')->group(function () {
        Route::post('/store', 'MedicalRequestController@storepolicyUser');
        Route::post('/delete', 'MedicalRequestController@deletepolicy');
        Route::post('/empolyee-policy', 'MedicalRequestController@getotherpolicy');
    });
    
    Route::prefix('company-jop')->group(function () {
        Route::post('/store', 'JopRequestController@storepolicyUser');
        Route::post('/delete', 'JopRequestController@deletepolicy');
        Route::post('/empolyee-policy', 'JopRequestController@getotherpolicy');
    });
    
    Route::prefix('company-building')->group(function () {
        Route::post('/store', 'BuildingRequestController@storepolicyUser');
        Route::post('/delete', 'BuildingRequestController@deletepolicy');
        Route::post('/empolyee-policy', 'BuildingRequestController@getotherpolicy');
    });
    
    Route::prefix('app-blogs')->group(function () {
        
        Route::get('/getArabicBlogs', 'HomeController@getArabicBlogs');
        Route::get('/getSingleArabicBlogs/{slug}', 'HomeController@getSingleArabicBlogs');
        
        Route::get('/getEnglishBlogs', 'HomeController@getEnglishBlogs');
        Route::get('/getSingleEnglishBlogs/{slug}', 'HomeController@getSingleEnglishBlogs');
        
    });
    
    
    Route::prefix('app-category')->group(function () {
        
        Route::get('/getCategories', 'HomeController@getCategories');
        Route::get('/getsingleCategory/{id}', 'HomeController@getsingleCategory');
        
    });
    
    
    
    
    
    Route::prefix('app-policies')->group(function () {
        
        Route::get('/policies-content/{id}', 'HomeController@getInsurancesPolicies');
        Route::get('/policies-choices/{id}', 'HomeController@getIPoliciesChoices');
        
        Route::get('/policy-single/{id}', 'HomeController@getUserPolicy');
        
        Route::post('/policies-medical-store', 'MedicalRequestController@store');
        Route::post('/policies-motor-store', 'MotorRequestController@store');
        Route::post('/policies-building-store', 'BuildingRequestController@store');
        Route::post('/policies-jop-store', 'JopRequestController@store');
        
        
        Route::post('/building-comment/{id}', 'BuildingRequestCommentController@store');
        Route::post('/motor-comment/{id}', 'MotorRequestCommentController@store');
        Route::post('/medical-comment/{id}', 'MedicalRequestCommentController@store');
        Route::post('/jop-comment/{id}', 'JopRequestCommentController@store');
        
    });
    
    
    Route::prefix('app-claims')->group(function () {
        
        Route::post('/claim-medical-store', 'MedicalClaimController@store');
        Route::post('/claim-motor-store', 'MotorClaimController@store');
        Route::post('/claim-building-store', 'BuildingClaimController@store');
        Route::post('/claim-jop-store', 'JopClaimController@store');
        
        Route::get('/claim-single/{id}', 'HomeController@getUserClaim');
        
        Route::post('/building-comment', 'BuildingClaimCommentController@store');
        Route::post('/motor-comment', 'MotorClaimCommentController@store');
        Route::post('/medical-comment', 'MedicalClaimCommentController@store');
        Route::post('/jop-comment', 'JopClaimCommentController@store');
        
    });
    
    
    Route::prefix('app-leads')->group(function () {
        Route::post('/medical-lead', 'MedicalLeadController@store');
        Route::get('/medical-get/{id}', 'MedicalLeadController@show');
        Route::post('/medical-update/{id}', 'MedicalLeadController@update');
        
        Route::post('/motor-lead', 'MotorLeadController@store');
        Route::get('/motor-get/{id}', 'MotorLeadController@show');
        Route::post('/motor-update/{id}', 'MotorLeadController@update');
        
        Route::post('/building-lead', 'BuildingLeadController@store');
        Route::get('/building-get/{id}', 'BuildingLeadController@show');
        Route::post('/building-update/{id}', 'BuildingLeadController@update');
        
        Route::post('/jop-lead', 'JopLeadController@store');
        Route::get('/jop-get/{id}', 'JopLeadController@show');
        Route::post('/jop-update/{id}', 'JopLeadController@update');
        
    });
    
    Route::prefix('app-profile')->group(function () {
        Route::get('/userdata/{id}', 'HomeController@userdata');
        Route::get('/userclaims/{id}', 'HomeController@userclaims');
        Route::get('/userpolicy/{id}', 'HomeController@userpolicy');
        
        Route::post('/deactiveuser/{id}', 'HomeController@deactiveuser');
        Route::post('/deleteuser/{id}', 'HomeController@deleteuser');
        
        Route::post('/updateprofile/{id}', 'HomeController@updateprofile');
        Route::post('/updatepassword/{id}', 'HomeController@updatepassword');
        
    });
    
    
    Route::prefix('about-download')->group(function () {
            Route::get('/', 'AboutDownloadController@index');
        });
        
    Route::prefix('privacy-policy')->group(function () {
            Route::get('/', 'HomeController@getprivacy');
        }); 
        
    Route::prefix('claim-info')->group(function () {
            Route::get('/{id}', 'ClaimInfoController@show');
        });    
    
    // Route::middleware('auth.api')->group(function () {   
        
        Route::prefix('dashboard-home')->group(function () {
            Route::get('/stathome', 'HomeController@stathome');
        });

        Route::prefix('features')->group(function () {
            Route::get('/', 'FeaturesController@index');
            Route::post('/', 'FeaturesController@store');
            Route::get('/{id}', 'FeaturesController@show');
            Route::post('/{id}', 'FeaturesController@update');
            Route::post('/{id}/delete', 'FeaturesController@destroy');
            Route::post('/{id}/recover', 'FeaturesController@recover');
        });
        
        // testimonials routes
    
        Route::prefix('testimonials')->group(function () {
            Route::get('/', 'TestimonialController@index');
            Route::post('/', 'TestimonialController@store');
            Route::get('/{id}', 'TestimonialController@show');
            Route::post('/{id}', 'TestimonialController@update');
            Route::post('/{id}/delete', 'TestimonialController@destroy');
            Route::post('/{id}/recover', 'TestimonialController@recover');
        });
    
        // about routes
    
        Route::prefix('about-counters')->group(function () {
            Route::get('/', 'AboutCounterController@index');
            Route::post('/', 'AboutCounterController@store');
            Route::get('/{id}', 'AboutCounterController@show');
            Route::post('/{id}', 'AboutCounterController@update');
        });
        
        
        Route::prefix('about-us')->group(function () {
            Route::get('/', 'AboutUsController@index');
            Route::get('/{id}', 'AboutUsController@show');
            Route::post('/{id}', 'AboutUsController@update');
        });
        
        Route::prefix('claim-info')->group(function () {
            Route::get('/', 'ClaimInfoController@index');
            Route::post('/{id}', 'ClaimInfoController@update');
        });
    
        Route::prefix('about-download')->group(function () {
            Route::post('/', 'AboutDownloadController@store');
            Route::get('/{id}', 'AboutDownloadController@show');
            Route::post('/{id}', 'AboutDownloadController@update');
        });
        
        // adminstration routes
    
        Route::prefix('adminstrations')->group(function () {
            Route::get('/', 'AdminstrationController@index');
            Route::post('/', 'AdminstrationController@store');
            Route::get('/{id}', 'AdminstrationController@show');
            Route::post('/{id}', 'AdminstrationController@update');
            Route::post('/{id}/delete', 'AdminstrationController@destroy');
            Route::post('/{id}/recover', 'AdminstrationController@recover');
        });
    
        // building routes
    
        Route::prefix('build-types')->group(function () {
            Route::get('/', 'BuildTypeController@index');
            Route::post('/', 'BuildTypeController@store');
            Route::get('/{id}', 'BuildTypeController@show');
            Route::post('/{id}', 'BuildTypeController@update');
            Route::post('/{id}/delete', 'BuildTypeController@destroy');
            Route::post('/{id}/recover', 'BuildTypeController@recover');
        });
    
    
        Route::prefix('build-countries')->group(function () {
            Route::get('/', 'BuildCountryController@index');
            Route::post('/', 'BuildCountryController@store');
            Route::get('/{id}', 'BuildCountryController@show');
            Route::post('/{id}', 'BuildCountryController@update');
            Route::post('/{id}/delete', 'BuildCountryController@destroy');
            Route::post('/{id}/recover', 'BuildCountryController@recover');
        });
        
        // car routes
    
        Route::prefix('car-types')->group(function () {
            Route::get('/', 'CarTypeController@index');
            Route::post('/', 'CarTypeController@store');
            Route::get('/{id}', 'CarTypeController@show');
            Route::post('/{id}', 'CarTypeController@update');
            Route::post('/{id}/delete', 'CarTypeController@destroy');
            Route::post('/{id}/recover', 'CarTypeController@recover');
        });
    
        Route::prefix('car-brands')->group(function () {
            Route::get('/', 'CarBrandController@index');
            Route::post('/', 'CarBrandController@store');   
            Route::get('/{id}', 'CarBrandController@show');
            Route::post('/{id}', 'CarBrandController@update');
            Route::post('/{id}/delete', 'CarBrandController@destroy');
            Route::post('/{id}/recover', 'CarBrandController@recover');
        });
    
        Route::prefix('car-models')->group(function () {
            Route::get('/', 'CarModelController@index');
            Route::post('/', 'CarModelController@store');
            Route::get('/{id}', 'CarModelController@show');
            Route::post('/{id}', 'CarModelController@update');
            Route::post('/{id}/delete', 'CarModelController@destroy');
            Route::post('/{id}/recover', 'CarModelController@recover');
        });
    
        Route::prefix('car-years')->group(function () {
            Route::get('/', 'CarYearController@index');
            Route::post('/', 'CarYearController@store');
            Route::get('/{id}', 'CarYearController@show');
            Route::post('/{id}', 'CarYearController@update');
            Route::post('/{id}/delete', 'CarYearController@destroy');
            Route::post('/{id}/recover', 'CarYearController@recover');
        });
        
        
        // medical routes
    
        Route::prefix('medical-requests')->group(function () {
            Route::get('/', 'MedicalRequestController@index');
            Route::post('/', 'MedicalRequestController@store');
            Route::get('/{id}', 'MedicalRequestController@show');
            Route::post('/{id}', 'MedicalRequestController@update');
            Route::post('/{id}/delete', 'MedicalRequestController@destroy');
            Route::post('/{id}/recover', 'MedicalRequestController@recover');
        });
    
        Route::prefix('medical-request-comments')->group(function () {
            Route::get('/{id}', 'MedicalRequestCommentController@index');
            Route::post('/{id}/store', 'MedicalRequestCommentController@store');
        });
    
        Route::prefix('medical-insurances')->group(function () {
            Route::get('/', 'MedicalInsuranceController@index');
            Route::post('/', 'MedicalInsuranceController@store');
            Route::get('/{id}', 'MedicalInsuranceController@show');
            Route::post('/{id}', 'MedicalInsuranceController@update');
            Route::post('/{id}/delete', 'MedicalInsuranceController@destroy');
            Route::post('/{id}/recover', 'MedicalInsuranceController@recover');
        });
    
        Route::prefix('medical-insurance-choices')->group(function () {
            Route::get('/', 'MedicalInsuranceChoiceController@index');
            Route::post('/', 'MedicalInsuranceChoiceController@store');
            Route::get('/{id}', 'MedicalInsuranceChoiceController@show');
            Route::post('/{id}', 'MedicalInsuranceChoiceController@update');
            Route::post('/{id}/delete', 'MedicalInsuranceChoiceController@destroy');
            Route::post('/{id}/recover', 'MedicalInsuranceChoiceController@recover');
        });
        
        
        // Jop 
        
        
        Route::prefix('jop-requests')->group(function () {
            Route::get('/', 'JopRequestController@index');
            Route::post('/', 'JopRequestController@store');
            Route::get('/{id}', 'JopRequestController@show');
            Route::post('/{id}', 'JopRequestController@update');
            Route::post('/{id}/delete', 'JopRequestController@destroy');
            Route::post('/{id}/recover', 'JopRequestController@recover');
        });
    
        Route::prefix('jop-request-comments')->group(function () {
            Route::get('/{id}', 'JopRequestCommentController@index');
            Route::post('/{id}/store', 'JopRequestCommentController@store');
        });
    
        Route::prefix('jop-insurances')->group(function () {
            Route::get('/', 'JopInsuranceController@index');
            Route::post('/', 'JopInsuranceController@store');
            Route::get('/{id}', 'JopInsuranceController@show');
            Route::post('/{id}', 'JopInsuranceController@update');
            Route::post('/{id}/delete', 'JopInsuranceController@destroy');
            Route::post('/{id}/recover', 'JopInsuranceController@recover');
        });
    
        Route::prefix('jop-insurance-choices')->group(function () {
            Route::get('/', 'JopInsuranceChoiceController@index');
            Route::post('/', 'JopInsuranceChoiceController@store');
            Route::get('/{id}', 'JopInsuranceChoiceController@show');
            Route::post('/{id}', 'JopInsuranceChoiceController@update');
            Route::post('/{id}/delete', 'JopInsuranceChoiceController@destroy');
            Route::post('/{id}/recover', 'JopInsuranceChoiceController@recover');
        });
    
        // motor routes
    
        Route::prefix('motor-requests')->group(function () {
            Route::get('/', 'MotorRequestController@index');
            Route::post('/', 'MotorRequestController@store');
            Route::get('/{id}', 'MotorRequestController@show');
            Route::post('/{id}', 'MotorRequestController@update');
            Route::post('/{id}/delete', 'MotorRequestController@destroy');
            Route::post('/{id}/recover', 'MotorRequestController@recover');
        });
    
        Route::prefix('motor-request-comments')->group(function () {
            Route::get('/{id}', 'MotorRequestCommentController@index');
            Route::post('/{id}/store', 'MotorRequestCommentController@store');
        });
    
        Route::prefix('motor-insurances')->group(function () {
            Route::get('/', 'MotorInsuranceController@index');
            Route::post('/', 'MotorInsuranceController@store');
            Route::get('/{id}', 'MotorInsuranceController@show');
            Route::post('/{id}', 'MotorInsuranceController@update');
            Route::post('/{id}/delete', 'MotorInsuranceController@destroy');
            Route::post('/{id}/recover', 'MotorInsuranceController@recover');
        });
    
        Route::prefix('motor-insurance-choices')->group(function () {
            Route::get('/', 'MotorInsuranceChoiceController@index');
            Route::post('/', 'MotorInsuranceChoiceController@store');
            Route::get('/{id}', 'MotorInsuranceChoiceController@show');
            Route::post('/{id}', 'MotorInsuranceChoiceController@update');
            Route::post('/{id}/delete', 'MotorInsuranceChoiceController@destroy');
            Route::post('/{id}/recover', 'MotorInsuranceChoiceController@recover');
        });
        
        // Building routes
    
        Route::prefix('building-requests')->group(function () {
            Route::get('/', 'BuildingRequestController@index');
            Route::post('/', 'BuildingRequestController@store');
            Route::get('/{id}', 'BuildingRequestController@show');
            Route::post('/{id}', 'BuildingRequestController@update');
            Route::post('/{id}/delete', 'BuildingRequestController@destroy');
            Route::post('/{id}/recover', 'BuildingRequestController@recover');
        });
    
        Route::prefix('building-request-comments')->group(function () {
            Route::get('/{id}', 'BuildingRequestCommentController@index');
            Route::post('/{id}/store', 'BuildingRequestCommentController@store');
        });
    
        Route::prefix('building-insurance-choices')->group(function () {
            Route::get('/', 'BuildingInsuranceChoiceController@index');
            Route::post('/', 'BuildingInsuranceChoiceController@store');
            Route::get('/{id}', 'BuildingInsuranceChoiceController@show');
            Route::post('/{id}', 'BuildingInsuranceChoiceController@update');
            Route::post('/{id}/delete', 'BuildingInsuranceChoiceController@destroy');
            Route::post('/{id}/recover', 'BuildingInsuranceChoiceController@recover');
        });
    
        Route::prefix('building-insurances')->group(function () {
            Route::get('/', 'BuildingInsuranceController@index');
            Route::post('/', 'BuildingInsuranceController@store');
            Route::get('/{id}', 'BuildingInsuranceController@show');
            Route::post('/{id}', 'BuildingInsuranceController@update');
            Route::post('/{id}/delete', 'BuildingInsuranceController@destroy');
            Route::post('/{id}/recover', 'BuildingInsuranceController@recover');
        });
    
        // Slider routes
    
        Route::prefix('sliders-log')->group(function () {
            Route::get('/', 'SliderController@index');
            Route::post('/', 'SliderController@store');
            Route::get('/{id}', 'SliderController@show');
            Route::post('/{id}', 'SliderController@update');
            Route::post('/{id}/delete', 'SliderController@destroy');
            Route::post('/{id}/recover', 'SliderController@recover');
        });
    
        // Blog Arabic routes
    
        Route::prefix('blogs-arabic')->group(function () {
            Route::get('/', 'BlogController@index');
            Route::post('/', 'BlogController@store');
            Route::get('/{id}', 'BlogController@show');
            Route::post('/{id}', 'BlogController@update');
            Route::post('/{id}/delete', 'BlogController@destroy');
            Route::post('/{id}/recover', 'BlogController@recover');
        });
    
        // Blog English routes
    
        Route::prefix('blogs-english')->group(function () {
            Route::get('/', 'BlogEnglishController@index');
            Route::post('/', 'BlogEnglishController@store');
            Route::get('/{id}', 'BlogEnglishController@show');
            Route::post('/{id}', 'BlogEnglishController@update');
            Route::post('/{id}/delete', 'BlogEnglishController@destroy');
            Route::post('/{id}/recover', 'BlogEnglishController@recover');
        });
    
        // Contact Us routes
    
        Route::prefix('contact-us')->group(function () {
            Route::get('/', 'ContactInformationController@index');
            Route::post('/{id}', 'ContactInformationController@update');
        });
        
        
        Route::prefix('privacy-policy')->group(function () {
            Route::post('/', 'HomeController@updateprivacy');
        });
        
        
    
        // Contact Us form routes    
    
        Route::prefix('contact-us-form')->group(function () {
            Route::get('/', 'ContactUsFormController@index');
            Route::post('/', 'ContactUsFormController@store');
            Route::get('/{id}', 'ContactUsFormController@show');
        });
        
    
        // medical claims routes
    
        Route::prefix('medical-claims')->group(function () {
            Route::get('/', 'MedicalClaimController@index');
            Route::post('/', 'MedicalClaimController@store');
            Route::get('/{id}', 'MedicalClaimController@show');
            Route::post('/{id}', 'MedicalClaimController@update');
        });
    
        // medical claims comments routes
    
        Route::prefix('medical-claims-comments')->group(function () {
            Route::get('/{id}', 'MedicalClaimCommentController@index');
            Route::post('/{id}/store', 'MedicalClaimCommentController@store');
            Route::get('/{id}/data', 'MedicalClaimCommentController@show');
            Route::post('/{id}', 'MedicalClaimCommentController@update');
        });
        
        
        // Jop 
        
        Route::prefix('jop-claims')->group(function () {
            Route::get('/', 'JopClaimController@index');
            Route::post('/', 'JopClaimController@store');
            Route::get('/{id}', 'JopClaimController@show');
            Route::post('/{id}', 'JopClaimController@update');
        });
    
        // jop claims comments routes
    
        Route::prefix('jop-claims-comments')->group(function () {
            Route::get('/{id}', 'JopClaimCommentController@index');
            Route::post('/{id}/store', 'JopClaimCommentController@store');
            Route::get('/{id}/data', 'JopClaimCommentController@show');
            Route::post('/{id}', 'JopClaimCommentController@update');
        });
    
        // Car claims comments routes
    
        Route::prefix('motor-claims-comments')->group(function () {
            Route::get('/{id}', 'MotorClaimCommentController@index');
            Route::post('/{id}/store', 'MotorClaimCommentController@store');
            Route::get('/{id}/data', 'MotorClaimCommentController@show');
            Route::post('/{id}', 'MotorClaimCommentController@update');
        });
    
        // Car claims routes
    
        Route::prefix('car-claims')->group(function () {
            Route::get('/', 'MotorClaimController@index');
            Route::post('/', 'MotorClaimController@store');
            Route::get('/{id}', 'MotorClaimController@show');
            Route::post('/{id}', 'MotorClaimController@update');
        });
    
        // Building claims routes
    
        Route::prefix('building-claims')->group(function () {
            Route::get('/', 'BuildingClaimController@index');
            Route::post('/', 'BuildingClaimController@store');
            Route::get('/{id}', 'BuildingClaimController@show');
            Route::post('/{id}', 'BuildingClaimController@update');
        });
    
        // Building claims comments routes
    
        Route::prefix('building-claims-comments')->group(function () {
            Route::get('/{id}', 'BuildingClaimCommentController@index');
            Route::post('/{id}/store', 'BuildingClaimCommentController@store');
            Route::get('/{id}/data', 'BuildingClaimCommentController@show');
            Route::post('/{id}', 'BuildingClaimCommentController@update');
        });
        
    
        // Categories routes
    
        Route::prefix('categories')->group(function () {
            Route::get('/', 'CategoryController@index');
            Route::post('/', 'CategoryController@store');
            Route::get('/{id}', 'CategoryController@show');
            Route::post('/{id}', 'CategoryController@update');
            Route::post('/{id}/delete', 'CategoryController@destroy');
            Route::post('/{id}/recover', 'CategoryController@recover');
        });
    
        // Partners routes
    
        Route::prefix('partners')->group(function () {
            Route::get('/', 'PartnerController@index');
            Route::post('/', 'PartnerController@store');
            Route::get('/{id}', 'PartnerController@show');
            Route::post('/{id}', 'PartnerController@update');
            Route::post('/{id}/delete', 'PartnerController@destroy');
            Route::post('/{id}/recover', 'PartnerController@recover');
        });
    
        // Clients routes
    
        Route::prefix('clients')->group(function () {
            Route::get('/', 'ClientController@index');
            Route::post('/', 'ClientController@store');
            Route::get('/{id}', 'ClientController@show');
            Route::post('/{id}', 'ClientController@update');
            Route::post('/{id}/delete', 'ClientController@destroy');
            Route::post('/{id}/recover', 'ClientController@recover');
        });
    
    
        // Leads routes
    
        Route::prefix('medical-leads')->group(function () {
            Route::get('/', 'MedicalLeadController@index');
            Route::post('/', 'MedicalLeadController@store');
            Route::get('/{id}', 'MedicalLeadController@show');
            Route::post('/{id}', 'MedicalLeadController@update');
        });
        
        Route::prefix('jop-leads')->group(function () {
            Route::get('/', 'JopLeadController@index');
            Route::post('/', 'JopLeadController@store');
            Route::get('/{id}', 'JopLeadController@show');
            Route::post('/{id}', 'JopLeadController@update');
        });
    
        Route::prefix('motor-leads')->group(function () {
            Route::get('/', 'MotorLeadController@index');
            Route::post('/', 'MotorLeadController@store');
            Route::get('/{id}', 'MotorLeadController@show');
            Route::post('/{id}', 'MotorLeadController@update');
        });
    
        Route::prefix('building-leads')->group(function () {
            Route::get('/', 'BuildingLeadController@index');
            Route::post('/', 'BuildingLeadController@store');
            Route::get('/{id}', 'BuildingLeadController@show');
            Route::post('/{id}', 'BuildingLeadController@update');
        });

        Route::post('/sendPushNotification', 'WelcomeController@sendPushNotification')->name('sendPushNotification');
        Route::get('/sendPushNotification', 'WelcomeController@sendPushNotification')->name('sendPushNotification');
        
        
        Route::post('/sendSingleNotification', 'WelcomeController@sendSingleNotification')->name('sendSingleNotification');
        Route::get('/sendSingleNotification', 'WelcomeController@sendSingleNotification')->name('sendSingleNotification');
        
        Route::post('/sendSingleNotificationClaim', 'WelcomeController@sendSingleNotificationClaim')->name('sendSingleNotificationClaim');
        Route::get('/sendSingleNotificationClaim', 'WelcomeController@sendSingleNotificationClaim')->name('sendSingleNotificationClaim');
        
    // });

    
    
