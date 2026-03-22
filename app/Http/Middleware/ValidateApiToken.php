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

        // Validate external API credentials if headers are present
        $externalApiValidation = $this->validateApiCredentials($request);
        if ($externalApiValidation !== null) {
            return $externalApiValidation;
        }

        // Store token data in request for later use
        $request->merge(['api_token_data' => $tokenData]);

        return $next($request);
    }

    /**
     * Validate external API credentials from request headers
     */
    private function validateApiCredentials(Request $request)
    {
        // Check if any external API header is present
        $hasApiHeader = $request->hasHeader('X-API-URL') ||
                               $request->hasHeader('X-API-Client-ID') ||
                               $request->hasHeader('X-API-Client-Secret') ||
                               $request->hasHeader('X-API-Key');

        if (!$hasApiHeader) {
            // No external API headers provided, skip validation
            return null;
        }

        // If any header is provided, all must be provided
        $url = $request->header('X-API-URL');
        $clientId = $request->header('X-API-Client-ID');
        $clientSecret = $request->header('X-API-Client-Secret');
        $apiKey = $request->header('X-API-Key');

        $errors = [];

        if (!$url) {
            $errors['x_api_url'] = 'X-API-URL header is required.';
        }

        if (!$clientId) {
            $errors['x_api_client_id'] = 'X-API-Client-ID header is required.';
        }

        if (!$clientSecret) {
            $errors['x_api_client_secret'] = 'X-API-Client-Secret header is required.';
        }

        if (!$apiKey) {
            $errors['x_api_key'] = 'X-API-Key header is required.';
        }

        // Validate URL format
        if ($url && !filter_var($url, FILTER_VALIDATE_URL)) {
            $errors['x_api_url'] = 'X-API-URL must be a valid URL.';
        }

        if (!empty($errors)) {
            return response()->json([
                'success' => false,
                'message' => ' API credentials validation failed.',
                'errors' => $errors
            ], Response::HTTP_BAD_REQUEST);
        }

        // Store external API credentials in request for later use
        $request->merge([
            'x_api_credentials' => [
                'url' => $url,
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'api_key' => $apiKey,
            ]
        ]);

        return null;
    }
}
