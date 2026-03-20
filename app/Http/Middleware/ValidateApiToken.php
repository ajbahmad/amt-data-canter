<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Api\Auth\AuthService;

class ValidateApiToken
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Missing API token.',
                'errors' => ['token' => 'Authorization Bearer token required.']
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Verify token
        $tokenData = $this->authService->verifyToken($token);

        if (!$tokenData) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired token.',
                'errors' => ['token' => 'API token is invalid or expired.']
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Store token data in request for later use
        $request->merge(['api_token_data' => $tokenData]);

        return $next($request);
    }
}
