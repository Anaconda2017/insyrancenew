<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SafeMail
{
    public static function send(string $view, array $data, \Closure $callback): bool
    {
        try {
            Mail::send($view, $data, $callback);

            return true;
        } catch (\Throwable $e) {
            Log::error('Email send failed', [
                'view' => $view,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
