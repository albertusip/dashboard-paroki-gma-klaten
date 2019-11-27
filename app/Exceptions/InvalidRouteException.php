<?php

namespace App\Exceptions;

use Exception;

class InvalidRouteException extends Exception
{
    public static function render()
    {
        return response()->json([
            'error' => true,
            'message' => 'Invalid route',
        ]);
    }
}
