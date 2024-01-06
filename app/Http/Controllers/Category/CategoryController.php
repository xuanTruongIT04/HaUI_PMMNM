<?php

namespace App\Http\Controllers\Category;

use App\Config\Constant;
use App\Config\Message;
use App\Exceptions\CustomExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Payload\Category\Payload;
use App\Http\Controllers\Category\Common;
use App\Http\Presenter\Response;
use App\UseCase\Category\CategoryUseCase;
use App\Util\ExceptionHandler;
use Illuminate\Http\Request;
use App\Util\Common as UtilCommon;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    private CategoryUseCase $service;

    public function __construct(CategoryUseCase $service)
    {
        $this->service = $service;
    }

    public function getAllCategoryByType(Request $request)
    {
        $type = $request->query('type');
        if ($type == null) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $results = $this->service->getAllCategoryByType($type);

        if ($results->getException() != null) {
            return ExceptionHandler::CustomHandleException($results->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, $results->getData());
    }

    public function getCategoryById(Request $request)
    {
        $id = $request->query('categoryId');
        $idInt = intval($id);
        if ($idInt == 0) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $results = $this->service->getCategoryById($idInt);
        if ($results->getException() != null) {
            return ExceptionHandler::CustomHandleException($results->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, $results->getData());
    }

    public function createNewCategory(Request $request)
    {
        $payload = $request->only(Payload::CategoryPayload);
        $validator = Validator::make($payload, Payload::CategoryPayload);
        if ($validator->fails()) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $results = $this->service->createCategory(Common::convertCategoryPayloadToEntity($payload));
        if ($results->getException() != null) {
            return ExceptionHandler::CustomHandleException($results->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, $results->getData());
    }

    public function updateCategory(Request $request)
    {
        $payload = $request->only(Payload::UpdateCategory);
        $validator = Validator::make($payload, Payload::ValidatUpdateCategoryPayload);
        if ($validator->fails()) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $results = $this->service->updateCategory(UtilCommon::convertKeysToCase(Constant::SNAKE_CASE, $payload));
        if ($results->getException() != null) {
            return ExceptionHandler::CustomHandleException($results->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, null);
    }

    public function deleteCategory(Request $request)
    {
        $id = $request->query('categoryId');
        $idInt = intval($id);
        if ($idInt == 0) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $results = $this->service->deleteCategoryById($idInt);
        if ($results->getException() != null) {
            return ExceptionHandler::CustomHandleException($results->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, null);
    }
}
