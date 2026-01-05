<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class CurrentRMSApiService
{
    protected string $auth_token;

    protected string $subdomain;

    protected string $host;

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
        if (!empty($params)) {
            $query_string = preg_replace('/\[\d+\]/', '[]', urldecode(http_build_query($params)));
            $uri = "{$uri}?{$query_string}";
        }

        /**
         * @var \Illuminate\Http\Client\Response $response
         */
        $response = $this->client()->get($uri);

        return $response->json();
    }
}
