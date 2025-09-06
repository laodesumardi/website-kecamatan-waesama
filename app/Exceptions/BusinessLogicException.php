<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BusinessLogicException extends Exception
{
    /**
     * The error message.
     *
     * @var string
     */
    protected $message = 'Operasi tidak dapat dilakukan karena melanggar aturan bisnis.';

    /**
     * The HTTP status code.
     *
     * @var int
     */
    protected $code = 422;

    /**
     * The business rule that was violated.
     *
     * @var string|null
     */
    protected $businessRule;

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
     * @param string|null $businessRule
     * @param array $context
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct(
        $message = null,
        $businessRule = null,
        array $context = [],
        $code = 422,
        Exception $previous = null
    ) {
        $this->businessRule = $businessRule;
        $this->context = $context;
        
        if ($message) {
            $this->message = $message;
        } elseif ($businessRule) {
            $this->message = "Aturan bisnis dilanggar: {$businessRule}";
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
                'error' => 'Business Logic Error',
                'message' => $this->message,
                'business_rule' => $this->businessRule,
                'context' => $this->context,
                'status_code' => $this->code
            ], $this->code);
        }

        return redirect()->back()
            ->with('error', $this->message)
            ->withInput();
    }

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        // Log business logic violations for analysis
        \Log::warning('Business logic violation', [
            'message' => $this->message,
            'business_rule' => $this->businessRule,
            'context' => $this->context,
            'url' => request()->fullUrl(),
            'user_id' => auth()->id(),
            'input' => request()->except(['password', 'password_confirmation'])
        ]);
        
        return false;
    }

    /**
     * Get the business rule that was violated.
     *
     * @return string|null
     */
    public function getBusinessRule()
    {
        return $this->businessRule;
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
     * Create exception for insufficient permissions.
     *
     * @param string $action
     * @param array $context
     * @return static
     */
    public static function insufficientPermissions($action, array $context = [])
    {
        return new static(
            "Anda tidak memiliki izin untuk {$action}.",
            'Insufficient Permissions',
            $context,
            403
        );
    }

    /**
     * Create exception for invalid status transition.
     *
     * @param string $from
     * @param string $to
     * @param array $context
     * @return static
     */
    public static function invalidStatusTransition($from, $to, array $context = [])
    {
        return new static(
            "Status tidak dapat diubah dari '{$from}' ke '{$to}'.",
            'Invalid Status Transition',
            array_merge($context, ['from' => $from, 'to' => $to])
        );
    }

    /**
     * Create exception for duplicate data.
     *
     * @param string $field
     * @param mixed $value
     * @param array $context
     * @return static
     */
    public static function duplicateData($field, $value, array $context = [])
    {
        return new static(
            "Data dengan {$field} '{$value}' sudah ada.",
            'Duplicate Data',
            array_merge($context, ['field' => $field, 'value' => $value])
        );
    }

    /**
     * Create exception for expired data.
     *
     * @param string $item
     * @param array $context
     * @return static
     */
    public static function expiredData($item, array $context = [])
    {
        return new static(
            "{$item} telah kedaluwarsa dan tidak dapat digunakan.",
            'Expired Data',
            array_merge($context, ['item' => $item])
        );
    }

    /**
     * Create exception for quota exceeded.
     *
     * @param string $resource
     * @param int $limit
     * @param array $context
     * @return static
     */
    public static function quotaExceeded($resource, $limit, array $context = [])
    {
        return new static(
            "Kuota {$resource} telah mencapai batas maksimal ({$limit}).",
            'Quota Exceeded',
            array_merge($context, ['resource' => $resource, 'limit' => $limit])
        );
    }
}