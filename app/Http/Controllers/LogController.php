<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class LogController
{
    public function test()
    {
        throw new \Exception('ddd','321');
        echo 'dd';
        Log::info('aass');
        Log::debug('ddd');
        Log::channel('slack')->info('Something happened!');
    }
}