<?php

namespace App\UseCase\Category;

use App\Models\Category;
use App\UseCase\DataCommonFormatter;

interface CategoryUseCase
{
    public function getCategoryByCode(string $code): DataCommonFormatter;

    public function getAllCategoryByType(string $type): DataCommonFormatter;

    public function getCategoryById(int $id): DataCommonFormatter;
    public function createCategory(Category $data): DataCommonFormatter;

    public function deleteCategoryById(int $id): DataCommonFormatter;

    public function updateCategory(array $payload): DataCommonFormatter;
}
