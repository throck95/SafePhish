<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Log;

class ErrorLogging
{
    public static function logError(\Exception $e) {
        $message = $e->getCode() . ': ' . $e->getMessage() . PHP_EOL;
        $message .= $e->getTraceAsString() . PHP_EOL;
        $message .= str_repeat('-',100) . PHP_EOL . PHP_EOL;
        Log::error($message);
    }
}