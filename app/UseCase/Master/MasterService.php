<?php

namespace App\UseCase\Master;

use App\Infrastructure\Repositories\Status\IStatusRepository;
use App\UseCase\DataCommonFormatter;

class MasterService implements MasterUseCase {

    private IStatusRepository $statusRepo;

    public function __construct(IStatusRepository $statusRepo)
    {
        $this->statusRepo = $statusRepo;
    }

    public function getAllStatusByType(string $type): DataCommonFormatter
    {
        return $this->statusRepo->getAllStatusByType($type);
    }
}