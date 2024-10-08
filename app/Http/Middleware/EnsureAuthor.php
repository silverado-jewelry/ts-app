<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAuthor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (($article = $request->route('article')) === null) {
            abort(404, 'Article not found.');
        }

        if ($article->user_id !== auth('api')->id()) {
            abort(403, "You're not the author of this article.");
        }

        return $next($request);
    }
}
