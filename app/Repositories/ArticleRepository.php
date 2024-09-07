<?php

namespace App\Repositories;

use App\Models\Article;
use App\Repositories\ModelRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ArticleRepository implements ModelRepositoryInterface
{
    /**
     * @return Article[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Article::all();
    }

    /**
     * @param string|null $search
     * @return \Laravel\Scout\Builder
     */
    public function search(?string $search)
    {
        return Article::search($search);
    }

    /**
     * @param int $id
     * @return Article|null
     */
    public function find($id): ?Article
    {
        return Article::find($id);
    }

    /**
     * @param array $data
     * @return Article
     */
    public function create(array $data): Article
    {
        return Article::create($data);
    }

    /**
     * @param Article $model
     * @param array $data
     * @return Article
     */
    public function update(Model $model, array $data): Article
    {
        $model->update($data);

        return $model;
    }

    /**
     * @param Article $model
     * @return bool
     */
    public function delete(Model $model): ?bool
    {
        return $model->delete();
    }
}