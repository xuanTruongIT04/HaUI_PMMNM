<?php

namespace App\Infrastructure\Repositories\Status;

use App\UseCase\DataCommonFormatter;

interface IStatusRepository {

    public function getAllStatusByType(string $type): DataCommonFormatter;
    public function getStatusByCode(string $code): DataCommonFormatter;
}