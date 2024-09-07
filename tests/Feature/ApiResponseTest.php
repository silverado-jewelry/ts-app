<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Tests\TestCase;

class ApiResponseTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_api_returns_correct_response_for_guest(): void
    {
        // Test login endpoint
        $response = $this->get('/api/login');
        $response->assertStatus(405);

        $response = $this->post('/api/login');
        $response->assertStatus(422);

        // Test register endpoint
        $response = $this->get('/api/register');
        $response->assertStatus(405);

        $response = $this->post('/api/register');
        $response->assertStatus(422);

        // Register a user
        $response = $this->post('/api/register', [
            'email' => 'j.doe@localhost.com',
            'name' => 'John Doe',
            'password' => '1234QwertY',
            'password_confirmation' => '1234QwertY',
        ]);
        $response->assertStatus(200);

        // Test logout for user
        $response = $this->get('/api/logout');
        $response->assertStatus(403);

        // Test listing articles
        $response = $this->get('/api/articles');
        $response->assertStatus(200);

        // Test creating an article without being authenticated
        $response = $this->post('/api/articles');
        $response->assertStatus(403);

        $user = User::factory()->create();
        $article = Article::factory()->create([
            'user_id' => $user->id,
            'title' => 'Test Article',
            'body' => 'This is a test article.',
            'publish_at' => now()
        ]);

        // GET request to retrieve the article
        $response = $this->get('/api/articles/' . $article->id);
        $response->assertStatus(200);

        // PATCH request to update the article
        $response = $this->patch('/api/articles/' . $article->id);
        $response->assertStatus(403);

        // DELETE request to delete the article
        $response = $this->delete('/api/articles/' . $article->id);
        $response->assertStatus(403);
    }

    /**
     * A basic test example
     */
    public function test_the_api_returns_correct_response_for_authenticated_user(): void
    {
        // Create and authenticate a user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Test listing articles
        $response = $this->get('/api/articles');
        $response->assertStatus(200);

        // Test creating an article while authenticated
        $response = $this->post('/api/articles', [
            'title' => 'New Article',
            'body' => 'This is a new article.',
            'publish_at' => now()
        ]);
        $response->assertStatus(200); // Assuming the article creation returns 201 Created

        // Fetch the created article's ID (assuming it's the first one created)
        $article = Article::first();

        // GET request to retrieve the article
        $response = $this->get('/api/articles/' . $article->id);
        $response->assertStatus(200);

        // PATCH request to update the article
        $response = $this->patch('/api/articles/' . $article->id, [
            'title' => 'Updated Title'
        ]);
        $response->assertStatus(200);

        // DELETE request to delete the article
        $response = $this->delete('/api/articles/' . $article->id);
        $response->assertStatus(200); // Assuming deletion returns a 200

        // GET request to retrieve the article
        $response = $this->get('/api/articles/' . $article->id);
        $response->assertStatus(404); // Assuming the article is not found
    }
}