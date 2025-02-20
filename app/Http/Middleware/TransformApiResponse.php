<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TransformApiResponse
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response->isSuccessful() && $response->headers->get('Content-Type') === 'application/json') {
            $data = json_decode($response->getContent(), true);
            if ($data) {
                $transformedData = $this->transformKeysToCamelCase($data);
                $response->setContent(json_encode($transformedData));
            }
        }

        return $response;
    }

    private function transformKeysToCamelCase(array $data): array
    {
        $result = [];

        foreach ($data as $key => $value) {
            $camelKey = \Illuminate\Support\Str::camel($key);
            $result[$camelKey] = is_array($value) ? $this->transformKeysToCamelCase($value) : $value;
        }

        return $result;
    }
}