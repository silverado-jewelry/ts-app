<?php

namespace App\DTOs;

use Illuminate\Database\Eloquent\Model;

interface ModelConfigurable
{
    /**
     * @param Model $model
     * @return static
     */
    public static function fromModel(Model $model): static;
}