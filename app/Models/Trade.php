<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_login_id',
        'ticket',
        'symbol',
        'order_type',
        'lots',
        'commission',
        'profit',
        'stop_loss',
        'swap',
        'take_profit',
        'magic_number',
        'comment',
        'status',
        'open_price',
        'open_at',
        'close_price',
        'close_at',
        'expired_at',
        'open_notif_sent',
        'closed_notif_sent',
    ];
}
