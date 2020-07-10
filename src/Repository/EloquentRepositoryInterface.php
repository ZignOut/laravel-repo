<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface EquolentRepositoryInterface
 * @package App\Repositories;
 */
interface EloquentRepostoryInterface { 
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param $id
     * @return Model
     */
    public function find($id): ?Model;
}