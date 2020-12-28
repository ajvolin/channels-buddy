<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class LogController extends Controller
{
    public function log()
    {
        $log = file_get_contents(storage_path('logs/laravel.log'));
        return view('log',
            [
                'log' => $log
            ]
        );
    }
}