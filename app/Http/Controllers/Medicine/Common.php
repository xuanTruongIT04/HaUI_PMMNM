<?php

namespace App\Http\Controllers\Medicine;

use App\Config\Constant;
use App\Models\Medicine;
use App\Util\Common as UtilCommon;
use App\Util\Pagination;
use Illuminate\Database\Eloquent\Collection;

class Common
{
    public static function convertMedicinePayloadToEntity(array $data): Medicine
    {
        $data = UtilCommon::convertKeysToCase(Constant::SNAKE_CASE, $data);
        $medicine = new Medicine();
        $medicine->fill($data);

        return $medicine;
    }

    public static function convertToListMedicinePagination(Pagination $pagination, Collection $listData)
    {
        $listDataConvert = $listData->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'code' => $item->code,
                'expiredDate' => $item->expired_date,
                'manufacturedDate' => $item->manufactured_date,
                'publisher' => $item->publisher,
                'instruction' => $item->instruction,
                'ingredient' => $item->ingredient,
                'quantity' => $item->quantity,
                'unit' => $item->unit,
                'price' => $item->price,
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
