<?php

namespace App\Repositories;

use App\Helper;
use App\Models\Account;
use App\Models\OpenTrade;
use App\Models\CloseTrade;
use App\Interfaces\ForexRepositoryInterface;

class ForexRepository implements ForexRepositoryInterface
{
    public function storeData($request)
    {
        $telegramUserId = $request->userid;
        $account = $request->account;
        $openTrade = $request->open;
        $closeTrade = $request->close;

        $abbreviation = Helper::generateAbbreviation($account['AccountCompany']);

        $data = [
            'account' => $this->storeAccount($account, $telegramUserId),
            'open_trade' => $this->storeTrades($openTrade, $telegramUserId, $abbreviation, OpenTrade::class),
            'close_trade' => $this->storeTrades($closeTrade, $telegramUserId, $abbreviation, CloseTrade::class)
        ];

        Helper::sendWebhook(['account' => $data['account']]);

        return $data;
    }

    protected function storeAccount($account, $telegramUserId)
    {
        if (empty($account)) {
            return null;
        }

        $account = Account::create([
            'login_id' => $account['AccountLogin'],
            'telegram_user_uuid' => $telegramUserId,
            'trade_mode' => $account['AccountTradeMode'],
            'leverage' => $account['AccountLeverage'],
            'limit_orders' => $account['AccountLimitOrders'],
            'margin_so_mode' => $account['AccountMarginSOMode'],
            'is_trade_allowed' => $account['AccountTradeAllowed'],
            'is_trade_expert' => $account['AccountTradeExpert'],
            'balance' => $account['AccountBalance'],
            'credit' => $account['AccountCredit'],
            'profit' => $account['AccountProfit'],
            'equity' => $account['AccountEquity'],
            'margin' => $account['AccountMargin'],
            'margin_free' => $account['AccountMarginFree'],
            'margin_level' => $account['AccountMarginLevel'],
            'margin_so_call' => $account['AccountMarginSOCall'],
            'margin_so_so' => $account['AccountMarginSOSO'],
            'margin_initial' => $account['AccountMarginInitial'],
            'margin_maintenance' => $account['AccountMarginMaintenance'],
            'assets' => $account['AccountAssets'],
            'liabilities' => $account['AccountLiabilities'],
            'commission_blocked' => $account['AccountCommissionBlocked'],
            'name' => $account['AccountName'],
            'server' => $account['AccountServer'],
            'currency' => $account['AccountCurrency'],
            'company' => $account['AccountCompany']
        ]);

        return $account;
    }

    protected function storeTrades($data, $telegramUserId, $companyAbbreviation, $model)
    {
        if (empty($data)) {
            return null;
        }

        $trade = $model::create([
            'telegram_user_uuid' => $telegramUserId,
            'ticket' => $companyAbbreviation . $data['OrderTicket'],
            'symbol' => $data['OrderSymbol'],
            'type' => $data['OrderType'],
            'lots' => $data['OrderLots'],
            'commission' => $data['OrderCommission'],
            'profit' => $data['OrderProfit'],
            'stop_loss' => $data['OrderStopLoss'],
            'swap' => $data['OrderSwap'],
            'take_profit' => $data['OrderTakeProfit'],
            'magic_number' => $data['OrderMagicNumber'],
            'comment' => $data['OrderComment'],
            'open_price' => $data['OrderOpenPrice'],
            'open_at' => $data['OrderOpenTime'],
            'close_price' => $data['OrderClosePrice'],
            'close_at' => $data['OrderCloseTime'],
            'expired_at' => $data['OrderExpiration']
        ]);

        return $trade;
    }
}