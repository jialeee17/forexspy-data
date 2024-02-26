<?php

namespace App\Enums;

enum OrderStatusesEnum: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';

    public function label(): string
    {
        return match ($this) {
            static::OPEN => 'Open',
            static::CLOSED => 'Closed',
        };
    }
}