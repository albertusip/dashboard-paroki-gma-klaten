<?php

namespace App\Exceptions;

use Exception;

class InvalidCredentialsException extends Exception
{
    /**
     * Generating the invalid username / password response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function render()
    {
        return response()->json([
            'authenticate' => false,
            'message' => 'Invalid Username / Password',
        ]);
    }
}
