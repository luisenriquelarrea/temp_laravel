<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TransformForeignKeys
{
    public function handle(Request $request, Closure $next)
    {
        // Loop through all input data
        $transformedData = [];

        foreach ($request->all() as $key => $value) {
            // Check if the value is an object with an 'id' key
            if (is_array($value) /*&& isset($value[$key]['id'])*/) {
                $keyAlt = $this->camelCaseToSnakeCase($key.'_id');
                // Replace the nested structure with just the ID
                $transformedData[$keyAlt] = $value['id'];
            } else {
                // Keep other values as they are
                $transformedData[$key] = $value;
            }
        }

        // Replace the request data with transformed data
        $request->replace($transformedData);

        return $next($request);
    }

    private function camelCaseToSnakeCase($string) {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }
}