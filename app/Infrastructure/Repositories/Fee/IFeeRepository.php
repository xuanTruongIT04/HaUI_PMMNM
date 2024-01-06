<?php

namespace App\Infrastructure\Repositories\Fee;

use App\Models\Fee;
use App\UseCase\DataCommonFormatter;

interface IFeeRepository {
    public function createFee(Fee $data): DataCommonFormatter;
    public function changeStatusFee(int $feeId, int $statusId): DataCommonFormatter;
    public function getFeeMedicalFormByType(int $medicalFormId, string $type): DataCommonFormatter;
}