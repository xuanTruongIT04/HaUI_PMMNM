<?php

namespace App\Http\Controllers\Patient;

use App\Config\Constant;
use App\Models\Patient;
use App\Util\Common as UtilCommon;
use App\Util\Pagination;
use Illuminate\Database\Eloquent\Collection;

class Common
{
    public static function convertPatientPayloadToEntity(array $data)
    {
        $data = UtilCommon::convertKeysToCase(Constant::SNAKE_CASE, $data);
        $patient = new Patient();
        $patient->fill($data);

        return $patient;
    }

    public static function convertToListPatientPagination(Pagination $pagination, Collection $listData)
    {
        $listDataConvert = $listData->map(function ($item) {
            return [
                'id' => $item->id,
                'patientGroup' => $item->patient_group,
                'name' => $item->name,
                'gender' => $item->gender,
                'birthday' => $item->birthday,
                'phoneNumber' => $item->phone_number,
                'address' => $item->address,
                'insuranceNumber' => $item->insurance_number,
            ];
        });

        $dataPaging = [
            'count' => $pagination->getRecordCount(),
            'numPages' => ceil($pagination->getRecordCount() / $pagination->getPageSize()),
            'displayRecord' => $pagination->getDisplayRecord(),
            'page' => $pagination->getPage(),
        ];

        return [
            'results' => $listDataConvert,
            'pagination' => $dataPaging,
        ];
    }
}
