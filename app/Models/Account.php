<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'login_id',
        'forexspy_user_uuid',
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
        'highest_drawdown_amount',
        'highest_drawdown_percentage',
        'active_pairs',
        'active_orders',
        'profit_today',
        'profit_all_time',
        'name',
        'server',
        'currency',
        'company'
    ];
}
