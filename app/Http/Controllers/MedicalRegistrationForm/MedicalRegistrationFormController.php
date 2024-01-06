<?php

namespace App\Http\Controllers\MedicalRegistrationForm;

use App\Config\Constant;
use App\Config\Message;
use App\Exceptions\CustomExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Payload\MedicalRegistrationForm\Payload;
use App\Http\Presenter\Response;
use App\UseCase\MedicalRegistrationForm\MedicalRegistrationFormUseCase;
use App\Util\ExceptionHandler;
use App\Util\Common as UtilCommon;
use App\Util\Pagination;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Validator;

class MedicalRegistrationFormController extends Controller {

    private MedicalRegistrationFormUseCase $service;

    public function __construct(MedicalRegistrationFormUseCase $service)
    {
        $this->service = $service;
    }

    public function createMedicalRegistrationForm(Request $request) {
        $payload = $request->only(Payload::CreateMedicalRegistrationFormPayload);
        $validator = Validator::make($payload, Payload::ValidateCreateMedicalFormPayload);
        if ($validator->fails()) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $results = $this->service->createMedicalRegistrationForm($payload);
        if ($results->getException() != null) {
            return ExceptionHandler::CustomHandleException($results->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, null);
    }

    public function getListMedicalRegistrationForms(Request $request) {
        $paginationParam = new Pagination($request);

        $results = $this->service->getListMedicalRegistrationForm(
            $paginationParam->getPage(),
            $paginationParam->getPageSize(),
            $paginationParam->getKeyWord(),
            $paginationParam->getSortBy(),
            $paginationParam->getSortType()
        );

        if ($results->getException() != null) {
            return ExceptionHandler::CustomHandleException($results->getException());
        }

        $count = $this->service->countAllMedicalRegistrationForm($paginationParam->getKeyWord());
        $paginationParam->setRecordCount($count);
        $paginationParam->setDisplayRecord($results->getData()->count());
        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, Common::convertToListMedicalRegistrationFormPagination($paginationParam, $results->getData()));        
    }

    public function updateStatusMedicalForm(Request $request) {
        $payload = $request->only(Payload::UpdateStatusMedicalFormPayload);
        $validator = Validator::make($payload, Payload::ValidateUpdateStatusMedicalFormPayload);
        if ($validator->fails()) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $results = $this->service->updateStatusMedicalForm($payload['id'], $payload['statusCode']);
        if ($results->getException() != null) {
            return ExceptionHandler::CustomHandleException($results->getException(), null);
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, null);
    }

    public function updateMedicalResgistrationForm(Request $request) {
        $payload = $request->only(Payload::UpdateMedicalResgistrationForm);
        $validator = Validator::make($payload, Payload::UpdateStatusMedicalFormPayload);
        if ($validator->fails()) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $results = $this->service->updateMedicalRegistrationForm(UtilCommon::convertKeysToCase(Constant::SNAKE_CASE, $payload));
        if ($results->getException() != null) {
            return ExceptionHandler::CustomHandleException($results->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, null);
    }

    public function getListMedicalFormOfDoctor(Request $request) {
        $userId = auth()->user()->id;

        $paginationParam = new Pagination($request);
        
        $results = $this->service->getListMedicalFormOfDoctor($userId,
        $paginationParam->getPage(),
        $paginationParam->getPageSize(),
        $paginationParam->getKeyWord(),
        $paginationParam->getSortBy(),
        $paginationParam->getSortType());
        if ($results->getException() != null) {
            return ExceptionHandler::CustomHandleException($results->getException());
        }

        $count = $this->service->countAllMedicalFormOfDoctor($userId, $paginationParam->getKeyWord());
        $paginationParam->setRecordCount($count);
        $paginationParam->setDisplayRecord($paginationParam->getPageSize());
        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, Common::convertToListMedicalRegistrationFormPagination($paginationParam, $results->getData()));
    }

    public function getListMedicalFormCompleteOfPatient(Request $request) {
        $patientId = $request->query("patientId");
        $patientIdInt = intval($patientId);
        if ($patientIdInt == 0) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $results = $this->service->getListMedicalFormCompleteOfPatient($patientIdInt);
        if ($results->getException() != null) {
            return ExceptionHandler::CustomHandleException($results->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, Common::convertToListMedicalRegistrationForm($results->getData()));
    }
}