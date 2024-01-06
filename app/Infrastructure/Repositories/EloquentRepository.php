<?php

namespace App\Infrastructure\Repositories;

abstract class EloquentRepository implements RepositoryInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $_model;

    /**
     * EloquentRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * get model
     */
    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->_model = app()->make(
            $this->getModel()
        );
    }

    /**
     * Get All
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll(): \Illuminate\Database\Eloquent\Collection|array
    {

        return $this->_model->all();
    }

    /**
     * Get one
     */
    public function find($id): mixed
    {
        $result = $this->_model->find($id);

        return $result;
    }

    /**
     * Create
     */
    public function create(array $attributes): mixed
    {
        return $this->_model->create($attributes);
    }

    /**
     * Update
     *
     * @return bool|mixed
     */
    public function update($id, array $attributes): mixed
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);

            return $result;
        }

        return false;
    }

    /**
     * Delete
     */
    public function delete($id): bool
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    public function deleteByIds($ids): mixed
    {
        return $this->_model->whereIn('id', $ids)->delete();
    }
}
