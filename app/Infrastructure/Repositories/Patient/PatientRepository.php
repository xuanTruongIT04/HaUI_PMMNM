<?php

namespace App\Infrastructure\Repositories\Patient;

use App\Config\Constant;
use App\Exceptions\CustomExceptionHandler;
use App\Models\Patient;
use App\UseCase\DataCommonFormatter;
use App\Util\Pagination;
use Exception;

class PatientRepository implements IPatientRepository
{
    public function getAllPatients(string $keyword, int $page, int $size, string $sortBy, string $sortType): DataCommonFormatter
    {
        try {
            $query = Patient::query();
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

    public function CountAllPatients(string $keyword): int
    {
        try {
            $query = Patient::query();
            $filterColumn = [];
            if (! empty($keyword) && ! empty($filterColumn)) {
                $query->where($filterColumn[0], $keyword);
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $query->count();
    }

    public function countPatients(string $keyword): int
    {
        try {
            $query = Patient::query();
            $filterColumn = ['name'];
            if (! empty($keyword) && ! empty($filterColumn)) {
                $query->where($filterColumn[0], 'like', '%'.$keyword.'%');
            }

        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $query->count();
    }

    public function getPatientById(int $id): DataCommonFormatter
    {
        try {
            $data = Patient::find($id);
            if ($data == null) {
                return new DataCommonFormatter(CustomExceptionHandler::badRequest(), null);
            }

            return new DataCommonFormatter(null, $data);
        } catch (Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }
    }

    public function getPatientLatest(): DataCommonFormatter
    {
        try {
            $data = Patient::latest()->first();

            info(json_encode($data));
            if ($data == null) {
                return new DataCommonFormatter(CustomExceptionHandler::badRequest(), null);
            }

            return new DataCommonFormatter(null, $data);
        } catch (Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }
    }

    public function createPatient(Patient $data): DataCommonFormatter
    {
        try {
            $patient = Patient::where('phone_number', $data->phone_number)
                ->where('name', $data->name)
                ->first();
            if ($patient != null) {
                $data->patient_group = Constant::OLD_PATIENT;
                $patient->update($data->toArray());
            } else {
                $data->patient_group = Constant::NEW_PATIENT;
                $data->save();
            }

        } catch (Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return new DataCommonFormatter(null, $data);
    }

    public function deletePatientById(int $id): DataCommonFormatter
    {
        try {
            $patient = Patient::find($id);
            if ($patient == null) {
                return new DataCommonFormatter(CustomExceptionHandler::badRequest(), null);
            }
            $patient->delete();

            return new DataCommonFormatter(null, $patient);
        } catch (Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }
    }

    public function searchPatients(string $keyword, int $page, int $size, string $sortBy, string $sortType): DataCommonFormatter
    {
        try {
            $query = Patient::query();
            $filterColumn = ['name'];
            if (! empty($keyword) && ! empty($filterColumn)) {
                $query->where($filterColumn[0], 'like', '%'.$keyword.'%');
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

    public function updatePatient(Patient $data): DataCommonFormatter
    {
        try {
            $data->save();
        } catch(Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return new DataCommonFormatter(null, $data);
    }

    public function getListMedicalRecordIdOfPatient(int $patientId) {
        try {
            $result = Patient::join("medical_registration_forms", "patients.id", "=", "medical_registration_forms.patient_id")
                ->where("medical_registration_forms.patient_id", $patientId)
                ->pluck("medical_registration_forms.id");
        } catch (Exception $e) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return $result;
    }
}
