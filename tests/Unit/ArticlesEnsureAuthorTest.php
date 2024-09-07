<?php

namespace Tests\Unit;

use App\Http\Middleware\EnsureAuthor;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class ArticlesEnsureAuthorTest extends TestCase
{
    public function test_article_edit_ensure_author()
    {
        $user = User::factory()->create();

        $article = Article::factory()->create([
            'user_id' => $user->id,
            'title' => 'Test Article',
            'body' => 'This is a test article.',
            'publish_at' => now()
        ]);

        $this->actingAs($user);

        $request = Request::create('/api/articles/' . $article->id, 'PATCH');
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $route = $this->createMock(Route::class);
        $route->expects($this->any())
            ->method('parameter')
            ->with('article')
            ->willReturn($article);

        $request->setRouteResolver(function () use ($route) {
            return $route;
        });

        $middleware = new EnsureAuthor();

        $response = $middleware->handle($request, function () {
            return new Response();
        });

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_article_edit_ensure_not_author()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $article = Article::factory()->create([
            'user_id' => $otherUser->id,
            'title' => 'Test Article',
            'body' => 'This is a test article.',
            'publish_at' => now()
        ]);

        $this->actingAs($user);

        $request = Request::create('/api/articles/' . $article->id, 'PATCH');
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $route = $this->createMock(Route::class);
        $route->expects($this->any())
            ->method('parameter')
            ->with('article')
            ->willReturn($article);

        $request->setRouteResolver(function () use ($route) {
            return $route;
        });

        $middleware = new EnsureAuthor();

        try {
            $middleware->handle($request, function () {
                return new Response();
            });
        } catch (HttpException $e) {
            $this->assertEquals(403, $e->getStatusCode());
            return;
        }

        $this->fail('Expected HttpException was not thrown.');
    }

    public function test_article_delete_ensure_author()
    {
        $user = User::factory()->create();

        $article = Article::factory()->create([
            'user_id' => $user->id,
            'title' => 'Test Article',
            'body' => 'This is a test article.',
            'publish_at' => now()
        ]);

        $this->actingAs($user);

        $request = Request::create('/api/articles/' . $article->id, 'DELETE');
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $route = $this->createMock(Route::class);
        $route->expects($this->any())
            ->method('parameter')
            ->with('article')
            ->willReturn($article);

        $request->setRouteResolver(function () use ($route) {
            return $route;
        });

        $middleware = new EnsureAuthor();

        $response = $middleware->handle($request, function () {
            return new Response();
        });

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_article_delete_ensure_not_author()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $article = Article::factory()->create([
            'user_id' => $otherUser->id,
            'title' => 'Test Article',
            'body' => 'This is a test article.',
            'publish_at' => now()
        ]);

        $this->actingAs($user);

        $request = Request::create('/api/articles/' . $article->id, 'DELETE');
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $route = $this->createMock(Route::class);
        $route->expects($this->any())
            ->method('parameter')
            ->with('article')
            ->willReturn($article);

        $request->setRouteResolver(function () use ($route) {
            return $route;
        });

        $middleware = new EnsureAuthor();

        try {
            $middleware->handle($request, function () {
                return new Response();
            });
        } catch (HttpException $e) {
            $this->assertEquals(403, $e->getStatusCode());
            return;
        }

        $this->fail('Expected HttpException was not thrown.');
    }
}