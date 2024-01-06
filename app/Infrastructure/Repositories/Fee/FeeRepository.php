<?php

namespace App\Infrastructure\Repositories\Fee;

use App\Exceptions\CustomExceptionHandler;
use App\Models\Fee;
use App\UseCase\DataCommonFormatter;
use App\Util\ExceptionHandler;
use Exception;

class FeeRepository implements IFeeRepository {
    public function createFee(Fee $data): DataCommonFormatter {
        try {
            $data->save();
        } catch(Exception $e) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return new DataCommonFormatter(null, $data);
    }

    public function changeStatusFee(int $feeId, int $statusId): DataCommonFormatter {
        try {
            $affectedRows = Fee::where("id", "=", $feeId)
                        ->update(['status_id' => $statusId]);
            if ($affectedRows == 0) {
                return new DataCommonFormatter(CustomExceptionHandler::badRequest(), null);
            }
        } catch(Exception $e) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }
        return new DataCommonFormatter(null, null);
    }

    public function getFeeMedicalFormByType(int $medicalFormId, string $type): DataCommonFormatter {
        try {
            $fee = Fee::where("medical_registration_form_id", "=", $medicalFormId)
                        ->where("type", "=", $type)
                        ->first();
            if ($fee == null) {
                return new DataCommonFormatter(CustomExceptionHandler::badRequest(), null);
            }
        } catch(Exception $e) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }
        return new DataCommonFormatter(null, $fee);
    } 
}