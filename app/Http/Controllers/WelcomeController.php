<?php

namespace App\Http\Controllers;

use App\Services\NotificationDispatchService;
use App\Services\PushNotificationService;
use App\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
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
            'notification_title' => $title,
            'notification_text' => $message,
            'ar_notification_title' => $artitle,
            'ar_notification_text' => $armessage,
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
    }
}
