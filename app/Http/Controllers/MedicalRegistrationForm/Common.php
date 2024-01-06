<?php

namespace App\Http\Controllers\MedicalRegistrationForm;

use App\Infrastructure\Define\Category;
use App\Models\User;
use App\Util\Pagination;
use Illuminate\Database\Eloquent\Collection;

class Common {

    public static function convertToListMedicalRegistrationFormPagination(Pagination $pagination, Collection $listData) {
        $listDataConvert = $listData->map(function($item) {
            $doctor = $item->doctor;
            $patient = $item->patient;
            $category = $item->category;
            $fees = $item->fees;
            info($item);
            $status = $item->status;
            $statusPayment = null;
            foreach($fees as $fee) {
                if ($fee->type == Category::TEST_RESULT) {
                    $statusPayment = $fee->status->name;
                }
            }
            return [
                'id' => $item->id,
                'code' => $item->code,
                'dayOfExamination' => $item->day_of_examination,
                'reason' => $item->reason,
                'doctor' => [
                    'id' => $doctor->id,
                    'name' => $doctor->name,
                    'phoneNumber' => $doctor->phone_number,
                    'address' => $doctor->address,
                    'email' => $doctor->email,
                    'role' => $doctor->role
                ],
                'patient' => [
                    'id' => $patient->id,
                    'patientGroup' => $patient->patient_group,
                    'name' => $patient->name,
                    'gender' => $patient->gender,
                    'birthday' => $patient->birthday,
                    'phoneNumber' => $patient->phone_number,
                    'address' => $patient->address,
                    'insuranceNumber'=> $patient->insurance_number
                ],
                'category' => [
                    'id' => $category->id,
                    'code' => $category->code,
                    'name' => $category->name,
                    'type' => $category->type,
                    'description' => $category->description,
                    'cost' => $category->cost,
                ],
                'status' => [
                    'id' => $status->id,
                    'code' => $status->code,
                    'type' => $status->type,
                    'description' => $status->description,
                ],
                'statusPayment' => $statusPayment,
            ];
        });

        $dataPaging = [
            'count' => $pagination->getRecordCount(),
            'numPages' => ceil($pagination->getRecordCount() / $pagination->getPageSize()),
            'displayRecord' => $pagination->getDisplayRecord(),
            'page' => $pagination->getPage()
        ];

        return [
            'results' => $listDataConvert,
            'pagination' => $dataPaging
        ];
    }

    public static function convertToListMedicalRegistrationForm(Collection $listData) {
        $listDataConvert = $listData->map(function($item) {
            $doctor = $item->doctor;
            $patient = $item->patient;
            $category = $item->category;
            info($item);
            $status = $item->status;
            return [
                'id' => $item->id,
                'code' => $item->code,
                'dayOfExamination' => $item->day_of_examination,
                'reason' => $item->reason,
                'doctor' => [
                    'id' => $doctor->id,
                    'name' => $doctor->name,
                    'phoneNumber' => $doctor->phone_number,
                    'address' => $doctor->address,
                    'email' => $doctor->email,
                    'role' => $doctor->role
                ],
                'patient' => [
                    'id' => $patient->id,
                    'patientGroup' => $patient->patient_group,
                    'name' => $patient->name,
                    'gender' => $patient->gender,
                    'birthday' => $patient->birthday,
                    'phoneNumber' => $patient->phone_number,
                    'address' => $patient->address,
                    'insuranceNumber'=> $patient->insurance_number
                ],
                'category' => [
                    'id' => $category->id,
                    'code' => $category->code,
                    'name' => $category->name,
                    'type' => $category->type,
                    'description' => $category->description,
                ],
                'status' => [
                    'id' => $status->id,
                    'code' => $status->code,
                    'type' => $status->type,
                    'description' => $status->description,
                ]
            ];
        });

        return [
            'results' => $listDataConvert,
        ];
    }

    

    public static function convertUserToPresenter(User $data) {
        return [
            'id' => $data->id,
            'name' => $data->name,
            'phoneNumber' => $data->phone_number,
            'address' => $data->address,
            'email' => $data->email,
            'role' => $data->role
        ];
    }

    
}