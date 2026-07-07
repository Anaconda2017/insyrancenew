<?php

namespace App\Services;

use App\NotificationSender;
use App\NotificationSenderClaim;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PushNotificationService
{
    private const CURL_TIMEOUT = 15;
    private const MAX_BULK_TOKENS = 500;

    public function __construct(
        private FirebaseAuthService $firebaseAuthService
    ) {
    }

    public function sendToToken(string $deviceToken, string $title, string $message): bool
    {
        try {
            $accessToken = $this->getAccessToken();
            if (!$accessToken) {
                Log::warning('Push notification skipped: Firebase access token unavailable');

                return false;
            }

            return $this->dispatchFcm($deviceToken, $title, $message, $accessToken);
        } catch (\Throwable $e) {
            Log::error('Push notification failed', ['error' => $e->getMessage()]);

            return false;
        }
    }

    public function sendToMany(array $tokens, string $title, string $message): array
    {
        $tokens = array_values(array_unique(array_filter($tokens)));
        $tokens = array_slice($tokens, 0, self::MAX_BULK_TOKENS);

        $sent = 0;
        $failed = 0;

        try {
            $accessToken = $this->getAccessToken();
            if (!$accessToken) {
                Log::warning('Bulk push skipped: Firebase access token unavailable');

                return ['sent' => 0, 'failed' => count($tokens)];
            }

            foreach ($tokens as $token) {
                if ($this->dispatchFcm($token, $title, $message, $accessToken)) {
                    $sent++;
                } else {
                    $failed++;
                }
            }
        } catch (\Throwable $e) {
            Log::error('Bulk push notification failed', ['error' => $e->getMessage()]);
            $failed = count($tokens) - $sent;
        }

        return ['sent' => $sent, 'failed' => $failed];
    }

    public function saveNotification(array $data, bool $isClaim = false): void
    {
        try {
            $now = Carbon::now('Africa/Cairo');
            $payload = array_merge([
                'notification_date' => $now->format('Y-m-d'),
                'notification_time' => $now->format('H:i:s'),
            ], $data);

            if ($isClaim) {
                NotificationSenderClaim::create($payload);
            } else {
                NotificationSender::create($payload);
            }
        } catch (\Throwable $e) {
            Log::error('Failed to save notification record', ['error' => $e->getMessage()]);
        }
    }

    private function getAccessToken(): ?string
    {
        return $this->firebaseAuthService->getAccessToken();
    }

    private function dispatchFcm(string $deviceToken, string $title, string $message, string $accessToken): bool
    {
        $projectId = $this->firebaseAuthService->getProjectId();
        if (!$projectId) {
            Log::warning('FCM skipped: Firebase project_id missing from credentials');

            return false;
        }

        $fcmUrl = 'https://fcm.googleapis.com/v1/projects/' . $projectId . '/messages:send';

        $postdata = [
            'message' => [
                'token' => trim($deviceToken),
                'notification' => [
                    'title' => $title,
                    'body' => $message,
                ],
                'android' => [
                    'priority' => 'high',
                    'notification' => [
                        'sound' => 'default',
                    ],
                ],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'alert' => [
                                'title' => $title,
                                'body' => $message,
                            ],
                            'sound' => 'default',
                        ],
                    ],
                ],
            ],
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $fcmUrl,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json',
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_POSTFIELDS => json_encode($postdata),
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => self::CURL_TIMEOUT,
        ]);

        $result = curl_exec($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            Log::warning('FCM curl error', [
                'error' => $curlError,
                'token' => substr($deviceToken, 0, 20),
            ]);

            return false;
        }

        $success = $httpCode >= 200 && $httpCode < 300;
        if (!$success) {
            Log::warning('FCM send failed', [
                'http_code' => $httpCode,
                'body' => $result,
                'project_id' => $projectId,
                'token_prefix' => substr($deviceToken, 0, 20),
            ]);
        } else {
            Log::info('FCM send success', [
                'http_code' => $httpCode,
                'project_id' => $projectId,
                'token_prefix' => substr($deviceToken, 0, 20),
            ]);
        }

        return $success;
    }
}
