<?php

namespace App\Infrastructure\Repositories\MedicalRegistrationForm;

use App\Exceptions\CustomExceptionHandler;
use App\Infrastructure\Define\Category;
use App\Models\MedicalRegistrationForm;
use App\UseCase\DataCommonFormatter;
use App\Util\Pagination;
use Exception;

class MedicalRegistrationFormRepository implements IMedicalRegistrationFormRepository {

    public function createMedicalRegistrationForm(MedicalRegistrationForm $data): DataCommonFormatter
    {
        try {
           $data->save();
        } catch(Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return new DataCommonFormatter(null, $data);
    }

    public function getListMedicalRegistrationForm(int $page, int $pageSize, string $keyword, string $sortBy, string $sortType): DataCommonFormatter {
        try {
            $query = MedicalRegistrationForm::select('medical_registration_forms.*')->with(['doctor', 'patient', 'category', 'status', 'fees']);
            $filterColumn = [];
            if (!empty($keyword) && !empty($filterColumn)) {
                $query->where($filterColumn[0], $keyword);
            }
            $query->orderBy($sortBy, $sortType);
            $offset = Pagination::calculateOffset($page, $pageSize);
            $query->offset($offset);
            $query->limit($pageSize);
            return new DataCommonFormatter(null, $query->get());
        } catch(Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }
    }

    public function countAllMedicalRegistrationForm(string $keyword): int {
        try {
            $query = MedicalRegistrationForm::query();
            $filterColumn = [];
            if (!empty($keyword) && !empty($filterColumn)) {
                $query->where($filterColumn[0], $keyword);
            }
            $filterColumn = [];
            if (!empty($keyword) && !empty($filterColumn)) {
                $query->where($filterColumn[0], $keyword);
            }
        } catch(Exception $e) {
            throw new Exception($e);
        }

        return $query->count();
    }

    public function updateStatusMedicalForm(int $id, int $statusId): DataCommonFormatter
    {
        try {
            MedicalRegistrationForm::where('id', $id)->update(array('status_id' => $statusId));
        } catch (Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return new DataCommonFormatter(null, null);
    }

    public function updateMedicalRegistrationForm(MedicalRegistrationForm $data): DataCommonFormatter {
        try {
            $data->save();
        } catch (Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return new DataCommonFormatter(null, $data);
    }

    public function getMedicalFormById(int $id): DataCommonFormatter
    {
        try {
            $query = MedicalRegistrationForm::find($id);
            if ($query == null) {
                return new DataCommonFormatter(CustomExceptionHandler::badRequest(), null);
            }
        } catch (Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return new DataCommonFormatter(null, $query);
    }

    public function getMedicalFormByDoctor(int $userId, int $page, int $size, string $keyword, string $sortBy, string $sortType): DataCommonFormatter {
        try {
            $query = MedicalRegistrationForm::with(['doctor', 'patient', 'category', 'status']);
            $filterColumn = [];
            if (!empty($keyword) && !empty($filterColumn)) {
                $query->where($filterColumn[0], $keyword);
            }
            $filterColumn = [];
            if (!empty($keyword) && !empty($filterColumn)) {
                $query->where($filterColumn[0], $keyword);
            }
            $query->where("user_id", "=", $userId);
            $query->orderBy($sortBy, $sortType);
            $offset = Pagination::calculateOffset($page, $size);
            $query->offset($offset);
            $query->limit($size);

        } catch(Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return new DataCommonFormatter(null, $query->get());
    }

    public function countAllMedicalRegistrationFormOfDoctor(int $userId, string $keyword): int {
        try {
            $query = MedicalRegistrationForm::query();
            $filterColumn = [];
            if (!empty($keyword) && !empty($filterColumn)) {
                $query->where($filterColumn[0], $keyword);
            }
            $filterColumn = [];
            if (!empty($keyword) && !empty($filterColumn)) {
                $query->where($filterColumn[0], $keyword);
            }
            $query->where("user_id", "=", $userId);
        } catch(Exception $e) {
            throw new Exception($e);
        }

        return $query->count();
    }

    public function getListMedicalFormOfPatient(int $patientId, int $statusId): DataCommonFormatter {
        try {
            $query = MedicalRegistrationForm::with(['doctor', 'patient', 'category', 'status']);
            $query->where("patient_id", "=", $patientId);
            $query->where("status_id", "=", $statusId);
            $query->orderBy("created_at", "DESC");
        } catch(Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return new DataCommonFormatter(null, $query->get());
    }

    public function deleteMedicalFormByPatientId(array $listId): bool {
        try {
            $deleteRecords = MedicalRegistrationForm::whereIn('id', $listId)->delete();
        } catch(Exception $e) {
            return false;
        }

        return true;
    }
}