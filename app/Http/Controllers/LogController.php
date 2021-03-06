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
        $logFilePath = end($logFiles) ?: null;
        
        $log = !is_null($logFilePath) ? file_get_contents($logFilePath) : 'No errors found! Yay :)';
        return view('log',
            [
                'log' => nl2br($log)
            ]
        );
    }
}