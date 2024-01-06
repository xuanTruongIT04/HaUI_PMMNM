<?php

namespace App\Http\Controllers\Master;

use App\Config\Message;
use App\Exceptions\CustomExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Presenter\Response;
use App\UseCase\Master\MasterService;
use App\UseCase\Master\MasterUseCase;
use App\Util\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

class MasterController extends Controller {

    private MasterUseCase $service;

    public function __construct(MasterService $service)
    {
        $this->service = $service;
    }

    public function getAllStatusByType(Request $request) {
        $type = $request->query("type");
        if ($type == null) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $results = $this->service->getAllStatusByType($type);
        if ($results->getException() != null) {
            return ExceptionHandler::CustomHandleException($results->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, $results->getData());
    }
}