<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'login_id',
        'telegram_user_uuid',
        'trade_mode',
        'leverage',
        'limit_orders',
        'margin_so_mode',
        'is_trade_allowed',
        'is_trade_expert',
        'balance',
        'credit',
        'profit',
        'equity',
        'margin',
        'margin_free',
        'margin_level',
        'margin_so_call',
        'margin_so_so',
        'margin_initial',
        'margin_maintenance',
        'assets',
        'liabilities',
        'commission_blocked',
        'name',
        'server',
        'currency',
        'company'
    ];

    const TRADE_MODE_DEMO = 'demo';
    const TRADE_MODE_CONTEST = 'contest';
    const TRADE_MODE_REAL = 'real';

    const MARGIN_SO_MODE_PERCENT = 'percent';
    const MARGIN_SO_MODE_MONEY = 'money';

    public static $trade_mode = [
        self::TRADE_MODE_DEMO,
        self::TRADE_MODE_CONTEST,
        self::TRADE_MODE_REAL
    ];

    public static $margin_so_mode = [
        self::MARGIN_SO_MODE_PERCENT,
        self::MARGIN_SO_MODE_MONEY
    ];
}
