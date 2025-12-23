<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('telegram:webhook', function ()
{
    \App\Http\Controllers\TelegramController::webhookOtomateBot();
});
