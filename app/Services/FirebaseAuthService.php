<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class FirebaseAuthService
{
    private const CREDENTIALS_DIR = 'app/json';

    private const CREDENTIALS_FILES = [
        'capital-insurance-8134f-a0ba5c65d52f.json',
        'capital-insurance.json',
    ];

    public function getAccessToken(): ?string
    {
        try {
            $credentials = $this->loadCredentials();
            if (!$credentials) {
                return null;
            }

            $jwt = $this->createJwt($credentials);
            if (!$jwt) {
                return null;
            }

            return $this->exchangeJwtForToken($jwt);
        } catch (\Throwable $e) {
            Log::error('Firebase access token error', ['error' => $e->getMessage()]);

            return null;
        }
    }

    public function getProjectId(): ?string
    {
        $credentials = $this->loadCredentials();

        return is_array($credentials) ? ($credentials['project_id'] ?? null) : null;
    }

    private function loadCredentials(): ?array
    {
        $credentialsPath = $this->resolveCredentialsPath();
        if (!$credentialsPath) {
            Log::warning('Firebase credentials not found in storage/app/json');

            return null;
        }

        $credentials = json_decode(file_get_contents($credentialsPath), true);
        if (!is_array($credentials) || empty($credentials['client_email']) || empty($credentials['private_key'])) {
            Log::warning('Firebase credentials file is invalid', ['path' => $credentialsPath]);

            return null;
        }

        return $credentials;
    }

    private function resolveCredentialsPath(): ?string
    {
        foreach (self::CREDENTIALS_FILES as $fileName) {
            $path = storage_path(self::CREDENTIALS_DIR . '/' . $fileName);
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    private function createJwt(array $credentials): ?string
    {
        $now = time();
        $header = $this->base64UrlEncode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
        $payload = $this->base64UrlEncode(json_encode([
            'iss' => $credentials['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $now + 3600,
        ]));

        $privateKey = openssl_pkey_get_private($credentials['private_key']);
        if ($privateKey === false) {
            Log::error('Invalid Firebase private key');

            return null;
        }

        $signature = '';
        $algorithm = defined('OPENSSL_ALGORITHM_SHA256')
            ? OPENSSL_ALGORITHM_SHA256
            : OPENSSL_ALGO_SHA256;
        $signed = openssl_sign("{$header}.{$payload}", $signature, $privateKey, $algorithm);
        if (!$signed) {
            Log::error('Failed to sign Firebase JWT');

            return null;
        }

        return "{$header}.{$payload}." . $this->base64UrlEncode($signature);
    }

    private function exchangeJwtForToken(string $jwt): ?string
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://oauth2.googleapis.com/token',
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_POSTFIELDS => http_build_query([
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt,
            ]),
        ]);

        $result = curl_exec($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            Log::warning('Firebase token exchange curl error', ['error' => $curlError]);

            return null;
        }

        $data = json_decode($result, true);
        if ($httpCode < 200 || $httpCode >= 300 || empty($data['access_token'])) {
            Log::warning('Firebase token exchange failed', [
                'http_code' => $httpCode,
                'body' => $result,
            ]);

            return null;
        }

        return $data['access_token'];
    }

    private function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
