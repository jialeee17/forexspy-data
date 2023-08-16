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
        $telegramUserUuid = $request->forexspy_user_uuid;
        $account = $request->account;
        $openTrade = $request->open;
        $closeTrade = $request->close;
        $hasClosedTrades = !empty($closeTrade) ? true : false;

        $abbreviation = Helper::generateAbbreviation($account['AccountCompany']);

        $data = [
            'account' => $this->storeAccount($account, $telegramUserUuid),
            'open_trade' => $this->storeTrades($openTrade, $account['AccountLogin'], $telegramUserUuid, $abbreviation, OpenTrade::class),
            'close_trade' => $this->storeTrades($closeTrade, $account['AccountLogin'], $telegramUserUuid, $abbreviation, CloseTrade::class)
        ];

        /**
         * The 'has_closed_trades' flag determines if querying for unnotified close trades is needed within the Forex Spy Process.
         * If the incoming data does not include close trades, there is no need to notify the user.
         */
        Helper::sendWebhook(['account' => $data['account'], 'has_closed_trades' => $hasClosedTrades]);

        return $data;
    }

    protected function storeAccount($account, $telegramUserUuid)
    {
        if (empty($account)) {
            return null;
        }

        $account = Account::updateOrCreate(
            [
                'login_id' => $account['AccountLogin'],
            ],
            [
                'telegram_user_uuid' => $telegramUserUuid,
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
            ]
        );

        return $account;
    }

    protected function storeTrades($data, $loginId, $telegramUserUuid, $companyAbbreviation, $model)
    {
        if (empty($data)) {
            return null;
        }

        $trades = [];

        foreach($data as $d) {
            $trades[] = [
                'login_id' => $loginId,
                'telegram_user_uuid' => $telegramUserUuid,
                'ticket' => $companyAbbreviation . $d['OrderTicket'],
                'symbol' => $d['OrderSymbol'],
                'type' => $d['OrderType'],
                'lots' => $d['OrderLots'],
                'commission' => $d['OrderCommission'],
                'profit' => $d['OrderProfit'],
                'stop_loss' => $d['OrderStopLoss'],
                'swap' => $d['OrderSwap'],
                'take_profit' => $d['OrderTakeProfit'],
                'magic_number' => $d['OrderMagicNumber'],
                'comment' => $d['OrderComment'] ?? null,
                'open_price' => $d['OrderOpenPrice'],
                'open_at' => $d['OrderOpenTime'],
                'close_price' => $d['OrderClosePrice'] ?? null,
                'close_at' => $d['OrderCloseTime'] ?? null,
                'expired_at' => $d['OrderExpiration'] ?? null
            ];
        }

        $model::upsert(
            $trades,
            ['ticket'],
            ['login_id', 'telegram_user_uuid', 'symbol', 'type', 'lots', 'commission', 'profit', 'stop_loss', 'swap', 'take_profit', 'magic_number', 'comment', 'open_price', 'open_at', 'close_price', 'close_at', 'expired_at']
        );

        return $trades;
    }
}