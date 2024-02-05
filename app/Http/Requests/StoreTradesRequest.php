<?php

namespace App\Http\Requests;

use App\Enums\MarginSOModesEnum;
use App\Enums\OrderTypesEnum;
use App\Enums\TradeModesEnum;
use App\Models\OpenTrade;
use App\Models\CloseTrade;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'forexspy_user_uuid' => 'required|uuid',

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

            'open' => ['nullable', 'array'],
            'open.*.OrderTicket' => ['required'],
            'open.*.OrderSymbol' => ['required', 'string'],
            'open.*.OrderType' => ['required', Rule::enum(OrderTypesEnum::class)],
            'open.*.OrderLots' => ['required', 'numeric'],
            'open.*.OrderCommission' => ['required', 'numeric'],
            'open.*.OrderProfit' => ['required', 'numeric'],
            'open.*.OrderStopLoss' => ['required', 'numeric'],
            'open.*.OrderSwap' => ['required', 'numeric'],
            'open.*.OrderTakeProfit' => ['required', 'numeric'],
            'open.*.OrderMagicNumber' => ['required'],
            'open.*.OrderComment' => ['nullable', 'string'],
            'open.*.OrderOpenPrice' => ['required', 'numeric'],
            'open.*.OrderOpenTime' => ['required'],
            'open.*.OrderClosePrice' => ['nullable', 'numeric'],
            'open.*.OrderCloseTime' => ['nullable'],
            'open.*.OrderExpiration' => ['nullable'],

            'close' => ['nullable', 'array'],
            'close.*.OrderTicket' => ['required'],
            'close.*.OrderSymbol' => ['required', 'string'],
            'close.*.OrderType' => ['required', Rule::enum(OrderTypesEnum::class)],
            'close.*.OrderLots' => ['required', 'numeric'],
            'close.*.OrderCommission' => ['required', 'numeric'],
            'close.*.OrderProfit' => ['required', 'numeric'],
            'close.*.OrderStopLoss' => ['required', 'numeric'],
            'close.*.OrderSwap' => ['required', 'numeric'],
            'close.*.OrderTakeProfit' => ['required', 'numeric'],
            'close.*.OrderMagicNumber' => ['required'],
            'close.*.OrderComment' => ['nullable', 'string'],
            'close.*.OrderOpenPrice' => ['required', 'numeric'],
            'close.*.OrderOpenTime' => ['required'],
            'close.*.OrderClosePrice' => ['required', 'numeric'],
            'close.*.OrderCloseTime' => ['required'],
            'close.*.OrderExpiration' => ['nullable'],
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

            'open.*.OrderTicket' => 'Order Ticket (Open)',
            'open.*.OrderSymbol' => 'Order Symbol (Open)',
            'open.*.OrderType' => 'Order Type (Open)',
            'open.*.OrderLots' => 'Order Lots (Open)',
            'open.*.OrderCommission' => 'Order Commission (Open)',
            'open.*.OrderProfit' => 'Order Profit (Open Trade)',
            'open.*.OrderStopLoss' => 'Order Stop Loss (Open)',
            'open.*.OrderSwap' => 'Order Swap (Open)',
            'open.*.OrderTakeProfit' => 'Order Take Profit (Open)',
            'open.*.OrderMagicNumber' => 'Order Magic Number (Open)',
            'open.*.OrderComment' => 'Order Comment (Open)',
            'open.*.OrderOpenPrice' => 'Order Open Price (Open)',
            'open.*.OrderOpenTime' => 'Order Open Time (Open)',
            'open.*.OrderClosePrice' => 'Order Close Price (Open)',
            'open.*.OrderCloseTime' => 'Order Close Time (Open)',
            'open.*.OrderExpiration' => 'Order Expiration Date (Open)',

            'close.*.OrderTicket' => 'Order Ticket (Close)',
            'close.*.OrderSymbol' => 'Order Symbol (Close)',
            'close.*.OrderType' => 'Order Type (Close)',
            'close.*.OrderLots' => 'Order Lots (Close)',
            'close.*.OrderCommission' => 'Order Commission (Close)',
            'close.*.OrderProfit' => 'Order Profit (Close)',
            'close.*.OrderStopLoss' => 'Order Stop Loss (Close)',
            'close.*.OrderSwap' => 'Order Swap (Close)',
            'close.*.OrderTakeProfit' => 'Order Take Profit (Close)',
            'close.*.OrderMagicNumber' => 'Order Magic Number (Close)',
            'close.*.OrderComment' => 'Order Comment (Close)',
            'close.*.OrderOpenPrice' => 'Order Open Price (Close)',
            'close.*.OrderOpenTime' => 'Order Open Time (Close)',
            'close.*.OrderClosePrice' => 'Order Close Price (Close)',
            'close.*.OrderCloseTime' => 'Order Close Time (Close)',
            'close.*.OrderExpiration' => 'Order Expiration Date (Close)',
        ];
    }

    // public function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'success'   => false,
    //         'message'   => 'Validation errors',
    //         'data'      => $validator->errors()
    //     ]));
    // }
}
