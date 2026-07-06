<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Services\NotificationDispatchService;
use App\Services\PushNotificationService;
use App\User;
=======
use App\NotificationSender;
use App\NotificationSenderClaim;
use App\User;
use Carbon\Carbon;
use Google\Client as GoogleClient;
>>>>>>> b3b5690cdf7b7d2d6cdc35201acca0827eaaf74d
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
<<<<<<< HEAD
    public function __construct(
        private PushNotificationService $pushNotificationService,
        private NotificationDispatchService $notificationDispatchService
    ) {
    }

    public function sendPushNotification(Request $request)
    {
        $message = $request->textmessage ?? 'message';
        $title = $request->titlemessage ?? 'title';
        $armessage = $request->artextmessage ?? 'message';
        $artitle = $request->artitlemessage ?? 'title';

        $tokens = User::whereNotNull('device_token')->pluck('device_token')->toArray();
        $result = $this->pushNotificationService->sendToMany($tokens, $title, $message);

        $this->pushNotificationService->saveNotification([
=======
    private function getAccessToken()
    {
        $credentialsFilePath = storage_path('app/json/capital-insurance-8134f-a0ba5c65d52f.json');
        if (!file_exists($credentialsFilePath)) {
            throw new \Exception("Firebase credentials file not found: " . $credentialsFilePath);
        }

        $client = new GoogleClient();
        $client->setAuthConfig($credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->useApplicationDefaultCredentials();
        $client->refreshTokenWithAssertion();

        $token = $client->getAccessToken();
        return $token['access_token'];
    }

public function sendPushNotification(Request $request)
{
    $message = $request->textmessage;
    $title = $request->titlemessage;
    $armessage = $request->artextmessage;
    $artitle = $request->artitlemessage;

    // مسار مؤقت للملف JSON
    $credentialsPath = storage_path('app/json/capital-insurance.json');

    // فك Base64 واكتب الملف لو مش موجود
    if (!file_exists($credentialsPath)) {
        $jsonContent = base64_decode(env('FIREBASE_CREDENTIALS_BASE64'));
        file_put_contents($credentialsPath, $jsonContent);
        chmod($credentialsPath, 0600);
    }

    // إعداد Google Client
    $client = new GoogleClient();
    $client->setAuthConfig($credentialsPath);
    $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

    // جلب كل Device Tokens
    $userTokens = User::whereNotNull('device_token')->pluck('device_token')->toArray();
    $uniqueTokens = array_unique($userTokens);
    $tokensChunks = array_chunk($uniqueTokens, 1000);

    foreach ($tokensChunks as $chunk) {

        // تحديث Access Token قبل كل chunk
        try {
            $accessToken = $client->fetchAccessTokenWithAssertion()['access_token'];
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Cannot fetch Firebase access token',
                'message' => $e->getMessage()
            ], 500);
        }

        $header = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ];

        foreach ($chunk as $deviceToken) {
            $postdata = [
                "message" => [
                    "token" => $deviceToken,
                    "notification" => [
                        "title" => $title,
                        "body" => $message,
                    ],
                    "apns" => [
                        "payload" => [
                            "aps" => [
                                "alert" => [
                                    "title" => $title,
                                    "body" => $message
                                ],
                                "sound" => "default"
                            ]
                        ]
                    ]
                ]
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/capital-insurance-8134f/messages:send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // سجل الرد لمراجعة أي مشاكل
            \Log::info("FCM Response: HTTP $httpCode, Body: $result");
        }
    }

    // حفظ الإشعار في قاعدة البيانات
    $dateNow = Carbon::now('Africa/Cairo')->format('Y-m-d');
    $timeNow = Carbon::now('Africa/Cairo')->format('H:i:s');

    NotificationSender::create([
        'notification_title' => $title,
        'notification_text' => $message,
        'ar_notification_title' => $artitle,
        'ar_notification_text' => $armessage,
        'notification_date' => $dateNow,
        'notification_time' => $timeNow,
    ]);

    return response()->json(['success' => 'Notifications sent successfully'], 200);
}


    private function sendFCM($deviceToken, $title, $message)
    {
        $accessToken = $this->getAccessToken();

        $header = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ];

        $postdata = [
            "message" => [
                "token" => $deviceToken,
                "notification" => [
                    "title" => $title,
                    "body" => $message,
                ],
                "apns" => [
                    "payload" => [
                        "aps" => [
                            "alert" => [
                                "title" => $title,
                                "body" => $message
                            ],
                            "sound" => "default"
                        ]
                    ]
                ]
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/capital-insurance-8134f/messages:send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function sendPushNotificationold(Request $request)
    {
        $message = $request->textmessage ?? "message";
        $title = $request->titlemessage ?? "title";
        $armessage = $request->artextmessage ?? "message";
        $artitle = $request->artitlemessage ?? "title";

        $userTokens = User::whereNotNull('device_token')->pluck('device_token')->unique()->values();

        foreach ($userTokens as $deviceToken) {
            $this->sendFCM($deviceToken, $title, $message);
        }

        NotificationSender::create([
>>>>>>> b3b5690cdf7b7d2d6cdc35201acca0827eaaf74d
            'notification_title' => $title,
            'notification_text' => $message,
            'ar_notification_title' => $artitle,
            'ar_notification_text' => $armessage,
<<<<<<< HEAD
        ]);

        return response()->json([
            'success' => 'Notifications processed successfully',
            'push_sent' => $result['sent'],
            'push_failed' => $result['failed'],
        ], 200);
    }

    public function sendSingleNotification(Request $request)
    {
        $this->notificationDispatchService->dispatchSingle($request->all());

        return response()->json(['success' => 'Notification processed'], 200)
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function sendSingleNotificationClaim(Request $request)
    {
        $this->notificationDispatchService->dispatchSingleClaim($request->all());

        return response()->json(['success' => 'Claim notification processed'], 200)
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function sendOrderNotification(Request $request)
    {
        $this->notificationDispatchService->dispatchBroadcast($request->all());

        return response()->json(['success' => 'Order notifications processed successfully'], 200);
=======
            'notification_date' => Carbon::now('Africa/Cairo')->format('Y-m-d'),
            'notification_time' => Carbon::now('Africa/Cairo')->format('H:i:s'),
        ]);

        return response()->json(['success' => 'Notifications sent successfully'], 200);
    }

   public function sendSingleNotification(Request $request)
{
    $message = $request->textmessage ?? "message";
    $title = $request->titlemessage ?? "title";
    $armessage = $request->artextmessage ?? "message";
    $artitle = $request->artitlemessage ?? "title";
    $userid = $request->user_id;
    $claimid = $request->request_id;
    $claimtype = $request->request_type;

    $user = User::find($userid);
    if (!$user || !$user->device_token) {
        return response()->json(['error' => 'User not found or missing token'], 404)
                         ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                         ->header('Pragma', 'no-cache')
                         ->header('Expires', '0');
    }

    // مسار مؤقت للملف JSON
    $credentialsPath = storage_path('app/json/capital-insurance.json');

    if (!file_exists($credentialsPath)) {
        $jsonContent = base64_decode(env('FIREBASE_CREDENTIALS_BASE64'));
        file_put_contents($credentialsPath, $jsonContent);
        chmod($credentialsPath, 0600);
    }

    // إعداد Google Client
    $client = new GoogleClient();
    $client->setAuthConfig($credentialsPath);
    $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

    try {
        $accessToken = $client->fetchAccessTokenWithAssertion()['access_token'];
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Cannot fetch Firebase access token',
            'message' => $e->getMessage()
        ], 500);
    }

    $header = [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json',
    ];

    // إرسال Notification
    $postdata = [
        "message" => [
            "token" => $user->device_token,
            "notification" => [
                "title" => $title,
                "body" => $message,
            ],
            "apns" => [
                "payload" => [
                    "aps" => [
                        "alert" => [
                            "title" => $title,
                            "body" => $message
                        ],
                        "sound" => "default"
                    ]
                ]
            ]
        ]
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/capital-insurance-8134f/messages:send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    \Log::info("FCM Response: HTTP $httpCode, Body: $result");

    // حفظ الإشعار في قاعدة البيانات
    NotificationSender::create([
        'user_id' => $userid,
        'notification_title' => $title,
        'notification_text' => $message,
        'ar_notification_title' => $artitle,
        'ar_notification_text' => $armessage,
        'notification_date' => Carbon::now('Africa/Cairo')->format('Y-m-d'),
        'notification_time' => Carbon::now('Africa/Cairo')->format('H:i:s'),
        'request_id' => $claimid,
        'request_type' => $claimtype,
    ]);

    return response()->json(['success' => 'Notification sent'], 200)
                     ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                     ->header('Pragma', 'no-cache')
                     ->header('Expires', '0');
}

public function sendSingleNotificationClaim(Request $request)
{
    $message = $request->textmessage ?? "message";
    $title = $request->titlemessage ?? "title";
    $armessage = $request->artextmessage ?? "message";
    $artitle = $request->artitlemessage ?? "title";
    $userid = $request->user_id;
    $claimid = $request->claim_id;
    $claimtype = $request->claim_type;

    $user = User::find($userid);
    if (!$user || !$user->device_token) {
        return response()->json(['error' => 'User not found or missing token'], 404)
                         ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                         ->header('Pragma', 'no-cache')
                         ->header('Expires', '0');
    }

    // مسار مؤقت للملف JSON
    $credentialsPath = storage_path('app/json/capital-insurance.json');

    if (!file_exists($credentialsPath)) {
        $jsonContent = base64_decode(env('FIREBASE_CREDENTIALS_BASE64'));
        file_put_contents($credentialsPath, $jsonContent);
        chmod($credentialsPath, 0600);
    }

    // إعداد Google Client
    $client = new GoogleClient();
    $client->setAuthConfig($credentialsPath);
    $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

    try {
        $accessToken = $client->fetchAccessTokenWithAssertion()['access_token'];
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Cannot fetch Firebase access token',
            'message' => $e->getMessage()
        ], 500);
    }

    $header = [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type' => 'application/json',
    ];

    // إرسال Notification
    $postdata = [
        "message" => [
            "token" => $user->device_token,
            "notification" => [
                "title" => $title,
                "body" => $message,
            ],
            "apns" => [
                "payload" => [
                    "aps" => [
                        "alert" => [
                            "title" => $title,
                            "body" => $message
                        ],
                        "sound" => "default"
                    ]
                ]
            ]
        ]
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/capital-insurance-8134f/messages:send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    \Log::info("FCM Response: HTTP $httpCode, Body: $result");

    // حفظ الإشعار في قاعدة البيانات
    NotificationSenderClaim::create([
        'user_id' => $userid,
        'notification_title' => $title,
        'notification_text' => $message,
        'ar_notification_title' => $artitle,
        'ar_notification_text' => $armessage,
        'notification_date' => Carbon::now('Africa/Cairo')->format('Y-m-d'),
        'notification_time' => Carbon::now('Africa/Cairo')->format('H:i:s'),
        'request_id' => $claimid,
        'request_type' => $claimtype,
    ]);

    return response()->json(['success' => 'Claim notification sent'], 200)
                     ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                     ->header('Pragma', 'no-cache')
                     ->header('Expires', '0');
}

    public function sendOrderNotification(Request $request)
    {
        $message = $request->textmessage ?? "message";
        $title = $request->titlemessage ?? "title";
        $armessage = $request->artextmessage ?? "message";
        $artitle = $request->artitlemessage ?? "title";

        $userTokens = User::whereNotNull('device_token')->pluck('device_token')->unique()->values();

        foreach ($userTokens as $deviceToken) {
            $this->sendFCM($deviceToken, $title, $message);
        }

        NotificationSender::create([
            'notification_title' => $title,
            'notification_text' => $message,
            'ar_notification_title' => $artitle,
            'ar_notification_text' => $armessage,
            'notification_date' => Carbon::now('Africa/Cairo')->format('Y-m-d'),
            'notification_time' => Carbon::now('Africa/Cairo')->format('H:i:s'),
        ]);

        return response()->json(['success' => 'Order notifications sent successfully'], 200);
>>>>>>> b3b5690cdf7b7d2d6cdc35201acca0827eaaf74d
    }
}
