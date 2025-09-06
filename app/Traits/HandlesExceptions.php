<?php

namespace App\Traits;

use App\Helpers\ExceptionHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

trait HandlesExceptions
{
    /**
     * Handle exceptions in controller methods.
     *
     * @param callable $callback
     * @param Request|null $request
     * @param string|null $errorMessage
     * @param string|null $redirectRoute
     * @return mixed
     */
    protected function handleException(callable $callback, Request $request = null, string $errorMessage = null, string $redirectRoute = null)
    {
        try {
            return $callback();
        } catch (\Throwable $e) {
            return $this->handleControllerException($e, $request, $errorMessage, $redirectRoute);
        }
    }

    /**
     * Handle controller exceptions.
     */
    protected function handleControllerException(\Throwable $e, Request $request = null, string $errorMessage = null, string $redirectRoute = null)
    {
        $request = $request ?? request();
        $errorMessage = $errorMessage ?? 'Terjadi kesalahan. Silakan coba lagi.';
        $redirectRoute = $redirectRoute ?? 'dashboard';

        // Log the exception
        Log::error('Controller Exception', [
            'exception' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'controller' => static::class,
            'method' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)[2]['function'] ?? 'unknown',
            'user_id' => auth()->id(),
            'request_url' => $request->fullUrl()
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $errorMessage,
                'error_type' => 'controller_error',
                'timestamp' => now()->toISOString()
            ], 500);
        }

        return redirect()->route($redirectRoute)
            ->with('error', $errorMessage)
            ->with('error_type', 'controller_error');
    }

    /**
     * Handle CRUD operations with exception handling.
     */
    protected function handleCrudOperation(callable $operation, Request $request, array $options = [])
    {
        $defaultOptions = [
            'success_message' => 'Operasi berhasil dilakukan.',
            'error_message' => 'Terjadi kesalahan saat melakukan operasi.',
            'redirect_route' => 'dashboard',
            'log_context' => []
        ];

        $options = array_merge($defaultOptions, $options);

        try {
            $result = $operation();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $options['success_message'],
                    'data' => $result,
                    'timestamp' => now()->toISOString()
                ]);
            }

            return redirect()->route($options['redirect_route'])
                ->with('success', $options['success_message']);

        } catch (\Throwable $e) {
            // Enhanced logging with context
            Log::error('CRUD Operation Failed', array_merge([
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'controller' => static::class,
                'user_id' => auth()->id(),
                'request_data' => $request->except(['password', 'password_confirmation'])
            ], $options['log_context']));

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $options['error_message'],
                    'error_type' => 'crud_error',
                    'timestamp' => now()->toISOString()
                ], 500);
            }

            return redirect()->back()
                ->with('error', $options['error_message'])
                ->withInput();
        }
    }

    /**
     * Validate and handle authorization.
     */
    protected function authorizeAction(string $ability, $resource = null, string $message = null)
    {
        try {
            $this->authorize($ability, $resource);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $message = $message ?? 'Anda tidak memiliki izin untuk melakukan aksi ini.';
            ExceptionHelper::unauthorized($message);
        }
    }

    /**
     * Validate required fields.
     */
    protected function validateRequired(Request $request, array $fields, array $customMessages = [])
    {
        $errors = [];
        
        foreach ($fields as $field) {
            if (!$request->has($field) || empty($request->input($field))) {
                $message = $customMessages[$field] ?? "Field {$field} wajib diisi.";
                $errors[$field] = [$message];
            }
        }

        if (!empty($errors)) {
            ExceptionHelper::validation($errors, 'Data yang dikirim tidak lengkap.');
        }
    }

    /**
     * Find model or throw exception.
     */
    protected function findOrFail($model, $id, string $resourceType = null)
    {
        try {
            if (is_string($model)) {
                $model = app($model);
            }
            
            return $model->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $resourceType = $resourceType ?? class_basename($model);
            ExceptionHelper::notFound(
                "Data {$resourceType} dengan ID {$id} tidak ditemukan.",
                $resourceType,
                $id
            );
        }
    }

    /**
     * Check ownership of resource.
     */
    protected function checkOwnership($resource, $userId = null, string $message = null)
    {
        $userId = $userId ?? auth()->id();
        $resourceUserId = is_object($resource) ? $resource->user_id : $resource;
        $message = $message ?? 'Anda hanya dapat mengakses data milik Anda sendiri.';

        if ($resourceUserId != $userId) {
            ExceptionHelper::unauthorized($message);
        }
    }

    /**
     * Handle file upload with exception handling.
     */
    protected function handleFileUpload(Request $request, string $fieldName, string $directory, array $allowedTypes = [])
    {
        try {
            if (!$request->hasFile($fieldName)) {
                ExceptionHelper::validation(
                    [$fieldName => ['File wajib diunggah.']],
                    'File tidak ditemukan.',
                    $fieldName
                );
            }

            $file = $request->file($fieldName);

            // Validate file type if specified
            if (!empty($allowedTypes) && !in_array($file->getClientOriginalExtension(), $allowedTypes)) {
                $allowedStr = implode(', ', $allowedTypes);
                ExceptionHelper::validation(
                    [$fieldName => ["Tipe file tidak diizinkan. Tipe yang diizinkan: {$allowedStr}"]],
                    'Tipe file tidak valid.',
                    $fieldName
                );
            }

            // Validate file size (max 10MB)
            if ($file->getSize() > 10 * 1024 * 1024) {
                ExceptionHelper::validation(
                    [$fieldName => ['Ukuran file maksimal 10MB.']],
                    'Ukuran file terlalu besar.',
                    $fieldName
                );
            }

            return $file->store($directory, 'public');

        } catch (\Exception $e) {
            Log::error('File Upload Error', [
                'field' => $fieldName,
                'directory' => $directory,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            ExceptionHelper::service(
                'Gagal mengunggah file. Silakan coba lagi.',
                'FileUpload',
                'Upload',
                ['field' => $fieldName, 'directory' => $directory]
            );
        }
    }

    /**
     * Handle database transaction with exception handling.
     */
    protected function handleTransaction(callable $callback, string $errorMessage = null)
    {
        $errorMessage = $errorMessage ?? 'Terjadi kesalahan saat menyimpan data.';

        try {
            return \DB::transaction($callback);
        } catch (\Exception $e) {
            Log::error('Transaction Error', [
                'error' => $e->getMessage(),
                'controller' => static::class,
                'user_id' => auth()->id()
            ]);

            ExceptionHelper::handleDatabaseError($e, 'Transaction');
        }
    }

    /**
     * Return success response.
     */
    protected function successResponse($data = null, string $message = 'Operasi berhasil.', int $status = 200)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data,
                'timestamp' => now()->toISOString()
            ], $status);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Return error response.
     */
    protected function errorResponse(string $message = 'Terjadi kesalahan.', int $status = 500, array $errors = [])
    {
        if (request()->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
                'errors' => $errors,
                'timestamp' => now()->toISOString()
            ], $status);
        }

        return redirect()->back()
            ->with('error', $message)
            ->withErrors($errors)
            ->withInput();
    }
}