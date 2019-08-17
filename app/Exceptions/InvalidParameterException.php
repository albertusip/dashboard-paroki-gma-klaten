<?php

namespace App\Exceptions;

use Exception;

class InvalidParameterException extends Exception
{
    /**
     * Handle invalid parameter error message.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function render()
    {
        return response()->json([
            'message' => 'Invalid Parameter(s)'
        ], 400);
    }
}
