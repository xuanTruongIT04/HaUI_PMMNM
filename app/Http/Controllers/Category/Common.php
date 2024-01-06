<?php

namespace App\Http\Controllers\Category;

use App\Config\Constant;
use App\Models\Category;
use App\Util\Common as UtilCommon;
use App\Util\Pagination;
use Illuminate\Database\Eloquent\Collection;

class Common
{
    public static function convertCategoryPayloadToEntity(array $data): Category
    {
        $data = UtilCommon::convertKeysToCase(Constant::SNAKE_CASE, $data);
        $category = new Category();
        $category->fill($data);

        return $category;
    }

    public static function convertToListCategoryPagination(Pagination $pagination, Collection $listData)
    {
        $listDataConvert = $listData->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'code' => $item->code,
                'type' => $item->type,
                'description' => $item->description,
                'cost' => $item->cost,
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
