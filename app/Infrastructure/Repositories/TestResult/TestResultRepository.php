<?php

namespace App\Infrastructure\Repositories\TestResult;

use App\Exceptions\CustomExceptionHandler;
use App\Models\TestResult;
use App\UseCase\DataCommonFormatter;
use Exception;

class TestResultRepository implements ITestResultRepository {

    public function createTestResult(TestResult $data): DataCommonFormatter {
        try {
            $data->save();
        } catch(Exception $e) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return new DataCommonFormatter(null, $data);
    }
}