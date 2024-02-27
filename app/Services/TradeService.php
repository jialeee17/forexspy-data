<?php

namespace App\Services;

use App\Helper;
use App\Models\Trade;
use App\Models\Account;
use Spatie\WebhookServer\WebhookCall;

class TradeService
{
    public function storeTrades($request)
    {
        $forexspyUserUuid = $request->forexspy_user_uuid;
        $accountDetails = $request->account;
        $trades = $request->trades;
        $isHistorical = $request->is_historical === 'true' ? true : false; // The account's trade history (Use for initial setup)

        // Upsert Account Details
        $account = Account::updateOrCreate(
            [
                'login_id' => $accountDetails['AccountLogin'],
            ],
            [
                'forexspy_user_uuid' => $forexspyUserUuid,
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

        // Upsert Trades
        if ($trades) {
            $arr = [];
            $abbreviation = Helper::generateAbbreviation($accountDetails['AccountCompany']);

            foreach ($trades as $trade) {
                $tempArr = [
                    'account_login_id' => $accountDetails['AccountLogin'],
                    'ticket' => $abbreviation . $trade['OrderTicket'],
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
                    'status' => $trade['OrderStatus'],
                    'open_price' => $trade['OrderOpenPrice'],
                    'open_at' => $trade['OrderOpenTime'],
                    'close_price' => $trade['OrderClosePrice'] ?? null,
                    'close_at' => $trade['OrderCloseTime'] ?? null,
                    'expired_at' => $trade['OrderExpiration'] ?? null,
                ];

                // Mark as notified during initial setup
                if ($isHistorical) {
                    $tempArr['open_notif_sent'] = true;
                    $tempArr['closed_notif_sent'] = true;
                }

                $arr[] = $tempArr;
            }

            $keyShouldUpsert = ['account_login_id', 'symbol', 'type', 'lots', 'commission', 'profit', 'stop_loss', 'swap', 'take_profit', 'magic_number', 'comment', 'status', 'open_price', 'open_at', 'close_price', 'close_at', 'expired_at'];

            if ($isHistorical) {
                $keyShouldUpsert[] = 'open_notif_sent';
                $keyShouldUpsert[] = 'closed_notif_sent';
            }

            Trade::upsert(
                $arr,
                ['ticket'],
                $keyShouldUpsert
            );

            WebhookCall::create()
                ->url(env('FOREXSPY_API_URL') . '/webhooks/new-trade-received')
                ->payload([
                    'event' => 'new-trade-received',
                    'forexspy_user_uuid' => $forexspyUserUuid,
                    // 'trades' => $arr,
                ])
                ->useSecret(env('WEBHOOK_SECRET'))
                ->dispatchIf(!$isHistorical);
        }

        // Webhooks
        WebhookCall::create()
            ->url(env('FOREXSPY_API_URL') . '/webhooks/trade-history-received')
            ->payload([
                'event' => 'trade-history-received',
                'forexspy_user_uuid' => $forexspyUserUuid,
                'mt_account' => $account,
            ])
            ->useSecret(env('WEBHOOK_SECRET'))
            ->dispatchIf($isHistorical);


        return $request->all(); // Return the exact data back to MT4
    }
}
