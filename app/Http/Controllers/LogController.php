<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class LogController extends Controller
{
    public function log()
    {
        $logFiles = glob(
            storage_path('logs/') . "laravel-*.log"
        );
        $logFilePath = end($logFiles) ?: null;
        
        $log = nl2br(!is_null($logFilePath) ? file_get_contents($logFilePath) : 'No errors found! Yay :)');

        return Inertia::render('Log', [
            'title' => 'Application Log',
            'log' => $log
        ]);
    }
}