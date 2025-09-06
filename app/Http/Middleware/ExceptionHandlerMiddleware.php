<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Exceptions\UnauthorizedException;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\CustomValidationException;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\ServiceException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class ExceptionHandlerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): SymfonyResponse
    {
        try {
            return $next($request);
        } catch (UnauthorizedException $e) {
            return $this->handleUnauthorizedException($e, $request);
        } catch (ResourceNotFoundException $e) {
            return $this->handleResourceNotFoundException($e, $request);
        } catch (CustomValidationException $e) {
            return $this->handleValidationException($e, $request);
        } catch (BusinessLogicException $e) {
            return $this->handleBusinessLogicException($e, $request);
        } catch (ServiceException $e) {
            return $this->handleServiceException($e, $request);
        } catch (\Throwable $e) {
            return $this->handleGenericException($e, $request);
        }
    }

    /**
     * Handle unauthorized exception.
     */
    protected function handleUnauthorizedException(UnauthorizedException $e, Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error_type' => 'unauthorized',
                'error_code' => $e->getCode(),
                'timestamp' => now()->toISOString()
            ], 403);
        }

        return redirect()->route('login')
            ->with('error', $e->getMessage())
            ->with('error_type', 'unauthorized');
    }

    /**
     * Handle resource not found exception.
     */
    protected function handleResourceNotFoundException(ResourceNotFoundException $e, Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error_type' => 'not_found',
                'error_code' => $e->getCode(),
                'resource_type' => $e->getResourceType(),
                'resource_id' => $e->getResourceId(),
                'timestamp' => now()->toISOString()
            ], 404);
        }

        return response()->view('errors.404', [
            'message' => $e->getMessage(),
            'resource_type' => $e->getResourceType(),
            'resource_id' => $e->getResourceId()
        ], 404);
    }

    /**
     * Handle validation exception.
     */
    protected function handleValidationException(CustomValidationException $e, Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error_type' => 'validation',
                'error_code' => $e->getCode(),
                'errors' => $e->getErrors(),
                'field' => $e->getField(),
                'timestamp' => now()->toISOString()
            ], 422);
        }

        return redirect()->back()
            ->withErrors($e->getErrors())
            ->withInput()
            ->with('error', $e->getMessage())
            ->with('error_type', 'validation');
    }

    /**
     * Handle business logic exception.
     */
    protected function handleBusinessLogicException(BusinessLogicException $e, Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error_type' => 'business_logic',
                'error_code' => $e->getCode(),
                'business_rule' => $e->getBusinessRule(),
                'context' => $e->getContext(),
                'timestamp' => now()->toISOString()
            ], $e->getCode());
        }

        return redirect()->back()
            ->with('error', $e->getMessage())
            ->with('error_type', 'business_logic')
            ->with('business_rule', $e->getBusinessRule())
            ->withInput();
    }

    /**
     * Handle service exception.
     */
    protected function handleServiceException(ServiceException $e, Request $request)
    {
        // Log service exceptions for debugging
        Log::error('Service Exception in Middleware', [
            'message' => $e->getMessage(),
            'service' => $e->getServiceName(),
            'operation' => $e->getOperation(),
            'context' => $e->getContext(),
            'request_url' => $request->fullUrl(),
            'user_id' => auth()->id()
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada sistem. Silakan coba lagi nanti.',
                'error_type' => 'service_error',
                'error_code' => $e->getCode(),
                'service' => $e->getServiceName(),
                'operation' => $e->getOperation(),
                'timestamp' => now()->toISOString()
            ], $e->getCode());
        }

        return response()->view('errors.500', [
            'message' => 'Terjadi kesalahan pada sistem. Silakan coba lagi nanti.',
            'error_id' => uniqid('ERR_'),
            'service' => $e->getServiceName(),
            'operation' => $e->getOperation()
        ], 500);
    }

    /**
     * Handle generic exceptions.
     */
    protected function handleGenericException(\Throwable $e, Request $request)
    {
        // Log generic exceptions
        Log::error('Unhandled Exception in Middleware', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
            'request_url' => $request->fullUrl(),
            'user_id' => auth()->id()
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => app()->environment('production') 
                    ? 'Terjadi kesalahan pada sistem. Silakan coba lagi nanti.'
                    : $e->getMessage(),
                'error_type' => 'system_error',
                'error_code' => $e->getCode() ?: 500,
                'timestamp' => now()->toISOString()
            ], 500);
        }

        return response()->view('errors.500', [
            'message' => app()->environment('production') 
                ? 'Terjadi kesalahan pada sistem. Silakan coba lagi nanti.'
                : $e->getMessage(),
            'error_id' => uniqid('ERR_'),
            'debug_info' => app()->environment('production') ? null : [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]
        ], 500);
    }

    /**
     * Determine if the request is from an API route.
     */
    protected function isApiRequest(Request $request): bool
    {
        return $request->is('api/*') || $request->expectsJson();
    }

    /**
     * Get user-friendly error message based on exception type.
     */
    protected function getUserFriendlyMessage(\Throwable $e): string
    {
        $messages = [
            'QueryException' => 'Terjadi kesalahan pada database. Silakan coba lagi.',
            'ConnectionException' => 'Tidak dapat terhubung ke database. Silakan coba lagi nanti.',
            'TimeoutException' => 'Permintaan memakan waktu terlalu lama. Silakan coba lagi.',
            'ValidationException' => 'Data yang dikirim tidak valid. Silakan periksa kembali.',
            'AuthenticationException' => 'Anda perlu login untuk mengakses halaman ini.',
            'AuthorizationException' => 'Anda tidak memiliki izin untuk mengakses halaman ini.',
        ];

        $className = class_basename($e);
        return $messages[$className] ?? 'Terjadi kesalahan yang tidak terduga. Silakan coba lagi nanti.';
    }

    /**
     * Get appropriate HTTP status code for exception.
     */
    protected function getStatusCode(\Throwable $e): int
    {
        $statusCodes = [
            'QueryException' => 500,
            'ConnectionException' => 503,
            'TimeoutException' => 408,
            'ValidationException' => 422,
            'AuthenticationException' => 401,
            'AuthorizationException' => 403,
            'ModelNotFoundException' => 404,
            'NotFoundHttpException' => 404,
        ];

        $className = class_basename($e);
        return $statusCodes[$className] ?? 500;
    }
}