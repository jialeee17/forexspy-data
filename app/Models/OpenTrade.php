<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpenTrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'login_id',
        'telegram_user_uuid',
        'ticket',
        'symbol',
        'type',
        'lots',
        'commission',
        'profit',
        'stop_loss',
        'swap',
        'take_profit',
        'magic_number',
        'comment',
        'open_price',
        'open_at',
        'close_price',
        'close_at',
        'expired_at',
        'is_notified'
    ];

    protected $casts = [
        'open_at' => 'datetime:Y-m-d H:i:s',
        'close_at' => 'datetime:Y-m-d H:i:s',
        'expired_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    const TYPE_BUY = 'buy';
    const TYPE_SELL = 'sell';

    public static $type = [
        self::TYPE_BUY,
        self::TYPE_SELL
    ];
}
