<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Response;
use App\Services\TradeService;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Requests\StoreTradesRequest;
use App\Http\Responses\ApiSuccessResponse;

class TradeController extends Controller
{
    private $tradeService;

    public function __construct(TradeService $tradeService)
    {
        $this->tradeService = $tradeService;
    }

    public function store(StoreTradesRequest $request)
    {
        try {
            $data = $this->tradeService->storeTrades($request);

            return new ApiSuccessResponse(
                $data,
                __('common.create.success', ['name' => 'Forex Data']),
                Response::HTTP_CREATED
            );
        } catch (Throwable $exception) {
            return new ApiErrorResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }
}
