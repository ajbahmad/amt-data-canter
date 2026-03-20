<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Services\Api\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * API Login endpoint
     * POST /api/auth/login
     */
    public function login(LoginRequest $request)
    {
        $result = $this->authService->login(
            $request->email,
            $request->password
        );

        // if (!$result['success']) {
        //     return response()->json($result, Response::HTTP_UNAUTHORIZED);
        // }

        return response()->json($result, Response::HTTP_OK);
    }

    /**
     * API Logout endpoint
     * POST /api/auth/logout
     */
    public function logout()
    {
        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ], Response::HTTP_OK);
    }

    /**
     * Get current user info
     * GET /api/auth/me
     */
    public function me(Request $request)
    {
        $tokenData = $request->get('api_token_data');
        
        if (!$tokenData) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = \App\Models\User::find($tokenData['user_id']);
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_active' => $user->is_active,
                'application_id' => $tokenData['application_id'],
            ]
        ], Response::HTTP_OK);
    }
}
