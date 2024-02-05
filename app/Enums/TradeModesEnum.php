<?php

namespace App\Enums;

enum TradeModesEnum: string
{
    case DEMO = 'demo';
    case CONTEST = 'contest';
    case REAL = 'real';

    public function label(): string
    {
        return match ($this) {
            static::DEMO => 'Demo',
            static::CONTEST => 'Contest',
            static::REAL => 'Real',
        };
    }
}