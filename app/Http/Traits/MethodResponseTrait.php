<?php

namespace App\Http\Traits;

trait MethodResponseTrait{
    /**
     * Set an error response.
     *
     * @param  string $mensaje
     * @param  string $classname
     * @param  string $method
     * @param  int    $line
     * @param  array  $data
     * @return array  $response
     */
    public function set_error(string $mensaje, string $classname, string $method, 
        int $line, array $data = []):array{
        $response = [
            'success' => false,
            'error' => true,
            'mensaje' => $mensaje,
            'classname' => $classname,
            'method' => $method,
            'line' => $line,
            'data' => $data
        ];
        return $response;
    }

    /**
     * Set a success response.
     *
     * @param  string $mensaje
     * @return array  $response
     */
    public function set_success(string $mensaje = "Exito"):array{
        $response = [
            'success' => true,
            'mensaje' => $mensaje
        ];
        return $response;
    }
}