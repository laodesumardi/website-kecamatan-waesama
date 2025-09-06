<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\ExceptionHelper;
use App\Traits\HandlesExceptions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Example Controller demonstrating custom exception usage.
 * This controller shows how to use custom exceptions in various scenarios.
 */
class ExampleController extends Controller
{
    use HandlesExceptions;

    /**
     * Example: Authorization check with custom exception.
     */
    public function adminOnlyAction()
    {
        // Check if user has admin role
        ExceptionHelper::checkRole('admin');
        
        return response()->json([
            'message' => 'Welcome admin!',
            'data' => 'This is admin-only content'
        ]);
    }

    /**
     * Example: Multiple role authorization.
     */
    public function staffAction()
    {
        // Check if user has admin or pegawai role
        ExceptionHelper::checkRoles(['admin', 'pegawai']);
        
        return response()->json([
            'message' => 'Welcome staff member!',
            'data' => 'This is staff content'
        ]);
    }

    /**
     * Example: Resource not found exception.
     */
    public function getUserById($id)
    {
        // Using helper method that throws ResourceNotFoundException if not found
        $user = $this->findOrFail(User::class, $id, 'User');
        
        return response()->json([
            'message' => 'User found',
            'data' => $user
        ]);
    }

    /**
     * Example: Ownership check.
     */
    public function getUserProfile($userId)
    {
        $user = $this->findOrFail(User::class, $userId, 'User');
        
        // Check if current user can access this profile
        // Admin can access any profile, others can only access their own
        if (auth()->user()->role->name !== 'admin') {
            $this->checkOwnership($user->id);
        }
        
        return response()->json([
            'message' => 'Profile retrieved successfully',
            'data' => $user
        ]);
    }

    /**
     * Example: Custom validation with exception.
     */
    public function validateUserData(Request $request)
    {
        // Validate required fields
        $this->validateRequired($request, ['name', 'email', 'nik']);
        
        // Custom validation for NIK
        ExceptionHelper::validateNIK($request->nik);
        
        // Custom validation for email
        ExceptionHelper::validateEmail($request->email);
        
        // Check for duplicate NIK
        $existingUser = User::where('nik', $request->nik)->first();
        ExceptionHelper::checkDuplicate($existingUser, 'NIK', $request->nik);
        
        return response()->json([
            'message' => 'Validation passed',
            'data' => $request->only(['name', 'email', 'nik'])
        ]);
    }

    /**
     * Example: Business logic validation.
     */
    public function changeUserStatus(Request $request, $userId)
    {
        $user = $this->findOrFail(User::class, $userId, 'User');
        $newStatus = $request->status;
        
        // Check if status transition is valid
        $allowedStatuses = ['active', 'inactive', 'suspended'];
        ExceptionHelper::checkStatus($user->status, $allowedStatuses, 'mengubah status');
        
        // Business rule: Only admin can suspend users
        if ($newStatus === 'suspended') {
            ExceptionHelper::checkRole('admin');
        }
        
        // Business rule: Cannot change status of yourself
        if ($user->id === auth()->id()) {
            ExceptionHelper::businessLogic(
                'Anda tidak dapat mengubah status akun Anda sendiri.',
                'Self Status Change',
                ['user_id' => $user->id, 'new_status' => $newStatus]
            );
        }
        
        $user->update(['status' => $newStatus]);
        
        return response()->json([
            'message' => 'Status berhasil diubah',
            'data' => $user
        ]);
    }

    /**
     * Example: File upload with exception handling.
     */
    public function uploadAvatar(Request $request)
    {
        // Handle file upload with validation
        $filePath = $this->handleFileUpload(
            $request, 
            'avatar', 
            'avatars', 
            ['jpg', 'jpeg', 'png', 'gif']
        );
        
        // Update user avatar
        auth()->user()->update(['avatar' => $filePath]);
        
        return response()->json([
            'message' => 'Avatar berhasil diunggah',
            'data' => ['avatar_path' => $filePath]
        ]);
    }

    /**
     * Example: Database transaction with exception handling.
     */
    public function createUserWithProfile(Request $request)
    {
        $result = $this->handleTransaction(function () use ($request) {
            // Validate data first
            $this->validateRequired($request, ['name', 'email', 'password', 'nik']);
            
            // Check for duplicates
            $existingEmail = User::where('email', $request->email)->first();
            ExceptionHelper::checkDuplicate($existingEmail, 'email', $request->email);
            
            $existingNik = User::where('nik', $request->nik)->first();
            ExceptionHelper::checkDuplicate($existingNik, 'NIK', $request->nik);
            
            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nik' => $request->nik,
                'role_id' => 3, // Default to 'warga' role
                'status' => 'active'
            ]);
            
            // Create user profile (example)
            // $user->profile()->create($request->only(['phone', 'address']));
            
            return $user;
        }, 'Gagal membuat user dan profil.');
        
        return response()->json([
            'message' => 'User dan profil berhasil dibuat',
            'data' => $result
        ]);
    }

    /**
     * Example: Service exception handling.
     */
    public function processExternalData(Request $request)
    {
        try {
            // Simulate external API call
            $response = $this->callExternalAPI($request->data);
            
            return response()->json([
                'message' => 'Data berhasil diproses',
                'data' => $response
            ]);
            
        } catch (\Exception $e) {
            // Handle external API errors
            ExceptionHelper::handleApiError($e, 'External Data Service', '/api/process-data');
        }
    }

    /**
     * Example: Using CRUD operation handler.
     */
    public function updateUser(Request $request, $userId)
    {
        return $this->handleCrudOperation(
            function () use ($request, $userId) {
                $user = $this->findOrFail(User::class, $userId, 'User');
                
                // Check ownership or admin role
                if (auth()->user()->role->name !== 'admin') {
                    $this->checkOwnership($user->id);
                }
                
                // Validate and update
                $user->update($request->only(['name', 'email', 'phone']));
                
                return $user;
            },
            $request,
            [
                'success_message' => 'Data user berhasil diperbarui.',
                'error_message' => 'Gagal memperbarui data user.',
                'redirect_route' => 'users.index',
                'log_context' => ['user_id' => $userId]
            ]
        );
    }

    /**
     * Example: Quota check.
     */
    public function createDocument(Request $request)
    {
        $user = auth()->user();
        $currentDocuments = $user->documents()->count();
        $maxDocuments = 10; // Example limit
        
        // Check quota
        ExceptionHelper::checkQuota($currentDocuments, $maxDocuments, 'dokumen');
        
        // Create document logic here...
        
        return response()->json([
            'message' => 'Dokumen berhasil dibuat',
            'quota_used' => $currentDocuments + 1,
            'quota_limit' => $maxDocuments
        ]);
    }

    /**
     * Simulate external API call.
     */
    private function callExternalAPI($data)
    {
        // Simulate API call that might fail
        if (rand(1, 10) > 7) {
            throw new \Exception('External API is temporarily unavailable');
        }
        
        return ['processed' => true, 'data' => $data];
    }

    /**
     * Example: Multiple exception types in one method.
     */
    public function complexOperation(Request $request, $resourceId)
    {
        // Authorization check
        ExceptionHelper::checkRoles(['admin', 'pegawai']);
        
        // Resource validation
        $resource = $this->findOrFail(User::class, $resourceId, 'Resource');
        
        // Business logic validation
        if ($resource->status === 'deleted') {
            ExceptionHelper::businessLogic(
                'Tidak dapat melakukan operasi pada resource yang telah dihapus.',
                'Deleted Resource Operation',
                ['resource_id' => $resourceId, 'status' => $resource->status]
            );
        }
        
        // Data validation
        $this->validateRequired($request, ['operation_type']);
        
        // Quota check
        $operations = $resource->operations()->today()->count();
        ExceptionHelper::checkQuota($operations, 5, 'operasi harian');
        
        return $this->successResponse(
            ['resource' => $resource, 'operation' => $request->operation_type],
            'Operasi kompleks berhasil dilakukan.'
        );
    }
}