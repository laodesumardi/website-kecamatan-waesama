<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Daftar - <?php echo e(config('app.name', 'Kantor Camat Waesama')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        :root {
            --primary-color: #001d3d;
            --primary-light: #003566;
            --primary-lighter: #0077b6;
            --primary-dark: #000814;
            --primary-100: #e6f2ff;
            --primary-200: #b3d9ff;
            --primary-300: #80bfff;
            --accent-blue: #00b4d8;
            --accent-cyan: #90e0ef;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Background Gradient */
        .gradient-bg {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 35%, var(--primary-lighter) 100%);
            position: relative;
            overflow: hidden;
        }

        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 80%, rgba(0, 180, 216, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(144, 224, 239, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(0, 53, 102, 0.2) 0%, transparent 50%);
            animation: floating 20s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(1deg); }
            66% { transform: translateY(10px) rotate(-1deg); }
        }

        /* Glass Effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 45px rgba(0, 29, 61, 0.1);
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        .slide-up {
            animation: slideUp 0.8s ease-out;
        }

        .slide-up:nth-child(2) { animation-delay: 0.2s; }
        .slide-up:nth-child(3) { animation-delay: 0.4s; }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Section Headers */
        .section-header {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1.125rem;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid var(--primary-100);
            display: flex;
            align-items: center;
        }

        .section-header i {
            color: var(--primary-light);
            margin-right: 0.5rem;
            font-size: 1.25rem;
        }

        /* Form Styling */
        .form-label {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .form-input {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
            background: #ffffff;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
        }

        .form-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 29, 61, 0.1);
            outline: none;
        }

        .form-input:hover {
            border-color: var(--primary-light);
        }

        /* Textarea specific */
        textarea.form-input {
            resize: vertical;
            min-height: 80px;
        }

        /* Radio Button Styling */
        .radio-group {
            display: flex;
            gap: 2rem;
            margin-top: 0.5rem;
        }

        .radio-item {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .radio-input {
            width: 1.25rem;
            height: 1.25rem;
            accent-color: var(--primary-color);
            margin-right: 0.5rem;
        }

        .radio-input:focus {
            box-shadow: 0 0 0 2px rgba(0, 29, 61, 0.2);
        }

        /* Button Styling */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            transition: all 0.3s ease;
            transform: translateY(0);
            box-shadow: 0 4px 15px rgba(0, 29, 61, 0.2);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 0.5rem;
            border: none;
            color: white;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-light), var(--primary-lighter));
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 29, 61, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 4px 15px rgba(0, 29, 61, 0.2);
        }

        /* Icon Styling */
        .icon-primary {
            color: var(--primary-color);
        }

        .icon-secondary {
            color: var(--primary-light);
            transition: color 0.2s ease;
        }

        .icon-hover:hover {
            color: var(--primary-color);
        }

        /* Link Styling */
        .link-primary {
            color: var(--primary-color);
            transition: color 0.2s ease;
        }

        .link-primary:hover {
            color: var(--primary-light);
        }

        /* Logo Container */
        .logo-container {
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            border: 3px solid rgba(0, 29, 61, 0.1);
            transition: all 0.3s ease;
        }

        .logo-container:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(0, 29, 61, 0.2);
        }

        /* Error Message Styling */
        .error-message {
            color: #dc2626;
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
        }

        .error-message i {
            margin-right: 0.25rem;
        }

        /* Password Toggle Button */
        .password-toggle {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.25rem;
            transition: background-color 0.2s ease;
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
        }

        .password-toggle:hover {
            background-color: rgba(0, 29, 61, 0.1);
        }

        /* Grid Layout */
        .form-grid {
            display: grid;
            gap: 1rem;
        }

        .form-grid-2 {
            grid-template-columns: 1fr;
        }

        @media (min-width: 768px) {
            .form-grid-2 {
                grid-template-columns: 1fr 1fr;
            }
        }

        .form-grid-full {
            grid-column: 1 / -1;
        }

        /* Validation Indicators */
        .form-input.valid {
            border-color: #10b981;
            background-color: #f0fdf4;
        }

        .form-input.invalid {
            border-color: #ef4444;
            background-color: #fef2f2;
        }

        /* Loading State */
        .loading {
            position: relative;
            overflow: hidden;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 29, 61, 0.1), transparent);
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .glass-effect {
                margin: 1rem;
                padding: 1.5rem;
            }

            .logo-container {
                width: 4rem;
                height: 4rem;
            }

            .logo-container i {
                font-size: 1.5rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            .radio-group {
                gap: 1rem;
                flex-direction: column;
            }
        }

        /* Focus visible for accessibility */
        .form-input:focus-visible,
        .btn-primary:focus-visible,
        .password-toggle:focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* Progress indicator */
        .form-progress {
            height: 4px;
            background-color: #f3f4f6;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .form-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
            width: 0%;
            transition: width 0.3s ease;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen gradient-bg flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto h-20 w-20 logo-container rounded-full flex items-center justify-center shadow-lg mb-6 fade-in">
                    <i class="fas fa-user-plus text-3xl icon-primary"></i>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2 slide-up">Daftar Akun Baru</h2>
                <p class="text-blue-200 slide-up">Silakan lengkapi data diri Anda untuk mendaftar di Kantor Camat Waesama</p>
            </div>

            <!-- Register Form -->
            <div class="glass-effect rounded-2xl shadow-2xl p-8 slide-up">
                <!-- Progress Bar -->
                <div class="form-progress">
                    <div class="form-progress-bar" id="progressBar"></div>
                </div>

                <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-8" id="registerForm">
                    <?php echo csrf_field(); ?>

                    <!-- Personal Information Section -->
                    <div>
                        <div class="section-header">
                            <i class="fas fa-user"></i>
                            Informasi Pribadi
                        </div>

                        <div class="form-grid form-grid-2">
                            <!-- Name -->
                            <div>
                                <label for="name" class="form-label">
                                    <i class="fas fa-id-card mr-2 icon-primary"></i>Nama Lengkap
                                </label>
                                <input id="name"
                                       type="text"
                                       name="name"
                                       value="<?php echo e(old('name')); ?>"
                                       required
                                       autofocus
                                       autocomplete="name"
                                       class="form-input w-full"
                                       placeholder="Masukkan nama lengkap">
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- NIK -->
                            <div>
                                <label for="nik" class="form-label">
                                    <i class="fas fa-id-badge mr-2 icon-primary"></i>NIK
                                </label>
                                <input id="nik"
                                       type="text"
                                       name="nik"
                                       value="<?php echo e(old('nik')); ?>"
                                       required
                                       maxlength="16"
                                       pattern="[0-9]{16}"
                                       class="form-input w-full"
                                       placeholder="16 digit NIK">
                                <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone mr-2 icon-primary"></i>Nomor Telepon
                                </label>
                                <input id="phone"
                                       type="tel"
                                       name="phone"
                                       value="<?php echo e(old('phone')); ?>"
                                       required
                                       class="form-input w-full"
                                       placeholder="08xxxxxxxxxx">
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Birth Date -->
                            <div>
                                <label for="birth_date" class="form-label">
                                    <i class="fas fa-calendar mr-2 icon-primary"></i>Tanggal Lahir
                                </label>
                                <input id="birth_date"
                                       type="date"
                                       name="birth_date"
                                       value="<?php echo e(old('birth_date')); ?>"
                                       required
                                       class="form-input w-full">
                                <?php $__errorArgs = ['birth_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Gender -->
                            <div class="form-grid-full">
                                <label class="form-label">
                                    <i class="fas fa-venus-mars mr-2 icon-primary"></i>Jenis Kelamin
                                </label>
                                <div class="radio-group">
                                    <label class="radio-item">
                                        <input type="radio" name="gender" value="L" <?php echo e(old('gender') == 'L' ? 'checked' : ''); ?> required
                                               class="radio-input">
                                        <span class="text-sm text-gray-700 font-medium">Laki-laki</span>
                                    </label>
                                    <label class="radio-item">
                                        <input type="radio" name="gender" value="P" <?php echo e(old('gender') == 'P' ? 'checked' : ''); ?> required
                                               class="radio-input">
                                        <span class="text-sm text-gray-700 font-medium">Perempuan</span>
                                    </label>
                                </div>
                                <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Address -->
                            <div class="form-grid-full">
                                <label for="address" class="form-label">
                                    <i class="fas fa-map-marker-alt mr-2 icon-primary"></i>Alamat Lengkap
                                </label>
                                <textarea id="address"
                                          name="address"
                                          rows="3"
                                          required
                                          class="form-input w-full"
                                          placeholder="Masukkan alamat lengkap"><?php echo e(old('address')); ?></textarea>
                                <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Account Information Section -->
                    <div>
                        <div class="section-header">
                            <i class="fas fa-key"></i>
                            Informasi Akun
                        </div>

                        <div class="form-grid form-grid-2">
                            <!-- Email -->
                            <div class="form-grid-full">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope mr-2 icon-primary"></i>Email
                                </label>
                                <input id="email"
                                       type="email"
                                       name="email"
                                       value="<?php echo e(old('email')); ?>"
                                       required
                                       autocomplete="username"
                                       class="form-input w-full"
                                       placeholder="Masukkan email Anda">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock mr-2 icon-primary"></i>Password
                                </label>
                                <div class="relative">
                                    <input id="password"
                                           type="password"
                                           name="password"
                                           required
                                           autocomplete="new-password"
                                           class="form-input w-full pr-12"
                                           placeholder="Minimal 8 karakter">
                                    <button type="button"
                                            onclick="togglePassword('password', 'password-icon')"
                                            class="password-toggle icon-secondary icon-hover">
                                        <i id="password-icon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-lock mr-2 icon-primary"></i>Konfirmasi Password
                                </label>
                                <div class="relative">
                                    <input id="password_confirmation"
                                           type="password"
                                           name="password_confirmation"
                                           required
                                           autocomplete="new-password"
                                           class="form-input w-full pr-12"
                                           placeholder="Ulangi password">
                                    <button type="button"
                                            onclick="togglePassword('password_confirmation', 'password-confirmation-icon')"
                                            class="password-toggle icon-secondary icon-hover">
                                        <i id="password-confirmation-icon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button type="submit"
                                class="w-full btn-primary">
                            <i class="fas fa-user-plus mr-2"></i>
                            <span id="button-text">Daftar Sekarang</span>
                            <i id="loading-spinner" class="fas fa-spinner fa-spin ml-2 hidden"></i>
                        </button>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600">
                            Sudah punya akun?
                            <a href="<?php echo e(route('login')); ?>" class="link-primary font-medium">
                                Masuk di sini
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-sm text-blue-200">
                    © 2024 Kantor Camat Waesama. Semua hak dilindungi.
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const passwordIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        // Form validation and progress tracking
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            const progressBar = document.getElementById('progressBar');
            const requiredFields = form.querySelectorAll('input[required], textarea[required]');

            function updateProgress() {
                let filledFields = 0;
                requiredFields.forEach(field => {
                    if (field.type === 'radio') {
                        if (form.querySelector(`input[name="${field.name}"]:checked`)) {
                            filledFields++;
                        }
                    } else if (field.value.trim() !== '') {
                        filledFields++;
                    }
                });

                const progress = (filledFields / requiredFields.length) * 100;
                progressBar.style.width = progress + '%';
            }

            // Add event listeners for progress tracking
            requiredFields.forEach(field => {
                field.addEventListener('input', updateProgress);
                field.addEventListener('change', updateProgress);
            });

            // Initial progress check
            updateProgress();
        });

        // NIK validation
        document.getElementById('nik').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '').slice(0, 16);
            validateField(e.target);
        });

        // Phone validation
        document.getElementById('phone').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
            validateField(e.target);
        });

        // Password matching validation
        document.getElementById('password_confirmation').addEventListener('input', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = e.target.value;

            if (confirmPassword === '') {
                e.target.classList.remove('valid', 'invalid');
            } else if (password === confirmPassword) {
                e.target.classList.remove('invalid');
                e.target.classList.add('valid');
            } else {
                e.target.classList.remove('valid');
                e.target.classList.add('invalid');
            }
        });

        // Field validation function
        function validateField(field) {
            if (field.type === 'email') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (emailRegex.test(field.value)) {
                    field.classList.remove('invalid');
                    field.classList.add('valid');
                } else if (field.value !== '') {
                    field.classList.remove('valid');
                    field.classList.add('invalid');
                }
            } else if (field.name === 'nik') {
                if (field.value.length === 16) {
                    field.classList.remove('invalid');
                    field.classList.add('valid');
                } else if (field.value.length > 0) {
                    field.classList.remove('valid');
                    field.classList.add('invalid');
                }
            } else if (field.required && field.value.trim() !== '') {
                field.classList.remove('invalid');
                field.classList.add('valid');
            }
        }

        // Form submission with loading state
        document.getElementById('registerForm').addEventListener('submit', function() {
            const submitButton = this.querySelector('button[type="submit"]');
            const buttonText = document.getElementById('button-text');
            const loadingSpinner = document.getElementById('loading-spinner');

            // Disable button and show loading
            submitButton.disabled = true;
            buttonText.textContent = 'Mendaftar...';
            loadingSpinner.classList.remove('hidden');

            // Add loading class to form
            this.classList.add('loading');
        });
    </script>
</body>
</html>
<?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\auth\register.blade.php ENDPATH**/ ?>