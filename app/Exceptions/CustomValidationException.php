<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;

class CustomValidationException extends Exception
{
    /**
     * The error message.
     *
     * @var string
     */
    protected $message = 'Data yang diberikan tidak valid.';

    /**
     * The HTTP status code.
     *
     * @var int
     */
    protected $code = 422;

    /**
     * The validation errors.
     *
     * @var array|MessageBag
     */
    protected $errors;

    /**
     * The field that failed validation.
     *
     * @var string|null
     */
    protected $field;

    /**
     * Create a new exception instance.
     *
     * @param string|array|MessageBag $errors
     * @param string|null $message
     * @param string|null $field
     * @param Exception|null $previous
     */
    public function __construct($errors = [], $message = null, $field = null, Exception $previous = null)
    {
        $this->errors = $errors;
        $this->field = $field;
        
        if ($message) {
            $this->message = $message;
        } elseif ($field) {
            $this->message = "Validasi gagal untuk field: {$field}";
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
                'error' => 'Validation Failed',
                'message' => $this->message,
                'errors' => $this->formatErrors(),
                'status_code' => $this->code
            ], $this->code);
        }

        return redirect()->back()
            ->withErrors($this->errors)
            ->withInput()
            ->with('error', $this->message);
    }

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        // Log validation errors for debugging
        \Log::info('Custom validation failed', [
            'message' => $this->message,
            'errors' => $this->errors,
            'field' => $this->field,
            'url' => request()->fullUrl(),
            'input' => request()->except(['password', 'password_confirmation']),
            'user_id' => auth()->id()
        ]);
        
        return false;
    }

    /**
     * Get the validation errors.
     *
     * @return array|MessageBag
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Get the field that failed validation.
     *
     * @return string|null
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Format errors for consistent output.
     *
     * @return array
     */
    protected function formatErrors()
    {
        if ($this->errors instanceof MessageBag) {
            return $this->errors->toArray();
        }
        
        if (is_array($this->errors)) {
            return $this->errors;
        }
        
        if (is_string($this->errors)) {
            return [$this->field ?? 'general' => [$this->errors]];
        }
        
        return [];
    }

    /**
     * Create a new exception for a specific field.
     *
     * @param string $field
     * @param string $message
     * @return static
     */
    public static function forField($field, $message)
    {
        return new static([$field => [$message]], null, $field);
    }

    /**
     * Create a new exception for multiple fields.
     *
     * @param array $errors
     * @param string|null $message
     * @return static
     */
    public static function forFields(array $errors, $message = null)
    {
        return new static($errors, $message);
    }
}