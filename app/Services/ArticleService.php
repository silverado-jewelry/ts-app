<?php

namespace App\Services;

use App\DTOs\Article\ArticleResponseDTO;
use App\Models\Article;
use App\Models\User;
use App\Repositories\ArticleRepository;
use App\Repositories\ModelRepositoryInterface;
use Illuminate\Http\Request;

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
        $collection = $this->repository->search($request->input('search'));

        $sort = request()->input('sort', 'publish_at');

        if (is_array($sort)) {
            $sort = array_filter($sort, function($column) {
                return in_array($column, ['id', 'title', 'publish_at']);
            }, ARRAY_FILTER_USE_KEY);

            foreach ($sort as $column => $direction) {
                $collection->orderBy(
                    $column,
                    in_array(strtolower($direction), ['asc', 'desc']) ? strtolower($direction) : 'asc'
                );
            }
        } else {
            $collection->orderBy($sort);
        }

        $paginatedResults = $collection->paginate($request->input('per_page', 10));

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