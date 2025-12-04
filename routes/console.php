<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function ()
{
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('telegram:webhook-otomate-bot', function ()
{
    \App\Http\Controllers\TelegramController::webhookOtomateBot();
});
