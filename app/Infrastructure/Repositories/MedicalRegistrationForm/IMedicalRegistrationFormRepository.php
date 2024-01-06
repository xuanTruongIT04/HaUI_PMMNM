<?php

namespace App\Infrastructure\Repositories\MedicalRegistrationForm;

use App\Models\MedicalRegistrationForm;
use App\UseCase\DataCommonFormatter;

interface IMedicalRegistrationFormRepository {

    public function createMedicalRegistrationForm(MedicalRegistrationForm $data): DataCommonFormatter;
    public function getListMedicalRegistrationForm(int $page, int $pageSize, string $keyword, string $sortBy, string $sortType): DataCommonFormatter;
    public function countAllMedicalRegistrationForm(string $keyword): int;
    public function updateStatusMedicalForm(int $id, int $statusId): DataCommonFormatter;
    public function updateMedicalRegistrationForm(MedicalRegistrationForm $data): DataCommonFormatter;
    public function getMedicalFormById(int $id): DataCommonFormatter;
    public function getMedicalFormByDoctor(int $userId, int $page, int $size, string $keyword, string $sortBy, string $sortType): DataCommonFormatter;
    public function countAllMedicalRegistrationFormOfDoctor(int $userId, string $keyword): int;
    public function getListMedicalFormOfPatient(int $patientId, int $statusId): DataCommonFormatter;
    public function deleteMedicalFormByPatientId(array $listId): bool;
}