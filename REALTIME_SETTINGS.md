# Fitur Real-time Settings Update

## Deskripsi
Fitur ini memungkinkan pengaturan di halaman "Pengaturan Umum" untuk diperbarui secara real-time tanpa perlu menekan tombol "Simpan Pengaturan". Setiap perubahan yang dilakukan akan langsung tersimpan dan diterapkan ke seluruh sistem.

## Cara Kerja

### 1. Backend Components

#### SettingsHelper (`app/Helpers/SettingsHelper.php`)
- Helper class untuk mengelola pengaturan sistem
- Menyediakan method untuk get, set, dan update multiple settings
- Menggunakan Laravel Cache untuk penyimpanan

#### SettingsServiceProvider (`app/Providers/SettingsServiceProvider.php`)
- Service provider untuk mendaftarkan SettingsHelper
- Membagikan pengaturan global ke semua view

#### SettingsController Update
- Method `updateRealtime()` untuk menangani AJAX request
- Validasi real-time untuk setiap field
- Response JSON dengan status dan pesan

### 2. Frontend Components

#### JavaScript Real-time Update
- Event listener untuk `blur` pada text input dan textarea
- Event listener untuk `change` pada checkbox
- AJAX request ke endpoint `/admin/settings/update-realtime`
- Visual feedback dengan loading, success, dan error indicators
- Toast notifications untuk feedback user

### 3. Route
```php
Route::post('settings/update-realtime', [SettingsController::class, 'updateRealtime'])->name('settings.update-realtime');
```

## Field yang Didukung

1. **Informasi Situs**
   - `site_name` - Nama Situs
   - `site_description` - Deskripsi Situs

2. **Informasi Kontak**
   - `contact_email` - Email Kontak
   - `contact_phone` - Nomor Telepon

3. **Informasi Kantor**
   - `office_address` - Alamat Kantor
   - `office_hours` - Jam Operasional

4. **Pengaturan Sistem**
   - `max_queue_per_day` - Maksimal Antrian per Hari
   - `auto_approve_letters` - Otomatis Setujui Surat
   - `notification_email` - Notifikasi Email
   - `maintenance_mode` - Mode Maintenance

## Validasi

Setiap field memiliki validasi yang sesuai:
- Text fields: required, max length
- Email: valid email format
- Number: integer, min/max values
- Boolean: true/false values

## Visual Feedback

1. **Loading State**: Border biru dan background biru muda dengan spinner icon
2. **Success State**: Border hijau dan background hijau muda dengan toast notification
3. **Error State**: Border merah dan background merah muda dengan toast notification

## Penggunaan

1. Buka halaman `/admin/settings`
2. Ubah nilai pada field yang diinginkan
3. Untuk text input/textarea: klik di luar field (blur event)
4. Untuk checkbox: langsung klik checkbox (change event)
5. Sistem akan otomatis menyimpan dan memberikan feedback visual

## Keuntungan

- **User Experience**: Tidak perlu scroll ke bawah untuk menekan tombol simpan
- **Real-time**: Perubahan langsung tersimpan dan diterapkan
- **Visual Feedback**: User tahu kapan perubahan berhasil atau gagal
- **Validasi Instant**: Error validation langsung ditampilkan
- **Efisiensi**: Hanya field yang diubah yang dikirim ke server

## Catatan Teknis

- Menggunakan jQuery untuk DOM manipulation dan AJAX
- Settings disimpan dalam Laravel Cache dengan TTL 1 tahun
- CSRF protection tetap aktif untuk keamanan
- Error handling yang komprehensif
- Toast notifications auto-dismiss setelah 3 detik