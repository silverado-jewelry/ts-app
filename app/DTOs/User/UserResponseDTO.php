<?php

namespace App\DTOs\User;

use App\DTOs\ModelConfigurable;
use Illuminate\Database\Eloquent\Model;

class UserResponseDTO implements ModelConfigurable
{
    /**
     * @param int $id
     * @param string $name
     * @param string $email
     */
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
    ) {}

    /**
     * @param Model $model
     * @return static
     */
    public static function fromModel(Model $model): static
    {
        return new static(
            id: $model->id,
            name: $model->name,
            email: $model->email,
        );
    }
}