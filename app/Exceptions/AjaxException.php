<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class AjaxException extends Exception
{
    protected int $status;

    public function __construct(string $message, int $status = 400)
    {
        parent::__construct($message, $status);
        $this->status = $status;
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render($request): JsonResponse
    {
        // Only return JSON for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $this->getMessage(),
            ], $this->status);
        }

        // Fallback to default
        return parent::render($request);
    }
}
