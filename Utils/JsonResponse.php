<?php

namespace Utils;

class JsonResponse
{
    public static function send($statusCode = 200, $message, $data)
    {
        http_response_code($statusCode);
        
        $response = array(
            'code' => $statusCode,
            'message' => $message,
            'data' => $data,
        );

        echo json_encode($response);
    }
}