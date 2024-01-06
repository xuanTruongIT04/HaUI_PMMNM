<?php

namespace App\Infrastructure\Repositories\Category;

use App\Exceptions\CustomExceptionHandler;
use App\Models\Category;
use App\UseCase\DataCommonFormatter;
use Exception;

class CategoryRepository implements ICategoryRepository
{
    public function getCategoryByCode(string $code): DataCommonFormatter
    {
        try {
            $data = Category::where('code', $code)->first();
            if ($data == null) {
                return new DataCommonFormatter(CustomExceptionHandler::badRequest(), null);
            }
        } catch (Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return new DataCommonFormatter(null, $data);
    }

    public function getAllCategoryByType(string $type): DataCommonFormatter
    {
        try {
            $categories = Category::where('type', $type);
        } catch (Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return new DataCommonFormatter(null, $categories->get());
    }

    public function findById(int $id): DataCommonFormatter {
        try {
            $data = Category::where('id', $id)->first();
            if ($data == null) {
                return new DataCommonFormatter(CustomExceptionHandler::badRequest(), null);
            }
        } catch (Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return new DataCommonFormatter(null, $data);
    }

    public function createCategory(Category $data): DataCommonFormatter
    {
        try {
            $category = Category::where('code', $data->code)
                ->first();
            if ($category != null) {
                return new DataCommonFormatter(CustomExceptionHandler::badRequest(), null);
            }
            $data->save();

        } catch (Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return new DataCommonFormatter(null, $data);
    }

    public function deleteCategoryById(int $id): DataCommonFormatter
    {
        try {
            $category = Category::find($id);
            if ($category == null) {
                return new DataCommonFormatter(CustomExceptionHandler::badRequest(), null);
            }
            $category->delete();

            return new DataCommonFormatter(null, $category);
        } catch (Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }
    }

    public function updateCategory(Category $data): DataCommonFormatter
    {
        try {
            $data->save();
        } catch (Exception $exc) {
            return new DataCommonFormatter(CustomExceptionHandler::internalServerError(), null);
        }

        return new DataCommonFormatter(null, $data);

    }

}
