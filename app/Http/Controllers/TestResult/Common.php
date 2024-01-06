<?php

namespace App\Http\Controllers\TestResult;

use App\Models\TestResult;

class Common {

    public static function convertPayloadToTestResultEntity(array $payload) {
        $testResult = new TestResult();
        $testResult->medical_history = $payload['medical_history'];
        $testResult->clinical_examination = $payload['clinical_examination'];
        $testResult->preliminary_examination = $payload['preliminary_examination'];
        $testResult->diagnostic = $payload['diagnostic'];

        return $testResult;
    }
}