<?php

namespace App\UseCase\MedicalRegistrationForm;

use App\UseCase\DataCommonFormatter;

interface MedicalRegistrationFormUseCase {

    public function createMedicalRegistrationForm(array $data): DataCommonFormatter;
    public function getListMedicalRegistrationForm(int $page, int $pageSize, string $keyword, string $sortBy, string $sortType): DataCommonFormatter;
    public function countAllMedicalRegistrationForm(string $keyword): int;
    public function updateStatusMedicalForm(int $id, string $statusCode): DataCommonFormatter;
    public function updateMedicalRegistrationForm(array $data): DataCommonFormatter;
    public function getListMedicalFormOfDoctor(int $userId, int $page, int $size, string $keyword, string $sortBy, string $sortType): DataCommonFormatter;
    public function countAllMedicalFormOfDoctor(int $userId, string $keyword): int;
    public function getListMedicalFormCompleteOfPatient(int $patientId): DataCommonFormatter;
}