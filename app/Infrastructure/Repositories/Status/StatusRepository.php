<?php

namespace App\Infrastructure\Repositories\Status;

use App\Exceptions\CustomExceptionHandler;
use App\Models\Status;
use App\UseCase\DataCommonFormatter;
use Exception;

class StatusRepository implements IStatusRepository {

    public function getAllStatusByType(string $type): DataCommonFormatter
    {
        try {
            $data = Status::where('type', $type)->get();
        } catch(Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return new DataCommonFormatter(null, $data);
    }

    public function getStatusByCode(string $code): DataCommonFormatter
    {
        try {
            $data = Status::where('code', $code)->first();
            if ($data == null) {
                return new DataCommonFormatter(CustomExceptionHandler::badRequest(), null);
            }
        } catch(Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return new DataCommonFormatter(null, $data);
    }
}