<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class MightyCallService
{
    protected string $baseUrl;
    protected string $apiKey;
    protected string $secretKey;

    public function __construct()
    {
        $this->baseUrl = rtrim((string) config('services.mighty_call.base_url'), '/');
        $this->apiKey = (string) config('services.mighty_call.api_key');
        $this->secretKey = (string) config('services.mighty_call.secret');

        if ($this->baseUrl === '' || $this->apiKey === '' || $this->secretKey === '') {
            throw new RuntimeException('MightyCall credentials are not configured.');
        }
    }

    /**
     * Get a single call by its MightyCall id.
     */
    public function getCall(string $id): array
    {
        return $this->request('GET', "/api/calls/{$id}");
    }

    /**
     * List calls within a time range.
     *
     * @param array{startUtc?:string,endUtc?:string,pageSize?:int,skip?:int,callFilter?:string,customFilter?:string,extension?:string} $params
     */
    public function listCalls(array $params = []): array
    {
        return $this->request('GET', '/api/calls', ['query' => $params]);
    }

    protected function request(string $method, string $path, array $options = []): array
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)
            ->timeout(15)
            ->send($method, "{$this->baseUrl}{$path}", $options);

        if ($response->status() === 401) {
            $token = $this->getAccessToken(forceRefresh: true);
            $response = Http::withToken($token)
                ->timeout(15)
                ->send($method, "{$this->baseUrl}{$path}", $options);
        }

        if ($response->failed()) {
            throw new RuntimeException(
                "MightyCall API {$method} {$path} failed with status {$response->status()}: {$response->body()}"
            );
        }

        return $response->json();
    }

    protected function getAccessToken(bool $forceRefresh = false): string
    {
        $cached = Cache::get('mightycall.token');

        if (! $forceRefresh && $cached && now()->lt($cached['expires_at'])) {
            return $cached['access_token'];
        }

        return Cache::lock('mightycall.token.refresh', 10)->block(5, function () use ($forceRefresh) {
            $cached = Cache::get('mightycall.token');

            if (! $forceRefresh && $cached && now()->lt($cached['expires_at'])) {
                return $cached['access_token'];
            }

            $data = ($cached['refresh_token'] ?? null) && ! $forceRefresh
                ? $this->refreshToken($cached['refresh_token'])
                : $this->authenticate();

            $expiresAt = now()->addSeconds(($data['expires_in'] ?? 3600) - 60);
            $cacheTtl = $expiresAt->copy()->addDay();

            Cache::put('mightycall.token', [
                'access_token' => $data['access_token'],
                'refresh_token' => $data['refresh_token'] ?? null,
                'expires_at' => $expiresAt->toIso8601String(),
            ], $cacheTtl);

            return $data['access_token'];
        });
    }

    protected function authenticate(): array
    {
        $response = Http::asForm()
            ->withHeaders(['x-api-key' => $this->apiKey])
            ->timeout(15)
            ->post("{$this->baseUrl}/auth/token", [
                'grant_type' => 'client_credentials',
                'client_id' => $this->apiKey,
                'client_secret' => $this->secretKey,
            ]);

        if ($response->failed()) {
            throw new RuntimeException(
                "MightyCall authentication failed with status {$response->status()}: {$response->body()}"
            );
        }

        return $response->json();
    }

    protected function refreshToken(string $refreshToken): array
    {
        $response = Http::asForm()
            ->withHeaders(['x-api-key' => $this->apiKey])
            ->timeout(15)
            ->post("{$this->baseUrl}/auth/token", [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken,
            ]);

        return $response->failed() ? $this->authenticate() : $response->json();
    }
}
