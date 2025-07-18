<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use JsonException;

class MemberController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $params = $request->collect();
        $url = 'members';

        if ($params->isNotEmpty()) {
            $params = preg_replace('/\[\d+\]/', '[]', urldecode(http_build_query($params->toArray())));
            $url = "{$url}?{$params}";
        }

        $response = Http::current()->get($url);

        if ($response->failed()) {
            ['errors' => $errors] = $response->json();

            throw new JsonException(
                $errors[0],
                $response->status(),
            );
        }

        ['members' => $members] = $response->json();

        if (empty($members)) {
            return response()->json([]);
        }

        return response()->json($members);
    }
}
