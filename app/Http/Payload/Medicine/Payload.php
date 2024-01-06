<?php

namespace App\Http\Payload\Medicine;

class Payload
{
    const MedicinePayload = [
        'name',
        'code',
        'expiredDate',
        'manufacturedDate',
        'publisher',
        'instruction',
        'ingredient',
        'unit',
        'quantity',
        'price',
    ];

    const ValidateMedicinePayload = [
        'name' => 'required',
        'code' => 'required',
        'expiredDate' => 'required',
        'manufacturedDate' => 'required',
        'publisher' => 'required',
        'instruction' => 'required',
        'ingredient' => 'required',
        'unit' => 'required',
        'quantity' => 'required',
        'price' => 'required',
    ];

    const UpdateMedicine = [
        'id',
        'name',
        'expiredDate',
        'publisher',
        'ingredient',
        'unit',
        'quantity',
        'price',
    ];

    const ValidatUpdateMedicinePayload = [
        'id' => 'required',
        'name' => 'required',
        'expiredDate' => 'required',
        'publisher' => 'required',
        'ingredient' => 'required',
        'unit' => 'required',
        'quantity' => 'required',
        'price' => 'required',
    ];
}
