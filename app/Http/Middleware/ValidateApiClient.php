<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Application;

class ValidateApiClient
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get client ID and secret from headers
        $clientId = $request->header('X-API-Client-ID');
        $clientSecret = $request->header('X-API-Client-Secret');

        // Validate external API credentials if headers are present
        $externalApiValidation = $this->validateApiCredentials($request);
        if ($externalApiValidation !== null) {
            return $externalApiValidation;
        }

        // Validate client
        $application = Application::where('api_client_id', $clientId)
            ->where('is_active', true)
            ->first();

        if (!$application) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid API client.',
                'errors' => ['client' => 'API client not found or inactive.']
            ], Response::HTTP_UNAUTHORIZED);
        }


        //Verify secret hash
        // $secretHash = hash('sha256', $clientSecret);
        // if (!hash_equals($application->api_client_secret_hash, $secretHash)) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Invalid API credentials.',
        //         'errors' => ['secret' => 'API secret is incorrect.']
        //     ], Response::HTTP_UNAUTHORIZED);
        // }

        // Store application in request for later use
        $request->merge(['api_application' => $application]);
        

        return $next($request);
    }

    /**
     * Validate external API credentials from request headers
     */
    private function validateApiCredentials(Request $request)
    {
        // Check if any external API header is present
        $hasApiHeader = 
            $request->hasHeader('X-API-Client-ID') ||
            $request->hasHeader('X-API-Client-Secret') ||
            $request->hasHeader('X-API-Key');

        if (!$hasApiHeader) {
            // No external API headers provided, skip validation
            return null;
        }

        // If any header is provided, all must be provided
        $clientId = $request->header('X-API-Client-ID');
        $clientSecret = $request->header('X-API-Client-Secret');
        $apiKey = $request->header('X-API-Key');

        $errors = [];

        if (!$clientId) {
            $errors['x_api_client_id'] = 'X-API-Client-ID header is required.';
        }

        if (!$clientSecret) {
            $errors['x_api_client_secret'] = 'X-API-Client-Secret header is required.';
        }

        if (!$apiKey) {
            $errors['x_api_key'] = 'X-API-Key header is required.';
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
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'api_key' => $apiKey,
            ]
        ]);

        return null;
    }
}
