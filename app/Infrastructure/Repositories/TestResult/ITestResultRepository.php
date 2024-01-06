<?php

namespace App\Infrastructure\Repositories\TestResult;

use App\Models\TestResult;
use App\UseCase\DataCommonFormatter;

interface ITestResultRepository {
    public function createTestResult(TestResult $data): DataCommonFormatter;
}