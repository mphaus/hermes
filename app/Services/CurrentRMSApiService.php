<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class CurrentRMSApiService
{
    protected string $auth_token;

    protected string $subdomain;

    protected string $host;

    private array $result = [
        'error' => [],
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

        $this->handleResponse($response);

        return $this;
    }

    public function store(string $uri, array $params = [], array $data = [])
    {
        $uri = $this->buildUri($uri, $params);

        /** @var \Illuminate\Http\Client\Response $response */
        $response = $this->client()->post($uri, $data);

        $this->handleResponse($response);

        return $this;
    }

    public function update(string $uri, array $params = [], array $data = []): self
    {
        $uri = $this->buildUri($uri, $params);

        /** @var \Illuminate\Http\Client\Response $response */
        $response = $this->client()->put($uri, $data);

        $this->handleResponse($response);

        return $this;
    }

    /**
     * @param \Illuminate\Http\Client\Response $response
     */
    private function handleResponse($response): void
    {
        if ($response->failed()) {
            $errors = isset($response->json()['errors']) ? $response->json()['errors'] : $response->json();
            $this->result = [
                ...$this->result,
                'error' => [
                    'status' => $response->status(),
                    'data' => json_encode($errors),
                ],
            ];
        } else {
            $this->result = [
                ...$this->result,
                'data' => $response->json(),
            ];
        }
    }

    private function buildUri(string $uri, array $params = []): string
    {
        if (!empty($params)) {
            $query_string = preg_replace('/\[\d+\]/', '[]', urldecode(http_build_query($params)));
            $uri = "{$uri}?{$query_string}";
        }

        return $uri;
    }

    public function hasErrors(): bool
    {
        return !empty($this->result['error']);
    }

    public function getErrorString(): string
    {
        return $this->result['error']['data'] ?? '';
    }

    public function getErrorStatus(): int
    {
        return $this->result['error']['status'] ?? 0;
    }

    public function getData(): mixed
    {
        return $this->result['data'] ?? null;
    }
}
