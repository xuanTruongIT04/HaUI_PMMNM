<?php

namespace App\Infrastructure\Repositories\Medicine;

use App\Models\Medicine;
use App\UseCase\DataCommonFormatter;

interface IMedicineRepository
{
    public function getAllMedicines(string $keyword, int $page, int $size, string $sortBy, string $sortType): DataCommonFormatter;

    public function CountAllMedicines(string $keyword): int;

    public function getMedicineById(int $id): DataCommonFormatter;

    public function createMedicine(Medicine $data): DataCommonFormatter;

    public function deleteMedicineById(int $id): DataCommonFormatter;

    public function updateMedicine(Medicine $data): DataCommonFormatter;
}
