<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Response;
use App\Repositories\ForexRepository;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Http\Requests\StoreForexDataRequest;
use GuzzleHttp\Psr7\Request;

class ForexController extends Controller
{
    private $forexRepository;

    public function __construct(ForexRepository $forexRepository)
    {
        $this->forexRepository = $forexRepository;
    }

    public function storeData(Request $request)
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
