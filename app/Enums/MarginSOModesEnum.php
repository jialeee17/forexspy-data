<?php

namespace App\Enums;

enum MarginSOModesEnum: string
{
    case PERCENT = 'percent';
    case MONEY = 'money';

    public function label(): string
    {
        return match ($this) {
            static::PERCENT => 'Percent',
            static::MONEY => 'Money',
        };
    }
}