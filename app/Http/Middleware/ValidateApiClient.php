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

        if (!$clientId || !$clientSecret) {
            return response()->json([
                'status' => false,
                'message' => 'Missing API credentials.',
                'errors' => ['credentials' => 'X-API-Client-ID and X-API-Client-Secret headers required.']
            ], Response::HTTP_UNAUTHORIZED);
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
}
