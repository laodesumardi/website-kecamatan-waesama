<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        UnauthorizedException::class,
        ResourceNotFoundException::class,
        CustomValidationException::class,
        BusinessLogicException::class,
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Handle custom exceptions
        $this->renderable(function (UnauthorizedException $e, Request $request) {
            return $e->render($request);
        });

        $this->renderable(function (ResourceNotFoundException $e, Request $request) {
            return $e->render($request);
        });

        $this->renderable(function (CustomValidationException $e, Request $request) {
            return $e->render($request);
        });

        $this->renderable(function (BusinessLogicException $e, Request $request) {
            return $e->render($request);
        });

        $this->renderable(function (ServiceException $e, Request $request) {
            return $e->render($request);
        });
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param Request $request
     * @param AuthenticationException $exception
     * @return Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Unauthenticated',
                'message' => 'Anda harus login terlebih dahulu.',
                'status_code' => 401
            ], 401);
        }

        return redirect()->guest(route('login'))
            ->with('error', 'Anda harus login terlebih dahulu.');
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param Request $request
     * @param ValidationException $exception
     * @return Response
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'error' => 'Validation Failed',
            'message' => 'Data yang diberikan tidak valid.',
            'errors' => $exception->errors(),
            'status_code' => $exception->status
        ], $exception->status);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        // Handle Model Not Found Exception
        if ($e instanceof ModelNotFoundException) {
            $model = class_basename($e->getModel());
            $exception = new ResourceNotFoundException(
                "Data {$model} tidak ditemukan.",
                $model,
                $e->getIds()[0] ?? null
            );
            return $exception->render($request);
        }

        // Handle 404 Not Found Exception
        if ($e instanceof NotFoundHttpException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Not Found',
                    'message' => 'Halaman yang diminta tidak ditemukan.',
                    'status_code' => 404
                ], 404);
            }
            return response()->view('errors.404', [], 404);
        }

        // Handle Access Denied Exception
        if ($e instanceof AccessDeniedHttpException) {
            $exception = new UnauthorizedException(
                'Anda tidak memiliki izin untuk mengakses resource ini.'
            );
            return $exception->render($request);
        }

        // Handle general exceptions in production
        if (app()->environment('production') && !($e instanceof ValidationException)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Server Error',
                    'message' => 'Terjadi kesalahan pada server. Silakan coba lagi nanti.',
                    'status_code' => 500
                ], 500);
            }
            return response()->view('errors.500', [], 500);
        }

        return parent::render($request, $e);
    }

    /**
     * Report or log an exception.
     *
     * @param Throwable $e
     * @return void
     *
     * @throws Throwable
     */
    public function report(Throwable $e)
    {
        // Add additional context to logs
        if (method_exists($e, 'getContext')) {
            $context = $e->getContext();
            if (!empty($context)) {
                \Log::withContext($context);
            }
        }

        parent::report($e);
    }

    /**
     * Get the default context variables for logging.
     *
     * @return array
     */
    protected function context()
    {
        return array_filter([
            'userId' => auth()->id(),
            'userEmail' => auth()->user()?->email,
            'ip' => request()->ip(),
            'userAgent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
        ]);
    }
}