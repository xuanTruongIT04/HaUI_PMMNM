<?php

namespace App\Infrastructure\Repositories\Category;

use App\Models\Category;
use App\UseCase\DataCommonFormatter;

interface ICategoryRepository
{
    public function getCategoryByCode(string $code): DataCommonFormatter;

    public function getAllCategoryByType(string $type): DataCommonFormatter;

    public function findById(int $id): DataCommonFormatter;

    public function createCategory(Category $data): DataCommonFormatter;

    public function deleteCategoryById(int $id): DataCommonFormatter;

    public function updateCategory(Category $data): DataCommonFormatter;
}
