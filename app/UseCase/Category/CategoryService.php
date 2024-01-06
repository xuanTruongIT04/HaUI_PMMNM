<?php

namespace App\UseCase\Category;

use App\Infrastructure\Repositories\Category\ICategoryRepository;
use App\Models\Category;
use App\UseCase\DataCommonFormatter;

class CategoryService implements CategoryUseCase
{
    private ICategoryRepository $categoryRepo;

    public function __construct(ICategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function getCategoryByCode(string $code): DataCommonFormatter
    {
        return $this->categoryRepo->getCategoryByCode($code);
    }

    public function getAllCategoryByType(string $type): DataCommonFormatter
    {
        return $this->categoryRepo->getAllCategoryByType($type);
    }


    public function getCategoryById(int $id): DataCommonFormatter
    {
        return $this->categoryRepo->findById($id);
    }

    public function createCategory(Category $data): DataCommonFormatter
    {
        return $this->categoryRepo->createCategory($data);
    }

    public function updateCategory(array $data): DataCommonFormatter
    {

        $categoryUpdate = $this->categoryRepo->findById($data['id']);
        if ($categoryUpdate->getException() != null) {
            return new DataCommonFormatter($categoryUpdate->getException(), null);
        }

        $categoryEntity = $categoryUpdate->getData();
        $categoryEntity->name = $data['name'];
        $categoryEntity->type = $data['type'];
        $categoryEntity->description = $data['description'];
        $categoryEntity->cost = $data['cost'];

        return $this->categoryRepo->updateCategory($categoryEntity);
    }

    public function deleteCategoryById(int $id): DataCommonFormatter
    {
        return $this->categoryRepo->deleteCategoryById($id);
    }
}
