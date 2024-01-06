<?php

namespace App\Http\Controllers\Medicine;

use App\Config\Constant;
use App\Config\Message;
use App\Exceptions\CustomExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Payload\Medicine\Payload;
use App\Http\Presenter\Response;
use App\UseCase\Medicine\MedicineUseCase;
use App\Util\Common as UtilCommon;
use App\Util\ExceptionHandler;
use App\Util\Pagination;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Validator;

class MedicineController extends Controller
{
    private MedicineUseCase $service;

    public function __construct(MedicineUseCase $service)
    {
        $this->service = $service;
    }

    public function getAllMedicines(Request $request)
    {
        $pagination = new Pagination($request);
        $results = $this->service->getAllMedicines(
            $pagination->getKeyWord(),
            $pagination->getPage(),
            $pagination->getPageSize(),
            $pagination->getSortBy(),
            $pagination->getSortType()
        );

        if ($results->getException() != null) {
            return ExceptionHandler::CustomHandleException($results->getException());
        }

        $count = $this->service->CountAllMedicines($pagination->getKeyWord());
        $pagination->setRecordCount($count);
        $pagination->setDisplayRecord($results->getData()->count());

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, Common::convertToListMedicinePagination($pagination, $results->getData()));
    }

    public function getMedicineById(Request $request)
    {
        $id = $request->query('medicineId');
        $idInt = intval($id);
        if ($idInt == 0) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $results = $this->service->getMedicineById($idInt);
        if ($results->getException() != null) {
            return ExceptionHandler::CustomHandleException($results->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, $results->getData());
    }

    public function createNewMedicine(Request $request)
    {
        $payload = $request->only(Payload::MedicinePayload);
        $validator = Validator::make($payload, Payload::MedicinePayload);
        if ($validator->fails()) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $results = $this->service->createMedicine(Common::convertMedicinePayloadToEntity($payload));
        if ($results->getException() != null) {
            return ExceptionHandler::CustomHandleException($results->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, $results->getData());
    }

    public function deleteMedicine(Request $request)
    {
        $id = $request->query('medicineId');
        $idInt = intval($id);
        if ($idInt == 0) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $results = $this->service->deleteMedicineById($idInt);
        if ($results->getException() != null) {
            return ExceptionHandler::CustomHandleException($results->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, null);
    }

    public function updateMedicine(Request $request)
    {
        $payload = $request->only(Payload::UpdateMedicine);
        $validator = Validator::make($payload, Payload::ValidatUpdateMedicinePayload);
        if ($validator->fails()) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::badRequest());
        }

        $results = $this->service->updateMedicine(UtilCommon::convertKeysToCase(Constant::SNAKE_CASE, $payload));
        if ($results->getException() != null) {
            return ExceptionHandler::CustomHandleException($results->getException());
        }

        return Response::BaseResponse(HttpResponse::HTTP_OK, Message::SUCCESS, null);
    }
}
