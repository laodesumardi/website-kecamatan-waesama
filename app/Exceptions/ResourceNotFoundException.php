<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ResourceNotFoundException extends Exception
{
    /**
     * The error message.
     *
     * @var string
     */
    protected $message = 'Resource yang diminta tidak ditemukan.';

    /**
     * The HTTP status code.
     *
     * @var int
     */
    protected $code = 404;

    /**
     * The resource type that was not found.
     *
     * @var string
     */
    protected $resourceType;

    /**
     * The resource identifier that was not found.
     *
     * @var mixed
     */
    protected $resourceId;

    /**
     * Create a new exception instance.
     *
     * @param string|null $message
     * @param string|null $resourceType
     * @param mixed $resourceId
     * @param Exception|null $previous
     */
    public function __construct($message = null, $resourceType = null, $resourceId = null, Exception $previous = null)
    {
        $this->resourceType = $resourceType;
        $this->resourceId = $resourceId;
        
        if ($message) {
            $this->message = $message;
        } elseif ($resourceType && $resourceId) {
            $this->message = "{$resourceType} dengan ID {$resourceId} tidak ditemukan.";
        } elseif ($resourceType) {
            $this->message = "{$resourceType} tidak ditemukan.";
        }
        
        parent::__construct($this->message, $this->code, $previous);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     * @return Response
     */
    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Not Found',
                'message' => $this->message,
                'resource_type' => $this->resourceType,
                'resource_id' => $this->resourceId,
                'status_code' => $this->code
            ], $this->code);
        }

        return response()->view('errors.404', [
            'message' => $this->message,
            'resource_type' => $this->resourceType,
            'resource_id' => $this->resourceId
        ], $this->code);
    }

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        // Log the not found error for debugging
        \Log::info('Resource not found', [
            'message' => $this->message,
            'resource_type' => $this->resourceType,
            'resource_id' => $this->resourceId,
            'url' => request()->fullUrl(),
            'user_id' => auth()->id()
        ]);
        
        return false;
    }

    /**
     * Get the resource type.
     *
     * @return string|null
     */
    public function getResourceType()
    {
        return $this->resourceType;
    }

    /**
     * Get the resource ID.
     *
     * @return mixed
     */
    public function getResourceId()
    {
        return $this->resourceId;
    }
}