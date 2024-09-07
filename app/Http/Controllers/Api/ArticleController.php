<?php

namespace App\Http\Controllers\Api;

use App\DTOs\Article\ArticleResponseDTO;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * @param ArticleService $articleService
     */
    public function __construct(
        private readonly ArticleService $articleService
    ) {}

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json(
            $this->articleService->search($request)
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:65535',
            'publish_at' => 'required|date',
        ]);

        $article = $this->articleService->create($request->only(['title', 'body', 'publish_at']));

        return response()->json(
            ArticleResponseDTO::fromModel($article)
        );
    }

    /**
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function read(Article $article)
    {
        return response()->json(
            ArticleResponseDTO::fromModel($article)
        );
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Article $article, Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:65535',
            'publish_at' => 'required|date',
        ]);

        $article = $this->articleService->update(
            $article,
            $request->only(['title', 'body', 'publish_at'])
        );

        return response()->json(
            ArticleResponseDTO::fromModel($article)
        );
    }

    /**
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Article $article)
    {
        return response()->json([
            'deleted' => $this->articleService->delete($article)
        ]);
    }
}
