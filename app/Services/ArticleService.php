<?php

namespace App\Services;

use App\DTOs\Article\ArticleResponseDTO;
use App\Models\Article;
use App\Models\User;
use App\Repositories\ArticleRepository;
use App\Repositories\ModelRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleService
{
    /**
     * @param ModelRepositoryInterface|ArticleRepository $repository
     */
    public function __construct(
        private readonly ModelRepositoryInterface $repository
    ) {}

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search' => 'nullable|string|max:255|min:3',
            'sort' => 'nullable|array|string',
            'per_page' => 'nullable|integer|min:1|max:1000',
        ]);

        $params = $validator->valid();

        $collection = $this->repository->search($params['search'] ?? null);

        $sort = $params['sort'] ?? 'id';

        $sortableColumns = ['id', 'title', 'publish_at'];

        if (is_array($sort)) {
            foreach ($sort as $sortItem) {
                if (is_string($sortItem)) {
                    if (in_array($sortItem, $sortableColumns)) {
                        $collection->orderBy($sortItem);
                    }
                } elseif (is_array($sortItem)) {
                    foreach ($sortItem as $column => $direction) {
                        if (in_array($column, $sortableColumns)) {
                            $direction = in_array(strtolower($direction), ['asc', 'desc']) ? strtolower($direction) : 'asc';
                            $collection->orderBy($column, $direction);
                        }
                    }
                }
            }
        } else {
            if (is_string($sort) && in_array($sort, $sortableColumns)) {
                $collection->orderBy($sort);
            }
        }

        $paginatedResults = $collection->paginate($params['per_page'] ?? 10);

        $transformedResults = $paginatedResults->getCollection()->map(function($article) {
            return ArticleResponseDTO::fromModel($article);
        });

        $paginatedResults->setCollection($transformedResults);

        return $paginatedResults;
    }

    /**
     * @param array $data
     * @return Article
     */
    public function create(array $data): Article
    {
        return $this->repository->create($data);
    }

    /**
     * @param Article $article
     * @param array $data
     * @return Article
     */
    public function update(Article $article, array $data): Article
    {
        return $this->repository->update($article, $data);
    }

    /**
     * @param Article $article
     * @return bool
     */
    public function delete(Article $article): ?bool
    {
        return $this->repository->delete($article);
    }
}