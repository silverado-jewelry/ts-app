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
            'search' => 'nullable|string|max:128|min:3',
            'sort' => 'nullable',
        ]);

        $params = $validator->valid();

        $collection = $this->repository->search($params['search'] ?? null);

        if (isset($params['sort'])) {
            $sortParams = is_array($params['sort']) ? $params['sort'] : [$params['sort']];
            $sortableColumns = ['id', 'title', 'publish_at'];

            foreach ($sortParams as $sortParam) {
                $sort = explode(':', $sortParam);

                if (!in_array($sort[0], $sortableColumns)) {
                    continue;
                }

                $collection->orderBy(
                    $sort[0],
                    isset($sort[1]) && $sort[1] === 'desc' ? 'desc' : 'asc'
                );
            }
        }

        $paginatedResults = $collection
            ->paginate($params['per_page'] ?? 10)
            ->withQueryString();

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