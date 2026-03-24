<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ResponseHelper
{
    /**
     * Return success response
     */
    public static function success(
        mixed $data = null,
        string $message = 'Operation successful',
        int $statusCode = 200,
        array $additional = []
    ): JsonResponse {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        // Merge additional data
        if (!empty($additional)) {
            $response = array_merge($response, $additional);
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return success response with pagination
     */
    public static function successWithPagination(
        LengthAwarePaginator $paginator,
        string $message = 'Data retrieved successfully',
        int $statusCode = 200
    ): JsonResponse {
        return self::success(
            $paginator->items(),
            $message,
            $statusCode,
            [
                'pagination' => [
                    'total' => $paginator->total(),
                    'per_page' => $paginator->perPage(),
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                    'from' => $paginator->firstItem(),
                    'to' => $paginator->lastItem(),
                ]
            ]
        );
    }

    /**
     * Return error response
     */
    public static function error(
        string $message = 'Operation failed',
        int $statusCode = 400,
        array $errors = [],
        string $errorType = null
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        if ($errorType) {
            $response['error_type'] = $errorType;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return validation error response
     */
    public static function validationError(
        array $errors,
        string $message = 'Validation failed'
    ): JsonResponse {
        return self::error($message, 422, $errors, 'validation_error');
    }

    /**
     * Return not found error response
     */
    public static function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return self::error($message, 404, [], 'not_found');
    }

    /**
     * Return unauthorized error response
     */
    public static function unauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return self::error($message, 401, [], 'unauthorized');
    }

    /**
     * Return forbidden error response
     */
    public static function forbidden(string $message = 'Forbidden'): JsonResponse
    {
        return self::error($message, 403, [], 'forbidden');
    }

    /**
     * Return server error response
     */
    public static function serverError(
        string $message = 'Internal server error',
        string $errorMessage = null
    ): JsonResponse {
        $errors = [];
        if ($errorMessage && config('app.debug')) {
            $errors['exception'] = $errorMessage;
        }

        return self::error($message, 500, $errors, 'server_error');
    }

    /**
     * Return unprocessable entity error
     */
    public static function unprocessableEntity(
        string $message = 'Unable to process request',
        array $errors = []
    ): JsonResponse {
        return self::error($message, 422, $errors, 'unprocessable_entity');
    }

    /**
     * Return created response (201)
     */
    public static function created(
        mixed $data = null,
        string $message = 'Resource created successfully'
    ): JsonResponse {
        return self::success($data, $message, 201);
    }

    /**
     * Return updated response
     */
    public static function updated(
        mixed $data = null,
        string $message = 'Resource updated successfully'
    ): JsonResponse {
        return self::success($data, $message, 200);
    }

    /**
     * Return deleted response
     */
    public static function deleted(string $message = 'Resource deleted successfully'): JsonResponse
    {
        return self::success(null, $message, 200);
    }

    /**
     * Return DataTable response
     */
    public static function dataTable(
        int $draw,
        int $recordsTotal,
        int $recordsFiltered,
        array $data
    ): JsonResponse {
        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }
}
