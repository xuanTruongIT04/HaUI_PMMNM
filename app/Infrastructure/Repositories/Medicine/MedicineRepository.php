<?php

namespace App\Infrastructure\Repositories\Medicine;

use App\Exceptions\CustomExceptionHandler;
use App\Models\Medicine;
use App\UseCase\DataCommonFormatter;
use App\Util\Pagination;
use Exception;

class MedicineRepository implements IMedicineRepository
{
    public function getAllMedicines(string $keyword, int $page, int $size, string $sortBy, string $sortType): DataCommonFormatter
    {
        try {
            $query = Medicine::query();
            $filterColumn = [];
            if (! empty($keyword) && ! empty($filterColumn)) {
                $query->where($filterColumn[0], $keyword);
            }
            $query->orderBy($sortBy, $sortType);
            $offset = Pagination::calculateOffset($page, $size);
            $query->offset($offset);
            $query->limit($size);

            return new DataCommonFormatter(null, $query->get());
        } catch (Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }
    }

    public function CountAllMedicines(string $keyword): int
    {
        try {
            $query = Medicine::query();
            $filterColumn = [];
            if (! empty($keyword) && ! empty($filterColumn)) {
                $query->where($filterColumn[0], $keyword);
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $query->count();
    }

    public function getMedicineById(int $id): DataCommonFormatter
    {
        try {
            $data = Medicine::find($id);
            if ($data == null) {
                return new DataCommonFormatter(CustomExceptionHandler::badRequest(), null);
            }

            return new DataCommonFormatter(null, $data);
        } catch (Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }
    }

    public function createMedicine(Medicine $data): DataCommonFormatter
    {
        try {
            $medicine = Medicine::where('code', $data->code)
                ->first();
            if ($medicine != null) {
                return new DataCommonFormatter(CustomExceptionHandler::badRequest(), null);
            }
            $data->save();

        } catch (Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return new DataCommonFormatter(null, $data);
    }

    public function deleteMedicineById(int $id): DataCommonFormatter
    {
        try {
            $medicine = Medicine::find($id);
            if ($medicine == null) {
                return new DataCommonFormatter(CustomExceptionHandler::badRequest(), null);
            }
            $medicine->delete();

            return new DataCommonFormatter(null, $medicine);
        } catch (Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }
    }

    public function updateMedicine(Medicine $data): DataCommonFormatter
    {
        try {
            $data->save();
        } catch (Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return new DataCommonFormatter(null, $data);

    }
}
