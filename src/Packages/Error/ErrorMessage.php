<?php
/**
 * Created by PhpStorm.
 * User: michalmrzyglod
 * Date: 28.05.18
 * Time: 21:11
 */

namespace Packages\Error;

class ErrorMessage
{
    public static function json(\Exception $e)
    {
        return json_encode([
            'error' => [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ]
        ], JSON_PRETTY_PRINT);
    }
}