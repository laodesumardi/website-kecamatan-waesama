# Custom Exceptions Guide

Panduan penggunaan custom exception handling system untuk aplikasi Kantor Camat Waesama.

## 📁 File Structure

```
app/
├── Exceptions/
│   ├── Handler.php                    # Main exception handler
│   ├── UnauthorizedException.php      # Unauthorized access
│   ├── ResourceNotFoundException.php  # Resource not found
│   ├── CustomValidationException.php  # Custom validation errors
│   ├── BusinessLogicException.php     # Business rule violations
│   └── ServiceException.php           # Service layer errors
├── Helpers/
│   └── ExceptionHelper.php            # Helper methods
├── Http/
│   ├── Controllers/
│   │   └── ExampleController.php      # Usage examples
│   └── Middleware/
│       └── ExceptionHandlerMiddleware.php # Global exception handling
└── Traits/
    └── HandlesExceptions.php          # Controller trait
```

## 🚀 Quick Start

### 1. Menggunakan ExceptionHelper (Recommended)

```php
use App\Helpers\ExceptionHelper;

// Authorization checks
ExceptionHelper::checkRole('admin');
ExceptionHelper::checkRoles(['admin', 'pegawai']);
ExceptionHelper::checkOwnership($resourceUserId);

// Validation
ExceptionHelper::validateRequired($value, 'field_name');
ExceptionHelper::validateEmail($email);
ExceptionHelper::validateNIK($nik);

// Business logic
ExceptionHelper::checkDuplicate($exists, 'email', $email);
ExceptionHelper::checkQuota($current, $limit, 'documents');
ExceptionHelper::checkExpired($expiryDate, 'license');

// Resource not found
ExceptionHelper::notFound('User tidak ditemukan', 'User', $userId);
```

### 2. Menggunakan Trait di Controller

```php
use App\Traits\HandlesExceptions;

class YourController extends Controller
{
    use HandlesExceptions;
    
    public function show($id)
    {
        // Automatic exception handling
        $user = $this->findOrFail(User::class, $id, 'User');
        
        // Check ownership
        $this->checkOwnership($user->id);
        
        return response()->json($user);
    }
    
    public function store(Request $request)
    {
        return $this->handleCrudOperation(
            function () use ($request) {
                // Your logic here
                return User::create($request->validated());
            },
            $request,
            [
                'success_message' => 'User berhasil dibuat',
                'error_message' => 'Gagal membuat user',
                'redirect_route' => 'users.index'
            ]
        );
    }
}
```

## 📋 Exception Types

### 1. UnauthorizedException
**Kapan digunakan:** Akses tidak diizinkan, role tidak sesuai

```php
// Manual
throw new UnauthorizedException('Akses ditolak untuk role ini');

// Via Helper
ExceptionHelper::unauthorized('Akses ditolak');
ExceptionHelper::checkRole('admin');
```

### 2. ResourceNotFoundException
**Kapan digunakan:** Data tidak ditemukan

```php
// Manual
throw new ResourceNotFoundException('User tidak ditemukan', 'User', $id);

// Via Helper
ExceptionHelper::notFound('Data tidak ditemukan', 'User', $id);

// Via Trait
$user = $this->findOrFail(User::class, $id, 'User');
```

### 3. CustomValidationException
**Kapan digunakan:** Validasi custom, format data salah

```php
// Manual
throw new CustomValidationException(
    ['email' => ['Format email tidak valid']],
    'Data tidak valid',
    'email'
);

// Via Helper
ExceptionHelper::validation(['email' => ['Format salah']], 'Validasi gagal');
ExceptionHelper::validateEmail($email);
```

### 4. BusinessLogicException
**Kapan digunakan:** Pelanggaran aturan bisnis

```php
// Manual
throw new BusinessLogicException(
    'Tidak dapat menghapus user yang sedang aktif',
    'Active User Deletion',
    ['user_id' => $id, 'status' => 'active']
);

// Via Helper
ExceptionHelper::businessLogic('Kuota terlampaui', 'Quota Exceeded');
ExceptionHelper::checkQuota($current, $limit, 'documents');
```

### 5. ServiceException
**Kapan digunakan:** Error di service layer, database, external API

```php
// Manual
throw new ServiceException(
    'Database connection failed',
    'Database',
    'Connection',
    ['host' => $host]
);

// Via Helper
ExceptionHelper::service('Service error', 'PaymentService', 'ProcessPayment');
ExceptionHelper::handleDatabaseError($exception, 'User Creation');
```

## 🛠️ Advanced Usage

### Transaction Handling

```php
public function createUserWithProfile(Request $request)
{
    return $this->handleTransaction(function () use ($request) {
        $user = User::create($request->validated());
        $user->profile()->create($request->profile_data);
        return $user;
    }, 'Gagal membuat user dan profil');
}
```

### File Upload Handling

```php
public function uploadAvatar(Request $request)
{
    $filePath = $this->handleFileUpload(
        $request,
        'avatar',
        'avatars',
        ['jpg', 'jpeg', 'png']
    );
    
    auth()->user()->update(['avatar' => $filePath]);
    
    return $this->successResponse(['path' => $filePath]);
}
```

### Complex Operations

```php
public function complexOperation(Request $request, $id)
{
    return $this->handleException(function () use ($request, $id) {
        // Multiple validations
        ExceptionHelper::checkRole('admin');
        $resource = $this->findOrFail(Model::class, $id);
        ExceptionHelper::checkQuota($current, $limit, 'operations');
        
        // Your logic here
        return $resource->performOperation($request->data);
    }, $request, 'Operasi gagal', 'dashboard');
}
```

## 🎯 Response Format

### JSON Response (API)
```json
{
    "success": false,
    "message": "User tidak ditemukan",
    "error_type": "not_found",
    "error_code": 404,
    "resource_type": "User",
    "resource_id": "123",
    "timestamp": "2024-01-15T10:30:00Z"
}
```

### Web Response
- Redirect dengan flash message
- Error views (403.blade.php, 404.blade.php, 500.blade.php)
- Form validation errors

## 📊 Error Views

### Custom Error Pages
- `resources/views/errors/403.blade.php` - Unauthorized
- `resources/views/errors/404.blade.php` - Not Found
- `resources/views/errors/500.blade.php` - Server Error

## 🔧 Configuration

### Middleware Registration
Middleware sudah terdaftar di `bootstrap/app.php`:

```php
$middleware->append(\App\Http\Middleware\ExceptionHandlerMiddleware::class);
```

### Logging
Semua exceptions otomatis di-log dengan context lengkap:
- User ID
- Request URL
- Exception details
- Stack trace (development)

## 💡 Best Practices

1. **Gunakan ExceptionHelper** untuk operasi umum
2. **Gunakan HandlesExceptions trait** di controller
3. **Berikan pesan error yang jelas** dan user-friendly
4. **Log semua exceptions** dengan context yang cukup
5. **Jangan expose sensitive data** di production
6. **Gunakan business logic exceptions** untuk aturan bisnis
7. **Validasi input** sebelum processing
8. **Handle database transactions** dengan proper exception handling

## 🚨 Common Patterns

### Authorization Pattern
```php
// Check role
ExceptionHelper::checkRole('admin');

// Check multiple roles
ExceptionHelper::checkRoles(['admin', 'pegawai']);

// Check ownership
ExceptionHelper::checkOwnership($resource->user_id);
```

### Validation Pattern
```php
// Required fields
$this->validateRequired($request, ['name', 'email']);

// Custom validation
ExceptionHelper::validateEmail($request->email);
ExceptionHelper::validateNIK($request->nik);

// Business validation
ExceptionHelper::checkDuplicate($exists, 'email', $email);
```

### CRUD Pattern
```php
return $this->handleCrudOperation(
    function () use ($request) {
        // Your CRUD logic
    },
    $request,
    [
        'success_message' => 'Operasi berhasil',
        'error_message' => 'Operasi gagal',
        'redirect_route' => 'index'
    ]
);
```

## 📝 Examples

Lihat `app/Http/Controllers/ExampleController.php` untuk contoh lengkap penggunaan semua jenis exceptions.

---

**Catatan:** System ini sudah terintegrasi dengan middleware global dan akan menangani semua exceptions secara otomatis dengan response format yang konsisten.