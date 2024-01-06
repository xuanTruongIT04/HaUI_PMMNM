<?php

namespace App\UseCase\Patient;

use App\Models\Patient;
use App\UseCase\DataCommonFormatter;

interface PatientUseCase
{
    public function getAllPatients(string $keyword, int $page, int $size, string $sortBy, string $sortType): DataCommonFormatter;

    public function countAllPatients(string $keyword): int;

    public function countPatients(string $keyword): int;

    public function getPatientById(int $id): DataCommonFormatter;
    
    public function getPatientLatest(): DataCommonFormatter;

    public function createPatient(Patient $patient): DataCommonFormatter;

    public function deletePatientById(int $id): DataCommonFormatter;

    public function updatePatient(array $data): DataCommonFormatter;

    public function searchPatients(string $keyword, int $page, int $size, string $sortBy, string $sortType): DataCommonFormatter;
}
