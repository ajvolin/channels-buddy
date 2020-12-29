<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class LogController extends Controller
{
    public function log()
    {
        $logFiles = glob(
            storage_path('logs/') . "laravel-*.log"
        );
        $logFilePath = end($logFiles) ?? null;
        
        $log = file_get_contents($logFilePath) ?? null;
        return view('log',
            [
                'log' => $log
            ]
        );
    }
}