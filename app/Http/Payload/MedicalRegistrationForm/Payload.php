<?php

namespace App\Http\Payload\MedicalRegistrationForm;

class Payload {

    const CreateMedicalRegistrationFormPayload = [
        'patientId',
        'userId',
        'categoryId',
        'dayOfExamination',
        'reason'
    ];

    const ValidateCreateMedicalFormPayload = [
        'patientId' => 'required',
        'userId' => 'required',
        'categoryId' => 'required',
        'dayOfExamination' => 'required',
        'reason' => 'required'
    ];

    const UpdateStatusMedicalFormPayload = [
        'id',
        'statusCode',
    ];

    const ValidateUpdateStatusMedicalFormPayload = [
        'id' => 'required',
        'statusCode' => 'required'
    ];

    const UpdateMedicalResgistrationForm = [
        'id',
        'dayOfExamination',
        'categoryId',
        'userId',
        'reason'
    ];

    const ValidateUpdateMedicalResgistrationForm = [
        'id' => 'required',
        'dayOfExamination' => 'required',
        'categoryId' => 'required',
        'userId' => 'required',
        "reason" => 'required'
    ];
}