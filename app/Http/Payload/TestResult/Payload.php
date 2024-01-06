<?php

namespace App\Http\Payload\TestResult;

class Payload
{
    const CreateTestResultPayload = [
        'medicalRegistrationFormId',
        'medicalHistory',
        'clinicalExamination',
        'preliminaryExamination',
        'diagnostic',
    ];

    const ValidateCreateTestResultPayload = [
        'medicalRegistrationFormId' => 'required',
        'medicalHistory' => 'required',
        'clinicalExamination' => 'required',
        'preliminaryExamination' => 'required',
        'diagnostic' => 'required',
    ];

    const ChangeStatusPaymentFormToPaidPayload = [
        'medicalRegistrationFormId',
    ];

    const ValidateChangeStatusPaymentFormToPaidPayload = [
        'medicalRegistrationFormId' => 'required',
    ];
}
