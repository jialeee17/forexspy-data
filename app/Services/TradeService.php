<?php

namespace App\Services;

use App\Helper;
use App\Models\Account;
use App\Models\OpenTrade;
use App\Models\CloseTrade;

class TradeService
{
    public function storeTrades($request)
    {
        $telegramUserUuid = $request->forexspy_user_uuid;
        $accountDetails = $request->account;
        $openTrades = $request->open;
        $closeTrades = $request->close;
        $hasClosedTrades = !empty($closeTrades) ? 1 : 0;
        $isHistorical = $request->is_historical === 'true' ? 1 : 0;
        $abbreviation = Helper::generateAbbreviation($accountDetails['AccountCompany']);

        $account = Account::updateOrCreate(
            [
                'login_id' => $accountDetails['AccountLogin'],
            ],
            [
                'telegram_user_uuid' => $telegramUserUuid,
                'trade_mode' => $accountDetails['AccountTradeMode'],
                'leverage' => $accountDetails['AccountLeverage'],
                'limit_orders' => $accountDetails['AccountLimitOrders'],
                'margin_so_mode' => $accountDetails['AccountMarginSOMode'],
                'is_trade_allowed' => $accountDetails['AccountTradeAllowed'],
                'is_trade_expert' => $accountDetails['AccountTradeExpert'],
                'balance' => $accountDetails['AccountBalance'],
                'credit' => $accountDetails['AccountCredit'],
                'profit' => $accountDetails['AccountProfit'],
                'equity' => $accountDetails['AccountEquity'],
                'margin' => $accountDetails['AccountMargin'],
                'margin_free' => $accountDetails['AccountMarginFree'],
                'margin_level' => $accountDetails['AccountMarginLevel'],
                'margin_so_call' => $accountDetails['AccountMarginSOCall'],
                'margin_so_so' => $accountDetails['AccountMarginSOSO'],
                'margin_initial' => $accountDetails['AccountMarginInitial'],
                'margin_maintenance' => $accountDetails['AccountMarginMaintenance'],
                'assets' => $accountDetails['AccountAssets'],
                'liabilities' => $accountDetails['AccountLiabilities'],
                'commission_blocked' => $accountDetails['AccountCommissionBlocked'],
                'highest_drawdown_amount' => $accountDetails['AccountHighestDDAmount'],
                'highest_drawdown_percentage' => $accountDetails['AccountHighestDDPercentage'],
                'active_pairs' => $accountDetails['AccountActivePairs'],
                'active_orders' => $accountDetails['AccountActiveOrders'],
                'profit_today' => $accountDetails['AccountProfitToday'],
                'profit_all_time' => $accountDetails['AccountProfitAllTime'],
                'name' => $accountDetails['AccountName'],
                'server' => $accountDetails['AccountServer'],
                'currency' => $accountDetails['AccountCurrency'],
                'company' => $accountDetails['AccountCompany']
            ]
        );

        $data = [
            'account' => $account,
            'open_trade' => $this->upsertTrades($openTrades, $accountDetails['AccountLogin'], $telegramUserUuid, $abbreviation, $isHistorical, OpenTrade::class),
            'close_trade' => $this->upsertTrades($closeTrades, $accountDetails['AccountLogin'], $telegramUserUuid, $abbreviation, $isHistorical, CloseTrade::class)
        ];

        /**
         * The 'has_closed_trades' flag determines if querying for unnotified close trades is needed within the Forex Spy Process.
         * If the incoming data does not include close trades, there is no need to notify the user.
         */
        Helper::sendWebhook(['account' => $data['account'], 'has_closed_trades' => $hasClosedTrades, 'is_historical' => $isHistorical]);

        return $data;
    }

    protected function upsertTrades($trades, $loginId, $telegramUserUuid, $companyAbbreviation, $isHistorical, $model)
    {
        $arr = [];

        foreach ($trades as $trade) {
            $arr[] = [
                'login_id' => $loginId,
                'telegram_user_uuid' => $telegramUserUuid,
                'ticket' => $companyAbbreviation . $trade['OrderTicket'],
                'symbol' => $trade['OrderSymbol'],
                'type' => $trade['OrderType'],
                'lots' => $trade['OrderLots'],
                'commission' => $trade['OrderCommission'],
                'profit' => $trade['OrderProfit'],
                'stop_loss' => $trade['OrderStopLoss'],
                'swap' => $trade['OrderSwap'],
                'take_profit' => $trade['OrderTakeProfit'],
                'magic_number' => $trade['OrderMagicNumber'],
                'comment' => $trade['OrderComment'] ?? null,
                'open_price' => $trade['OrderOpenPrice'],
                'open_at' => $trade['OrderOpenTime'],
                'close_price' => $trade['OrderClosePrice'] ?? null,
                'close_at' => $trade['OrderCloseTime'] ?? null,
                'expired_at' => $trade['OrderExpiration'] ?? null,
                'is_notified' => $isHistorical ? 1 : 0
            ];
        }

        $model::upsert(
            $arr,
            ['ticket'],
            ['login_id', 'telegram_user_uuid', 'symbol', 'type', 'lots', 'commission', 'profit', 'stop_loss', 'swap', 'take_profit', 'magic_number', 'comment', 'open_price', 'open_at', 'close_price', 'close_at', 'expired_at']
        );

        return $trades;
    }
}
