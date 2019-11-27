<?php

namespace App\Exceptions;

use Exception;

class InvalidRoleException extends Exception
{
    /**
     * Generating the invalid user role response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function render()
    {
        return response()->json([
            'authenticate' => false,
            'message' => 'Invalid User'
        ]);
    }
}
