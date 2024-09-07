<?php

namespace App\DTOs\Article;

use App\DTOs\ModelConfigurable;
use App\DTOs\User\UserResponseDTO;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ArticleResponseDTO implements ModelConfigurable
{
    /**
     * @param int $id
     * @param string $title
     * @param string $body
     * @param string $publish_at
     * @param UserResponseDTO $author
     */
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $body,
        public readonly string $publish_at,
        public readonly UserResponseDTO $author,
    ) {}

    /**
     * @param Article $model
     * @return static
     */
    public static function fromModel(Model $model): static
    {
        return new static(
            id: $model->id,
            title: $model->title,
            body: $model->body,
            publish_at: Carbon::create($model->publish_at)->toDateString(),
            author: UserResponseDTO::fromModel($model->user),
        );
    }
}