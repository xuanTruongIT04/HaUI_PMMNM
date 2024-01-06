<?php

namespace App\UseCase\MedicalRegistrationForm;

use App\Config\Constant;
use App\Exceptions\CustomExceptionHandler;
use App\Infrastructure\Define\Category;
use App\Infrastructure\Define\Status;
use App\Infrastructure\Repositories\Category\ICategoryRepository;
use App\Infrastructure\Repositories\Fee\IFeeRepository;
use App\Infrastructure\Repositories\MedicalRegistrationForm\IMedicalRegistrationFormRepository;
use App\Infrastructure\Repositories\Patient\IPatientRepository;
use App\Infrastructure\Repositories\Status\IStatusRepository;
use App\Infrastructure\Repositories\User\IUserRepository;
use App\Models\Fee;
use App\Models\MedicalRegistrationForm;
use App\UseCase\DataCommonFormatter;
use App\Util\Common;

class MedicalRegistrationFormService implements MedicalRegistrationFormUseCase {

    private IPatientRepository $patientRepo;
    private ICategoryRepository $categoryRepo;
    private IUserRepository $userRepo;
    private IMedicalRegistrationFormRepository $medicalFormRepo;
    private IStatusRepository $statusRepo;
    private IFeeRepository $feeRepo;

    public function __construct(IPatientRepository $patientRepo, ICategoryRepository $categoryRepo, IUserRepository $userRepo, IMedicalRegistrationFormRepository $medicalFormRepo, IStatusRepository $statusRepo, IFeeRepository $feeRepo)
    {
        $this->patientRepo = $patientRepo;
        $this->categoryRepo = $categoryRepo;
        $this->userRepo = $userRepo;
        $this->medicalFormRepo = $medicalFormRepo;
        $this->statusRepo = $statusRepo;
        $this->feeRepo = $feeRepo;
    }

    public function createMedicalRegistrationForm(array $data): DataCommonFormatter
    {
        $data = Common::convertKeysToCase(Constant::SNAKE_CASE, $data);
        //Check patient
        $patient = $this->patientRepo->getPatientById($data['patient_id']);
        if ($patient->getException() != null) {
            return new DataCommonFormatter($patient->getException(), null);
        }

        //Check user
        $doctor = $this->userRepo->findById($data['user_id']);
        if ($doctor->getException() != null) {
            return new DataCommonFormatter($doctor->getException(), null);
        }

        //Check category
        $category = $this->categoryRepo->findById($data['category_id']);
        if ($category->getException() != null) {
            return new DataCommonFormatter($category->getException(), null);
        }

        //Get default status medical registration form 
        $statusDefault = $this->statusRepo->getStatusByCode(Status::WAITING_FOR_HEALTH_CHECK);
        if ($statusDefault->getException() != null) {
            return new DataCommonFormatter($statusDefault->getException(), null);
        }

        $medicalRegistrationForm = new MedicalRegistrationForm();
        $medicalRegistrationForm->code = Constant::DEFAULT_CODE;
        $medicalRegistrationForm->status_id = $statusDefault->getData()->id;
        $medicalRegistrationForm->fill($data);

        $result = $this->medicalFormRepo->createMedicalRegistrationForm($medicalRegistrationForm);
        if ($result->getException() != null) {
            return new DataCommonFormatter($result->getException(), null);
        }

        //Create fee
        $statusUnpaid = $this->statusRepo->getStatusByCode(Status::UNPAID);
        $fee = new Fee();
        $fee->medical_registration_form_id = $result->getData()->id;
        $fee->status_id = $statusUnpaid->getData()->id;
        $fee->type = Category::TEST_RESULT;

        return $this->feeRepo->createFee($fee);
    }

    public function getListMedicalRegistrationForm(int $page, int $pageSize, string $keyword, string $sortBy, string $sortType): DataCommonFormatter
    {
        return $this->medicalFormRepo->getListMedicalRegistrationForm($page, $pageSize, $keyword, $sortBy, $sortType);
    }
    
    public function countAllMedicalRegistrationForm(string $keyword): int
    {
        return $this->medicalFormRepo->countAllMedicalRegistrationForm($keyword);
    }

    public function updateStatusMedicalForm(int $id, string $statusCode): DataCommonFormatter
    {
        //Get master data status
        $status = $this->statusRepo->getStatusByCode($statusCode);
        if ($status->getException() != null) {
            return new DataCommonFormatter($status->getException(), null);
        }

        return $this->medicalFormRepo->updateStatusMedicalForm($id, $status->getData()->id);
    }

    public function updateMedicalRegistrationForm(array $data): DataCommonFormatter {
        $medicalForm = $this->medicalFormRepo->getMedicalFormById($data['id']);
        if ($medicalForm->getException() != null) {
            return new DataCommonFormatter($medicalForm->getException(), null);
        }

        $statusWaiting = $this->statusRepo->getStatusByCode(Status::WAITING_FOR_HEALTH_CHECK);
        if ($statusWaiting->getException() != null) {
            return new DataCommonFormatter($statusWaiting->getException(), null);
        }

        $statusChecking = $this->statusRepo->getStatusByCode(Status::HEALTH_CHECKING);
        if ($statusChecking->getException() != null) {
            return new DataCommonFormatter($statusChecking->getException(), null);
        }

        if ($medicalForm->getData()->status_id != $statusWaiting->getData()->id && $medicalForm->getData()->status_id != $statusChecking->getData()->id) {
            return new DataCommonFormatter(CustomExceptionHandler::badRequest(), null);
        }

        $medicalFormEntity = $medicalForm->getData();
        $medicalFormEntity->day_of_examination = $data['day_of_examination'];
        $medicalFormEntity->category_id = $data['category_id'];
        $medicalFormEntity->user_id = $data['user_id'];
        $medicalFormEntity->reason = $data['reason'];
        
        return $this->medicalFormRepo->updateMedicalRegistrationForm($medicalFormEntity);
    }

    public function getListMedicalFormOfDoctor(int $userId, int $page, int $size, string $keyword, string $sortBy, string $sortType): DataCommonFormatter
    {
        return $this->medicalFormRepo->getMedicalFormByDoctor($userId, $page, $size, $keyword, $sortBy, $sortType);
    }

    public function countAllMedicalFormOfDoctor(int $userId, string $keyword): int
    {
        return $this->medicalFormRepo->countAllMedicalRegistrationFormOfDoctor($userId, $keyword);
    }

    public function getListMedicalFormCompleteOfPatient(int $patientId): DataCommonFormatter
    {
        $statusComplete = $this->statusRepo->getStatusByCode(Status::COMPLETE_HEALTH_CHECK);
        if ($statusComplete->getException() != null) {
            return new DataCommonFormatter($statusComplete->getException(), null);
        }

        $results = $this->medicalFormRepo->getListMedicalFormOfPatient($patientId, $statusComplete->getData()->id);
        if ($results->getException() != null) {
            return new DataCommonFormatter($results->getException(), null);
        }

        return new DataCommonFormatter(null, $results->getData());
    }
}