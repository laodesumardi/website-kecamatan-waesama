<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceException extends Exception
{
    /**
     * The error message.
     *
     * @var string
     */
    protected $message = 'Terjadi kesalahan pada layanan sistem.';

    /**
     * The HTTP status code.
     *
     * @var int
     */
    protected $code = 500;

    /**
     * The service name where the error occurred.
     *
     * @var string|null
     */
    protected $serviceName;

    /**
     * The operation that failed.
     *
     * @var string|null
     */
    protected $operation;

    /**
     * Additional context data.
     *
     * @var array
     */
    protected $context;

    /**
     * Create a new exception instance.
     *
     * @param string|null $message
     * @param string|null $serviceName
     * @param string|null $operation
     * @param array $context
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct(
        $message = null,
        $serviceName = null,
        $operation = null,
        array $context = [],
        $code = 500,
        Exception $previous = null
    ) {
        $this->serviceName = $serviceName;
        $this->operation = $operation;
        $this->context = $context;
        
        if ($message) {
            $this->message = $message;
        } elseif ($serviceName && $operation) {
            $this->message = "Kesalahan pada {$serviceName} saat melakukan {$operation}.";
        } elseif ($serviceName) {
            $this->message = "Kesalahan pada layanan {$serviceName}.";
        }
        
        $this->code = $code;
        
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
                'error' => 'Service Error',
                'message' => $this->message,
                'service' => $this->serviceName,
                'operation' => $this->operation,
                'status_code' => $this->code
            ], $this->code);
        }

        return response()->view('errors.500', [
            'message' => $this->message,
            'service' => $this->serviceName,
            'operation' => $this->operation
        ], $this->code);
    }

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        // Log the service error with full context
        \Log::error('Service exception occurred', [
            'message' => $this->message,
            'service' => $this->serviceName,
            'operation' => $this->operation,
            'context' => $this->context,
            'code' => $this->code,
            'file' => $this->getFile(),
            'line' => $this->getLine(),
            'trace' => $this->getTraceAsString(),
            'url' => request()->fullUrl(),
            'user_id' => auth()->id(),
            'ip' => request()->ip()
        ]);
        
        return true;
    }

    /**
     * Get the service name.
     *
     * @return string|null
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * Get the operation that failed.
     *
     * @return string|null
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Get the context data.
     *
     * @return array
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Create a new exception for a specific service.
     *
     * @param string $serviceName
     * @param string $message
     * @param string|null $operation
     * @param array $context
     * @return static
     */
    public static function forService($serviceName, $message, $operation = null, array $context = [])
    {
        return new static($message, $serviceName, $operation, $context);
    }

    /**
     * Create a new exception for a database operation.
     *
     * @param string $message
     * @param string|null $operation
     * @param array $context
     * @return static
     */
    public static function database($message, $operation = null, array $context = [])
    {
        return new static($message, 'Database', $operation, $context);
    }

    /**
     * Create a new exception for an external API.
     *
     * @param string $message
     * @param string|null $apiName
     * @param array $context
     * @return static
     */
    public static function externalApi($message, $apiName = null, array $context = [])
    {
        $serviceName = $apiName ? "External API ({$apiName})" : 'External API';
        return new static($message, $serviceName, 'API Call', $context);
    }
}