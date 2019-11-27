<?php

namespace App\Exceptions;

use Exception;

class InvalidTokenException extends Exception
{
    /**
     * Generating the invalid token response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function render()
    {
        return response()->json([
            'authenticate' => false,
            'message' => 'Invalid Token',
        ]);
    }
}
