<?php

namespace App;

use Spatie\WebhookServer\WebhookCall;

class Helper {
    public static function generateAbbreviation(string $name = '')
    {
        $words = explode(' ', $name);
        $abbreviation = '';

        foreach ($words as $word) {
            $abbreviation .= strtoupper(substr($word, 0, 1));
        }

        return $abbreviation;
    }

    public static function sendWebhook($data)
    {
        WebhookCall::create()
            ->url(env('WEBHOOK_URL'))
            ->payload($data)
            ->useSecret(env('WEBHOOK_CLIENT_SECRET'))
            ->dispatch();
    }
}