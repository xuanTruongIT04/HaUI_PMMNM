<?php

namespace App\UseCase\TestResult;

use App\Models\TestResult;
use App\UseCase\DataCommonFormatter;

interface TestResultUseCase {
    public function createTestResultFee(int $medicalFormId, TestResult $testResult): DataCommonFormatter;
}