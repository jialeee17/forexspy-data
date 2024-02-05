<?php

namespace App\Enums;

enum OrderTypesEnum: string
{
    case BUY = 'buy';
    case SELL = 'sell';

    public function label(): string
    {
        return match ($this) {
            static::BUY => 'Buy',
            static::SELL => 'Sell',
        };
    }
}