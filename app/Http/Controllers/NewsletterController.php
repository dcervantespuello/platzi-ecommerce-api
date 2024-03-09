<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\SendReminderCommand;

class NewsletterController extends Controller
{
    public function send()
    {
        Artisan::call(SendReminderCommand::class);

        return response()->json([
            'data' => 'ok'
        ]);
    }
}
