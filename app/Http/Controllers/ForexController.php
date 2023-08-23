<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\ForexRepository;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Http\Requests\StoreForexDataRequest;

class ForexController extends Controller
{
    private $forexRepository;

    public function __construct(ForexRepository $forexRepository)
    {
        $this->forexRepository = $forexRepository;
    }

    public function storeData(StoreForexDataRequest $request)
    {
        try {
            $data = $this->forexRepository->storeData($request);

            return new ApiSuccessResponse(
                $data,
                __('common.create.success', ['resource' => 'Forex Data']),
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
