# Fix Route Conflict - admin.berita.update

## Problem
Duplicate route names detected for `admin.berita.update`:
- PUT method: `admin/berita/{berita}`
- PATCH method: `admin/berita/{berita}`

Both routes have the same name but different HTTP methods, which can cause conflicts.

## Solution

### Option 1: Rename One of the Routes (Recommended)

Edit your routes file (likely `routes/web.php` or a route file in the admin section):

```php
// Change one of these routes to have a different name

// Keep PUT for full updates
Route::put('admin/berita/{berita}', [BeritaController::class, 'update'])
    ->name('admin.berita.update');

// Rename PATCH for partial updates
Route::patch('admin/berita/{berita}', [BeritaController::class, 'patch'])
    ->name('admin.berita.patch');
```

### Option 2: Use Resource Route (Best Practice)

Replace individual routes with Laravel resource route:

```php
// Remove individual routes and use:
Route::resource('admin/berita', BeritaController::class, [
    'names' => [
        'index' => 'admin.berita.index',
        'create' => 'admin.berita.create',
        'store' => 'admin.berita.store',
        'show' => 'admin.berita.show',
        'edit' => 'admin.berita.edit',
        'update' => 'admin.berita.update',
        'destroy' => 'admin.berita.destroy',
    ]
]);
```

### Option 3: Remove Duplicate Route

If you only need one update method, remove the duplicate:

```php
// Keep only one of these:
Route::put('admin/berita/{berita}', [BeritaController::class, 'update'])
    ->name('admin.berita.update');

// Remove this line:
// Route::patch('admin/berita/{berita}', [BeritaController::class, 'update'])
//     ->name('admin.berita.update');
```

## Commands to Apply Fix

1. **Edit the route file:**
   ```bash
   nano routes/web.php
   # or
   vi routes/web.php
   ```

2. **Clear route cache:**
   ```bash
   php artisan route:clear
   ```

3. **Cache routes (optional for production):**
   ```bash
   php artisan route:cache
   ```

4. **Verify fix:**
   ```bash
   php artisan route:list | grep "admin.berita.update"
   ```

## Expected Result

After fixing, you should see only one route with the name `admin.berita.update`:

```
PUT    admin/berita/{berita}    admin.berita.update › Admin\BeritaController@update
```

## Files to Check

- `routes/web.php`
- `routes/admin.php` (if exists)
- Any route files in `routes/` directory

## Notes

- This route conflict doesn't break the website but can cause confusion
- Laravel will use the last defined route with the same name
- Using resource routes is the recommended Laravel way
- Make sure to update any forms or links that reference these routes

## Test After Fix

1. Visit admin berita section
2. Try editing a berita item
3. Verify update functionality works
4. Check for any 404 or routing errors