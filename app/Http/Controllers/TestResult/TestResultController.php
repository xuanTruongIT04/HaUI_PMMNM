<?php

namespace App\Http\Controllers\TestResult;

use App\Config\Constant;
use App\Config\Message;
use App\Exceptions\CustomExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Payload\TestResult\Payload;
use App\Http\Presenter\Response;
use App\UseCase\TestResult\TestResultUseCase;
use App\Util\Common as UtilCommon;
use App\Util\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Validator;

class TestResultController extends Controller {

    private TestResultUseCase $service;

    public function __construct(TestResultUseCase $service)
    {
        $this->service = $service;
    }

    public function createTestResult(Request $request) {
        $payload = $request->only(Payload::CreateTestResultPayload);
        $validator = Validator::make($payload, Payload::ValidateCreateTestResultPayload);
        if ($validator->fails()) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $payload = UtilCommon::convertKeysToCase(Constant::SNAKE_CASE, $payload);
        $result = $this->service->createTestResultFee($payload['medical_registration_form_id'], Common::convertPayloadToTestResultEntity($payload));
        if ($result->getException() != null) {
            return ExceptionHandler::CustomHandleException($result->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, null);
    }

    public function changeStatusPaymentFormToPaid(Request $request) {
        $payload = $request->only(Payload::ChangeStatusPaymentFormToPaidPayload);
        $validator = Validator::make($payload, Payload::ValidateChangeStatusPaymentFormToPaidPayload);
        if ($validator->fails()) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $result = $this->service->changeStatusPaymentMedicalFormToPaid(UtilCommon::convertKeysToCase(Constant::SNAKE_CASE, $payload)['medical_registration_form_id']);
        if ($result->getException() != null) {
            return ExceptionHandler::CustomHandleException($result->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, null);
    }
}