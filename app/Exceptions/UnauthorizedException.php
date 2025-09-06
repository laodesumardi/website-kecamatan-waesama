<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UnauthorizedException extends Exception
{
    /**
     * The error message.
     *
     * @var string
     */
    protected $message = 'Anda tidak memiliki izin untuk mengakses resource ini.';

    /**
     * The HTTP status code.
     *
     * @var int
     */
    protected $code = 403;

    /**
     * Create a new exception instance.
     *
     * @param string|null $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = null, $code = 403, Exception $previous = null)
    {
        if ($message) {
            $this->message = $message;
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
                'error' => 'Unauthorized',
                'message' => $this->message,
                'status_code' => $this->code
            ], $this->code);
        }

        return response()->view('errors.403', [
            'message' => $this->message
        ], $this->code);
    }

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        // Log the unauthorized access attempt
        \Log::warning('Unauthorized access attempt', [
            'message' => $this->message,
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
            'url' => request()->fullUrl(),
            'user_agent' => request()->userAgent()
        ]);
        
        return false;
    }
}