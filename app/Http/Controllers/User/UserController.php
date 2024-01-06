<?php

namespace App\Http\Controllers\User;

use App\Config\Message;
use App\Http\Controllers\Controller;
use App\Http\Presenter\Response;
use App\Http\Presenter\User\Presenter;
use App\UseCase\User\UserService;
use App\UseCase\User\UserUseCase;
use App\Util\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

class UserController extends Controller
{
    private UserUseCase $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function getAllUser(Request $request)
    {

        $listUser = $this->service->getAllUser();

        if ($listUser->getException() != null) {
            return ExceptionHandler::CustomHandleException($listUser->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, Presenter::convertListUserToPresenter($listUser->getData()));
    }
}
