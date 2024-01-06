<?php

namespace App\Infrastructure\Repositories\Patient;

use App\Models\Patient;
use App\UseCase\DataCommonFormatter;

interface IPatientRepository
{
    public function getAllPatients(string $keyword, int $page, int $size, string $sortBy, string $sortType): DataCommonFormatter;

    public function CountAllPatients(string $keyword): int;

    public function countPatients(string $keyword): int;

    public function getPatientById(int $id): DataCommonFormatter;
    
    public function getPatientLatest(): DataCommonFormatter;

    public function createPatient(Patient $data): DataCommonFormatter;

    public function deletePatientById(int $id): DataCommonFormatter;

    public function updatePatient(Patient $data): DataCommonFormatter;

    public function searchPatients(string $keyword, int $page, int $size, string $sortBy, string $sortType): DataCommonFormatter;

    public function getListMedicalRecordIdOfPatient(int $patientId);
}
