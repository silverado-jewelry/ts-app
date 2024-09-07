<?php

namespace Tests\Unit;

use App\Http\Middleware\ApiAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class ArticlesEnsureAccessTest extends TestCase
{
    /**
     * Test that an authenticated user can access the article creation route.
     */
    public function test_article_create_ensure_access_auth(): void
    {
        // Create a user and log them in
        $user = User::factory()->create();

        // Simulate the authenticated user
        $this->actingAs($user);

        // Create a POST request for creating an article
        $request = Request::create('/api/articles/', 'POST');
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        // Instantiate the ApiAuth middleware
        $middleware = new ApiAuth();

        // Call the middleware and assert success response
        $response = $middleware->handle($request, function () {
            return new Response();
        });

        // Assert that the response is a valid response with a 200 status code
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test that an unauthenticated user cannot access the article creation route.
     */
    public function test_article_create_ensure_no_access_unauth(): void
    {
        // Create a POST request for creating an article (no authenticated user)
        $request = Request::create('/api/articles/', 'POST');

        // No user resolver is set, meaning the request is unauthenticated

        // Instantiate the ApiAuth middleware
        $middleware = new ApiAuth();

        // Expect an HttpException with status 401 or 403 depending on your implementation
        try {
            $middleware->handle($request, function () {
                return new Response();
            });
        } catch (HttpException $e) {
            // Assert that the exception has a 401 status code
            $this->assertEquals(403, $e->getStatusCode());
            return;
        }

        // Fail the test if no exception was thrown
        $this->fail('Expected HttpException was not thrown.');
    }
}