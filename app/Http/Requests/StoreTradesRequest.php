<?php

namespace App\Http\Requests;

use App\Enums\OrderTypesEnum;
use App\Enums\TradeModesEnum;
use Illuminate\Validation\Rule;
use App\Enums\MarginSOModesEnum;
use App\Enums\OrderStatusesEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreTradesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'forexspy_user_uuid' => ['required', 'uuid'],

            'account' => ['required', 'array'],
            'account.AccountLogin' => ['required', 'integer'],
            'account.AccountTradeMode' => ['required', Rule::enum(TradeModesEnum::class)],
            'account.AccountLeverage' => ['required', 'integer'],
            'account.AccountLimitOrders' => ['required', 'integer'],
            'account.AccountMarginSOMode' => ['required', Rule::enum(MarginSOModesEnum::class)],
            'account.AccountTradeAllowed' => ['required', 'boolean'],
            'account.AccountTradeExpert' => ['required', 'boolean'],
            'account.AccountBalance' => ['required', 'numeric'],
            'account.AccountCredit' => ['required', 'numeric'],
            'account.AccountProfit' => ['required', 'numeric'],
            'account.AccountEquity' => ['required', 'numeric'],
            'account.AccountMargin' => ['required', 'numeric'],
            'account.AccountMarginFree' => ['required', 'numeric'],
            'account.AccountMarginLevel' => ['required', 'numeric'],
            'account.AccountMarginSOCall' => ['required', 'numeric'],
            'account.AccountMarginSOSO' => ['required', 'numeric'],
            'account.AccountMarginInitial' => ['required', 'numeric'],
            'account.AccountMarginMaintenance' => ['required', 'numeric'],
            'account.AccountAssets' => ['required', 'numeric'],
            'account.AccountLiabilities' => ['required', 'numeric'],
            'account.AccountCommissionBlocked' => ['required', 'numeric'],
            'account.AccountHighestDDAmount' => ['required', 'numeric'],
            'account.AccountHighestDDPercentage' => ['required', 'numeric'],
            'account.AccountActivePairs' => ['required', 'integer'],
            'account.AccountActiveOrders' => ['required', 'integer'],
            'account.AccountProfitToday' => ['required', 'numeric'],
            'account.AccountProfitAllTime' => ['required', 'numeric'],
            'account.AccountName' => ['required', 'string'],
            'account.AccountServer' => ['required', 'string'],
            'account.AccountCurrency' => ['required', 'string'],
            'account.AccountCompany' => ['required', 'string'],

            'trades' => ['nullable', 'array'],
            'trades.*.OrderTicket' => ['required'],
            'trades.*.OrderSymbol' => ['required', 'string'],
            'trades.*.OrderType' => ['required', Rule::enum(OrderTypesEnum::class)],
            'trades.*.OrderLots' => ['required', 'numeric'],
            'trades.*.OrderCommission' => ['required', 'numeric'],
            'trades.*.OrderProfit' => ['required', 'numeric'],
            'trades.*.OrderStopLoss' => ['required', 'numeric'],
            'trades.*.OrderSwap' => ['required', 'numeric'],
            'trades.*.OrderTakeProfit' => ['required', 'numeric'],
            'trades.*.OrderMagicNumber' => ['required'],
            'trades.*.OrderComment' => ['nullable', 'string'],
            'trades.*.OrderStatus' => ['required', Rule::enum(OrderStatusesEnum::class)],
            'trades.*.OrderOpenPrice' => ['required', 'numeric'],
            'trades.*.OrderOpenTime' => ['required'],
            'trades.*.OrderClosePrice' => ['nullable', 'numeric'],
            'trades.*.OrderCloseTime' => ['nullable'],
            'trades.*.OrderExpiration' => ['nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'userid' => 'User ID',

            'account.AccountLogin' => 'Account Login',
            'account.AccountTradeMode' => 'Account Trade Mode',
            'account.AccountLeverage' => 'Account Leverage',
            'account.AccountLimitOrders' => 'Account Limit Orders',
            'account.AccountMarginSOMode' => 'Account Margin SO Mode',
            'account.AccountTradeAllowed' => 'Account Trade Allowed',
            'account.AccountTradeExpert' => 'Account Trade Expert',
            'account.AccountBalance' => 'Account Balance',
            'account.AccountCredit' => 'Account Credit',
            'account.AccountProfit' => 'Account Profit',
            'account.AccountEquity' => 'Account Equity',
            'account.AccountMargin' => 'Account Margin',
            'account.AccountMarginFree' => 'Account Margin Free',
            'account.AccountMarginLevel' => 'Account Margin Level',
            'account.AccountMarginSOCall' => 'Account Margin SO Call',
            'account.AccountMarginSOSO' => 'Account Margin SO SO',
            'account.AccountMarginInitial' => 'Account Margin Initial',
            'account.AccountMarginMaintenance' => 'Account Margin Maintenance',
            'account.AccountAssets' => 'Account Assets',
            'account.AccountLiabilities' => 'Account Liabilities',
            'account.AccountCommissionBlocked' => 'Account Commission Blocked',
            'account.AccountHighestDDAmount' => 'Account Highest Drawdown Amount',
            'account.AccountHighestDDPercentage' => 'Account Highest Drawdown Percentage',
            'account.AccountActivePairs' => 'Account Active Pairs',
            'account.AccountActiveOrders' => 'Account Active Orders',
            'account.AccountProfitToday' => 'Account Profit Today',
            'account.AccountProfitAllTime' => 'Account Profit All Time',
            'account.AccountName' => 'Account Name',
            'account.AccountServer' => 'Account Server',
            'account.AccountCurrency' => 'Account Currency',
            'account.AccountCompany' => 'Account Company',

            'trades.*.OrderTicket' => 'Order Ticket (Open)',
            'trades.*.OrderSymbol' => 'Order Symbol (Open)',
            'trades.*.OrderType' => 'Order Type (Open)',
            'trades.*.OrderLots' => 'Order Lots (Open)',
            'trades.*.OrderCommission' => 'Order Commission (Open)',
            'trades.*.OrderProfit' => 'Order Profit (Open Trade)',
            'trades.*.OrderStopLoss' => 'Order Stop Loss (Open)',
            'trades.*.OrderSwap' => 'Order Swap (Open)',
            'trades.*.OrderTakeProfit' => 'Order Take Profit (Open)',
            'trades.*.OrderMagicNumber' => 'Order Magic Number (Open)',
            'trades.*.OrderComment' => 'Order Comment (Open)',
            'trades.*.OrderStatus' => 'Order Status',
            'trades.*.OrderOpenPrice' => 'Order Open Price (Open)',
            'trades.*.OrderOpenTime' => 'Order Open Time (Open)',
            'trades.*.OrderClosePrice' => 'Order Close Price (Open)',
            'trades.*.OrderCloseTime' => 'Order Close Time (Open)',
            'trades.*.OrderExpiration' => 'Order Expiration Date (Open)',
        ];
    }
}
