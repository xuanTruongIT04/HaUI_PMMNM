<?php

namespace App\UseCase\Patient;

use App\Exceptions\CustomExceptionHandler;
use App\Infrastructure\Repositories\MedicalRegistrationForm\IMedicalRegistrationFormRepository;
use App\Infrastructure\Repositories\Patient\IPatientRepository;
use App\Models\Patient;
use App\UseCase\DataCommonFormatter;

class PatientService implements PatientUseCase
{
    protected IPatientRepository $patientRepo;
    private IMedicalRegistrationFormRepository $medicalFormRepo;

    public function __construct(IPatientRepository $patientRepo, IMedicalRegistrationFormRepository $medicalFormRepo)
    {
        $this->patientRepo = $patientRepo;
        $this->medicalFormRepo = $medicalFormRepo;
    }

    public function getAllPatients(string $keyword, int $page, int $size, string $sortBy, string $sortType): DataCommonFormatter
    {
        return $this->patientRepo->getAllPatients($keyword, $page, $size, $sortBy, $sortType);
    }

    public function countAllPatients(string $keyword): int
    {
        return $this->patientRepo->countAllPatients($keyword);
    }

    public function countPatients(string $keyword): int
    {
        return $this->patientRepo->countPatients($keyword);
    }

    public function getPatientById(int $id): DataCommonFormatter
    {
        return $this->patientRepo->getPatientById($id);
    }

    public function getPatientLatest(): DataCommonFormatter
    {
        return $this->patientRepo->getPatientLatest();
    }

    public function createPatient(Patient $patient): DataCommonFormatter
    {
        return $this->patientRepo->createPatient($patient);
    }

    public function deletePatientById(int $id): DataCommonFormatter
    {
        $listMedicalFormId = $this->patientRepo->getListMedicalRecordIdOfPatient($id);
        $result = $this->medicalFormRepo->deleteMedicalFormByPatientId($listMedicalFormId->toArray());
        if (!$result) {
            return new DataCommonFormatter(CustomExceptionHandler::badRequest(), null);
        }

        return $this->patientRepo->deletePatientById($id);
    }

    public function updatePatient(array $data): DataCommonFormatter
    {
        $patient = $this->patientRepo->getPatientById($data['id']);
        if ($patient->getException() != null) {
            return new DataCommonFormatter($patient->getException(), null);
        }

        $patientUpdate = $patient->getData();
        $patientUpdate->name = $data['name'];
        $patientUpdate->phone_number = $data['phone_number'];
        $patientUpdate->address = $data['address'];
        $patientUpdate->gender = $data['gender'];
        $patientUpdate->insurance_number = $data['insurance_number'];

        return $this->patientRepo->updatePatient($patientUpdate);
    }

    public function searchPatients(string $keyword, int $page, int $size, string $sortBy, string $sortType): DataCommonFormatter
    {
        return $this->patientRepo->searchPatients($keyword, $page, $size, $sortBy, $sortType);
    }
}
