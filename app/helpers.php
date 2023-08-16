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
            ->url(env('WEBHOOK_URL', 'https://process.forexspy.pro/webhooks'))
            ->payload($data)
            ->useSecret(env('WEBHOOK_SECRET'))
            ->dispatch();
    }
}