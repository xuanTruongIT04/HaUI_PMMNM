<?php

namespace App\UseCase\TestResult;

use App\Infrastructure\Define\Category;
use App\Infrastructure\Define\Status;
use App\Infrastructure\Repositories\Fee\IFeeRepository;
use App\Infrastructure\Repositories\MedicalRegistrationForm\IMedicalRegistrationFormRepository;
use App\Infrastructure\Repositories\Status\IStatusRepository;
use App\Infrastructure\Repositories\TestResult\ITestResultRepository;
use App\Models\Fee;
use App\Models\MedicalRegistrationForm;
use App\Models\TestResult;
use App\UseCase\DataCommonFormatter;

class TestResultService implements TestResultUseCase {

    private ITestResultRepository $testResultRepo;
    private IFeeRepository $feeRepo;
    private IMedicalRegistrationFormRepository $medicalFormRepo;
    private IStatusRepository $statusRepo;

    public function __construct(ITestResultRepository $testResultRepo, IFeeRepository $feeRepo, IMedicalRegistrationFormRepository $medicalFormRepo, IStatusRepository $statusRepo)
    {
        $this->testResultRepo = $testResultRepo;
        $this->feeRepo = $feeRepo;
        $this->medicalFormRepo = $medicalFormRepo;
        $this->statusRepo = $statusRepo;
    }

    public function createTestResultFee(int $medicalFormId, TestResult $testResult): DataCommonFormatter {
        $medicalForm = $this->medicalFormRepo->getMedicalFormById($medicalFormId);
        if ($medicalForm->getException() != null) {
            return new DataCommonFormatter($medicalForm->getException(), null);
        }

        //Status unpaid
        $statusUnpaid = $this->statusRepo->getStatusByCode(Status::UNPAID);
        if ($statusUnpaid->getException() != null) {
            return new DataCommonFormatter($statusUnpaid->getException(), null);
        }

        $feeId = null;
        foreach($medicalForm->getData()->fees as $fee) {
            if ($fee->type == Category::TEST_RESULT) {
                $feeId = $fee->id;
            }
        }
        $testResult->fee_id = $feeId;
        return $this->testResultRepo->createTestResult($testResult);
    }

    public function changeStatusPaymentMedicalFormToPaid(int $medicalFormId): DataCommonFormatter {
        $medicalForm = $this->medicalFormRepo->getMedicalFormById($medicalFormId);
        if ($medicalForm->getException() != null) {
            return new DataCommonFormatter($medicalForm->getException(), null);
        }

        //Status paid
        $statusPaid = $this->statusRepo->getStatusByCode(Status::PAID);
        if ($statusPaid->getException() != null) {
            return new DataCommonFormatter($statusPaid->getException(), null);
        }

        $feeTestResult = $this->feeRepo->getFeeMedicalFormByType($medicalFormId, Category::TEST_RESULT);
        if ($feeTestResult->getException() != null) {
            return new DataCommonFormatter($feeTestResult->getException(), null);
        }
        return $this->feeRepo->changeStatusFee($feeTestResult->getData()->id, $statusPaid->getData()->id);
    }
}