<?php

namespace App\Http\Controllers;

use App\NotificationSender;
use App\NotificationSenderClaim;
use App\User;
use Carbon\Carbon;
use Google\Client as GoogleClient;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
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

    // Get all unique device tokens
    $userTokens = User::whereNotNull('device_token')->pluck('device_token')->toArray();
    $uniqueTokens = array_unique($userTokens);
    $tokensArray = array_chunk($uniqueTokens, 1000); // Batch of 1000

    // Path to Firebase service account JSON
    $credentialsFilePath = storage_path('app/json/capital-insurance-8134f-a0ba5c65d52f.json');

    // Check if file exists
    if (!file_exists($credentialsFilePath)) {
        return response()->json([
            'error' => "JSON file not found at path: $credentialsFilePath"
        ], 500);
    }

    // Check if file is readable
    if (!is_readable($credentialsFilePath)) {
        return response()->json([
            'error' => "JSON file exists but is not readable. Check file permissions."
        ], 500);
    }

    // Initialize Google Client and get access token
    $client = new GoogleClient();
    $client->setAuthConfig($credentialsFilePath);
    $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

    try {
        $tokenData = $client->fetchAccessTokenWithAssertion();

        if (isset($tokenData['error'])) {
            return response()->json([
                'error' => "Firebase Access Token Error: " . $tokenData['error_description'] ?? $tokenData['error']
            ], 500);
        }

        $accessToken = $tokenData['access_token'] ?? null;

        if (!$accessToken) {
            return response()->json([
                'error' => "Access token not returned. Check your service account JSON."
            ], 500);
        }

    } catch (\Exception $e) {
        return response()->json([
            'error' => "Exception while fetching access token: " . $e->getMessage()
        ], 500);
    }

    $headers = [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json',
    ];

    // Send notifications in batches
    foreach ($tokensArray as $chunk) {
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

            $dataString = json_encode($postdata);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/capital-insurance-8134f/messages:send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);

            $result = curl_exec($ch);

            if ($result === false) {
                \Log::error("FCM cURL Error: " . curl_error($ch));
                curl_close($ch);
                continue;
            }

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200) {
                \Log::error("FCM API Error: HTTP $httpCode - $result");
            }
        }
    }

    // Save notification record
    $dateNow = Carbon::now('Africa/Cairo')->format('Y-m-d');
    $timeNow = Carbon::now('Africa/Cairo')->format('h:i:s');

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
            'notification_title' => $title,
            'notification_text' => $message,
            'ar_notification_title' => $artitle,
            'ar_notification_text' => $armessage,
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
        $requestid = $request->request_id;
        $requesttype = $request->request_type;

        $user = User::find($userid);
        if (!$user || !$user->device_token) {
            return response()->json(['error' => 'User not found or missing token'], 404);
        }

        $this->sendFCM($user->device_token, $title, $message);

        NotificationSender::create([
            'user_id' => $userid,
            'notification_title' => $title,
            'notification_text' => $message,
            'ar_notification_title' => $artitle,
            'ar_notification_text' => $armessage,
            'notification_date' => Carbon::now('Africa/Cairo')->format('Y-m-d'),
            'notification_time' => Carbon::now('Africa/Cairo')->format('H:i:s'),
            'request_id' => $requestid,
            'request_type' => $requesttype,
        ]);

        return response()->json(['success' => 'Notification sent'], 200);
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
            return response()->json(['error' => 'User not found or missing token'], 404);
        }

        $this->sendFCM($user->device_token, $title, $message);

        NotificationSenderClaim::create([
            'user_id' => $userid,
            'notification_title' => $title,
            'notification_text' => $message,
            'ar_notification_title' => $artitle,
            'ar_notification_text' => $armessage,
            'notification_date' => Carbon::now('Africa/Cairo')->format('Y-m-d'),
            'notification_time' => Carbon::now('Africa/Cairo')->format('H:i:s'),
            'claim_id' => $claimid,
            'claim_type' => $claimtype,
        ]);

        return response()->json(['success' => 'Claim notification sent'], 200);
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
    }
}
