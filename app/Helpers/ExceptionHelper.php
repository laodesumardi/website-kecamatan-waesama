<?php

namespace App\Helpers;

use App\Exceptions\UnauthorizedException;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\CustomValidationException;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Log;

class ExceptionHelper
{
    /**
     * Throw unauthorized exception.
     *
     * @param string|null $message
     * @param int $code
     * @throws UnauthorizedException
     */
    public static function unauthorized($message = null, $code = 403)
    {
        throw new UnauthorizedException($message, $code);
    }

    /**
     * Throw resource not found exception.
     *
     * @param string|null $message
     * @param string|null $resourceType
     * @param mixed $resourceId
     * @throws ResourceNotFoundException
     */
    public static function notFound($message = null, $resourceType = null, $resourceId = null)
    {
        throw new ResourceNotFoundException($message, $resourceType, $resourceId);
    }

    /**
     * Throw validation exception.
     *
     * @param string|array $errors
     * @param string|null $message
     * @param string|null $field
     * @throws CustomValidationException
     */
    public static function validation($errors, $message = null, $field = null)
    {
        throw new CustomValidationException($errors, $message, $field);
    }

    /**
     * Throw business logic exception.
     *
     * @param string|null $message
     * @param string|null $businessRule
     * @param array $context
     * @param int $code
     * @throws BusinessLogicException
     */
    public static function businessLogic($message = null, $businessRule = null, array $context = [], $code = 422)
    {
        throw new BusinessLogicException($message, $businessRule, $context, $code);
    }

    /**
     * Throw service exception.
     *
     * @param string|null $message
     * @param string|null $serviceName
     * @param string|null $operation
     * @param array $context
     * @param int $code
     * @throws ServiceException
     */
    public static function service($message = null, $serviceName = null, $operation = null, array $context = [], $code = 500)
    {
        throw new ServiceException($message, $serviceName, $operation, $context, $code);
    }

    /**
     * Common authorization checks.
     */
    public static function checkRole($requiredRole, $userRole = null)
    {
        $userRole = $userRole ?? auth()->user()?->role?->name;
        
        if (!$userRole || $userRole !== $requiredRole) {
            self::unauthorized("Akses ditolak. Role '{$requiredRole}' diperlukan.");
        }
    }

    public static function checkRoles(array $requiredRoles, $userRole = null)
    {
        $userRole = $userRole ?? auth()->user()?->role?->name;
        
        if (!$userRole || !in_array($userRole, $requiredRoles)) {
            $rolesStr = implode(', ', $requiredRoles);
            self::unauthorized("Akses ditolak. Salah satu role berikut diperlukan: {$rolesStr}.");
        }
    }

    public static function checkOwnership($resourceUserId, $currentUserId = null)
    {
        $currentUserId = $currentUserId ?? auth()->id();
        
        if ($resourceUserId != $currentUserId) {
            self::unauthorized('Anda hanya dapat mengakses data milik Anda sendiri.');
        }
    }

    /**
     * Common validation checks.
     */
    public static function validateRequired($value, $fieldName)
    {
        if (empty($value)) {
            self::validation([$fieldName => ["Field {$fieldName} wajib diisi."]], null, $fieldName);
        }
    }

    public static function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            self::validation(['email' => ['Format email tidak valid.']], null, 'email');
        }
    }

    public static function validateNIK($nik)
    {
        if (!preg_match('/^[0-9]{16}$/', $nik)) {
            self::validation(['nik' => ['NIK harus terdiri dari 16 digit angka.']], null, 'nik');
        }
    }

    public static function validatePhone($phone)
    {
        if (!preg_match('/^(\+62|62|0)[0-9]{9,13}$/', $phone)) {
            self::validation(['phone' => ['Format nomor telepon tidak valid.']], null, 'phone');
        }
    }

    /**
     * Common business logic checks.
     */
    public static function checkDuplicate($exists, $field, $value)
    {
        if ($exists) {
            self::businessLogic(
                "Data dengan {$field} '{$value}' sudah ada.",
                'Duplicate Data',
                ['field' => $field, 'value' => $value]
            );
        }
    }

    public static function checkQuota($current, $limit, $resource)
    {
        if ($current >= $limit) {
            self::businessLogic(
                "Kuota {$resource} telah mencapai batas maksimal ({$limit}).",
                'Quota Exceeded',
                ['current' => $current, 'limit' => $limit, 'resource' => $resource]
            );
        }
    }

    public static function checkExpired($expiryDate, $item)
    {
        if (now()->gt($expiryDate)) {
            self::businessLogic(
                "{$item} telah kedaluwarsa.",
                'Expired Data',
                ['expiry_date' => $expiryDate, 'item' => $item]
            );
        }
    }

    public static function checkStatus($currentStatus, $allowedStatuses, $action)
    {
        if (!in_array($currentStatus, $allowedStatuses)) {
            $allowedStr = implode(', ', $allowedStatuses);
            self::businessLogic(
                "Tidak dapat {$action} dengan status '{$currentStatus}'. Status yang diizinkan: {$allowedStr}.",
                'Invalid Status',
                ['current_status' => $currentStatus, 'allowed_statuses' => $allowedStatuses, 'action' => $action]
            );
        }
    }

    /**
     * Log and throw service exceptions.
     */
    public static function logAndThrow($message, $context = [], $level = 'error')
    {
        Log::$level($message, $context);
        self::service($message, 'System', 'Operation', $context);
    }

    /**
     * Handle database exceptions.
     */
    public static function handleDatabaseError($exception, $operation = 'Database Operation')
    {
        $message = 'Terjadi kesalahan pada database.';
        $context = [
            'exception_message' => $exception->getMessage(),
            'exception_code' => $exception->getCode(),
            'operation' => $operation
        ];

        Log::error('Database error occurred', $context);
        self::service($message, 'Database', $operation, $context);
    }

    /**
     * Handle external API exceptions.
     */
    public static function handleApiError($exception, $apiName = 'External API', $endpoint = null)
    {
        $message = "Terjadi kesalahan saat mengakses {$apiName}.";
        $context = [
            'api_name' => $apiName,
            'endpoint' => $endpoint,
            'exception_message' => $exception->getMessage(),
            'exception_code' => $exception->getCode()
        ];

        Log::error('External API error occurred', $context);
        self::service($message, $apiName, 'API Call', $context);
    }
}