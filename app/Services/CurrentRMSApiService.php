<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class CurrentRMSApiService
{
    protected string $auth_token;

    protected string $subdomain;

    protected string $host;

    private const RESULT = [
        'fail' => [],
        'data' => null,
    ];

    public function __construct()
    {
        $this->auth_token = config('app.current_rms.auth_token');
        $this->subdomain = config('app.current_rms.subdomain');
        $this->host = config('app.current_rms.host');
    }

    private function client(): PendingRequest
    {
        return Http::withHeaders([
            'X-AUTH-TOKEN' => $this->auth_token,
            'X-SUBDOMAIN' => $this->subdomain,
        ])->baseUrl($this->host);
    }

    public function fetch(string $uri, array $params = [])
    {
        $uri = $this->buildUri($uri, $params);

        /** @var \Illuminate\Http\Client\Response $response */
        $response = $this->client()->get($uri);

        return $this->handleResponse($response);
    }

    public function store(string $uri, array $params = [], array $data = [])
    {
        $uri = $this->buildUri($uri, $params);

        /** @var \Illuminate\Http\Client\Response $response */
        $response = $this->client()->post($uri, $data);

        return $this->handleResponse($response);
    }

    /**
     * @param \Illuminate\Http\Client\Response $response
     */
    private function handleResponse($response): array
    {
        if ($response->failed()) {
            $errors = isset($response->json()['errors']) ? $response->json()['errors'] : $response->json();

            return [
                ...self::RESULT,
                'fail' => [
                    'status' => $response->status(),
                    'data' => json_encode($errors),
                ],
            ];
        }

        return [
            ...self::RESULT,
            'data' => $response->json(),
        ];
    }

    private function buildUri(string $uri, array $params = []): string
    {
        if (!empty($params)) {
            $query_string = preg_replace('/\[\d+\]/', '[]', urldecode(http_build_query($params)));
            $uri = "{$uri}?{$query_string}";
        }

        return $uri;
    }
}
