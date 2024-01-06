<?php

namespace App\UseCase\Master;

use App\UseCase\DataCommonFormatter;

interface MasterUseCase {

    public function getAllStatusByType(string $type): DataCommonFormatter;
}