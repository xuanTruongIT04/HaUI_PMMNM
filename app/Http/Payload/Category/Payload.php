<?php

namespace App\Http\Payload\Category;

class Payload
{
    const CategoryPayload = [
        'code',
        'name',
        'type',
        'description',
        'cost',
    ];

    const ValidateCategoryPayload = [
        'code' => 'required',
        'name' => 'required',
        'type' => 'required',
        'description' => 'required',
        'cost' => 'required',
    ];

    const UpdateCategory = [
        'id',
        'name',
        'type',
        'description',
        'cost',
    ];

    const ValidatUpdateCategoryPayload = [
        'id' => 'required',
        'name' => 'required',
        'type' => 'required',
        'description' => 'required',
        'cost' => 'required',
    ];
}
