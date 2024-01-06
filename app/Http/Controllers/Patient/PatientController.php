<?php

namespace App\Http\Controllers\Patient;

use App\Config\Constant;
use App\Config\Message;
use App\Exceptions\CustomExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Payload\Patient\Payload;
use App\Http\Presenter\Response;
use App\UseCase\Patient\PatientUseCase;
use App\Util\Common as UtilCommon;
use App\Util\ExceptionHandler;
use App\Util\Pagination;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public PatientUseCase $service;

    public function __construct(PatientUseCase $service)
    {
        $this->service = $service;
    }

    public function getAllPatient(Request $request)
    {
        $paginationParams = new Pagination($request);

        $patients = $this->service->getAllPatients(
            $paginationParams->getKeyWord(),
            $paginationParams->getPage(),
            $paginationParams->getPageSize(),
            $paginationParams->getSortBy(),
            $paginationParams->getSortType()
        );

        if ($patients->getException() != null) {
            return ExceptionHandler::CustomHandleException($patients->getException());
        }

        $count = $this->service->countAllPatients($paginationParams->getKeyWord());
        $paginationParams->setRecordCount($count);
        $paginationParams->setDisplayRecord($patients->getData()->count());

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, Common::convertToListPatientPagination($paginationParams, $patients->getData()));
    }

    public function getPatientById(Request $request)
    {
        $id = $request->query('patientId');
        $idInt = intval($id);
        if ($idInt == 0) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $data = $this->service->getPatientById($idInt);
        if ($data->getException() != null) {
            return ExceptionHandler::CustomHandleException($data->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, $data->getData());
    }

    public function getPatientLatest()
    {
        $data = $this->service->getPatientLatest();

        if ($data->getException() != null) {
            return ExceptionHandler::CustomHandleException($data->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, $data->getData());
    }

    public function createNewPatient(Request $request)
    {
        $payload = $request->only(Payload::PatientPayload);
        $validator = Validator::make($payload, Payload::ValidatePatientPayload);
        if ($validator->fails()) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $patient = Common::convertPatientPayloadToEntity($payload);
        $result = $this->service->createPatient($patient);
        if ($result->getException() != null) {
            return ExceptionHandler::CustomHandleException($result->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, $result->getData());
    }

    public function deletePatientById(Request $request)
    {
        $id = $request->query('patientId');
        $idInt = intval($id);
        if ($idInt == 0) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $result = $this->service->deletePatientById($idInt);
        if ($result->getException() != null) {
            return ExceptionHandler::CustomHandleException($result->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, $result->getData());
    }

    public function searchPatients(Request $request)
    {
        $paginationParams = new Pagination($request);

        $patients = $this->service->searchPatients(
            $paginationParams->getKeyWord(),
            $paginationParams->getPage(),
            $paginationParams->getPageSize(),
            $paginationParams->getSortBy(),
            $paginationParams->getSortType()
        );

        if ($patients->getException() != null) {
            return ExceptionHandler::CustomHandleException($patients->getException());
        }

        $count = $this->service->countPatients($paginationParams->getKeyWord());
        $paginationParams->setRecordCount($count);
        $paginationParams->setDisplayRecord($patients->getData()->count());

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, Common::convertToListPatientPagination($paginationParams, $patients->getData()));
    }

    public function updatePatient(Request $request) {
        $payload = $request->only(Payload::UpdatePatientPayload);
        $validator = Validator::make($payload, Payload::ValidateUpdatePatientPayload);
        if ($validator->fails()) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $results = $this->service->updatePatient(UtilCommon::convertKeysToCase(Constant::SNAKE_CASE, $payload));
        if ($results->getException() != null) {
            return ExceptionHandler::CustomHandleException($results->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, $results->getData());
    }
}
