<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Log;

class NotificationDispatchService
{
    public function __construct(
        private PushNotificationService $pushNotificationService
    ) {
    }

    public function dispatchBroadcast(array $payload): void
    {
        try {
            $title = $payload['titlemessage'] ?? 'title';
            $message = $payload['textmessage'] ?? 'message';
            $artitle = $payload['artitlemessage'] ?? 'title';
            $armessage = $payload['artextmessage'] ?? 'message';

            $tokens = User::whereNotNull('device_token')->pluck('device_token')->toArray();
            $this->pushNotificationService->sendToMany($tokens, $title, $message);

            $this->pushNotificationService->saveNotification([
                'notification_title' => $title,
                'notification_text' => $message,
                'ar_notification_title' => $artitle,
                'ar_notification_text' => $armessage,
            ]);
        } catch (\Throwable $e) {
            Log::warning('Broadcast notification dispatch failed', ['error' => $e->getMessage()]);
        }
    }

    public function dispatchSingle(array $payload): void
    {
        try {
            $title = $payload['titlemessage'] ?? 'message';
            $message = $payload['textmessage'] ?? 'message';
            $artitle = $payload['artitlemessage'] ?? 'message';
            $armessage = $payload['artextmessage'] ?? 'message';
            $userId = $payload['user_id'] ?? null;
            $requestId = $payload['request_id'] ?? null;
            $requestType = $payload['request_type'] ?? null;

            $user = $userId ? User::find($userId) : null;
            if ($user?->device_token) {
                $this->pushNotificationService->sendToToken($user->device_token, $title, $message);
            } else {
                Log::info('Single notification saved without push: user has no device token', [
                    'user_id' => $userId,
                ]);
            }

            $this->pushNotificationService->saveNotification([
                'user_id' => $userId,
                'notification_title' => $title,
                'notification_text' => $message,
                'ar_notification_title' => $artitle,
                'ar_notification_text' => $armessage,
                'request_id' => $requestId,
                'request_type' => $requestType,
            ]);
        } catch (\Throwable $e) {
            Log::warning('Single notification dispatch failed', ['error' => $e->getMessage()]);
        }
    }

    public function dispatchSingleClaim(array $payload): void
    {
        try {
            $title = $payload['titlemessage'] ?? 'message';
            $message = $payload['textmessage'] ?? 'message';
            $artitle = $payload['artitlemessage'] ?? 'message';
            $armessage = $payload['artextmessage'] ?? 'message';
            $userId = $payload['user_id'] ?? null;
            $claimId = $payload['claim_id'] ?? $payload['request_id'] ?? null;
            $claimType = $payload['claim_type'] ?? $payload['request_type'] ?? null;

            $user = $userId ? User::find($userId) : null;
            if ($user?->device_token) {
                $this->pushNotificationService->sendToToken($user->device_token, $title, $message);
            } else {
                Log::info('Claim notification saved without push: user has no device token', [
                    'user_id' => $userId,
                ]);
            }

            $this->pushNotificationService->saveNotification([
                'user_id' => $userId,
                'notification_title' => $title,
                'notification_text' => $message,
                'ar_notification_title' => $artitle,
                'ar_notification_text' => $armessage,
                'request_id' => $claimId,
                'request_type' => $claimType,
            ], true);
        } catch (\Throwable $e) {
            Log::warning('Claim notification dispatch failed', ['error' => $e->getMessage()]);
        }
    }
}
