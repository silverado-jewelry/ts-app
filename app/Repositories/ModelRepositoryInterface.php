<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface ModelRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update(Model $model, array $data);
    public function delete(Model $model);
}