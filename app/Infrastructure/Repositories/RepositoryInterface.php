<?php

namespace App\Infrastructure\Repositories;

interface RepositoryInterface
{
    /**
     * Get all
     */
    public function getAll(): mixed;

    /**
     * Get one
     */
    public function find($id): mixed;

    /**
     * Create
     */
    public function create(array $attributes): mixed;

    /**
     * Update
     */
    public function update(int $id, array $attributes): mixed;

    /**
     * Delete
     */
    public function delete($id): mixed;

    /**
     * Delete by ids
     */
    public function deleteByIds($ids): mixed;
}
