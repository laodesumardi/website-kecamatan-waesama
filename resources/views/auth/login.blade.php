<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'Kantor Camat Waesama') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

        /* Form Styling */
        .form-label {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 0.875rem;
        }

        .form-input {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
            background: #ffffff;
        }

        .form-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 29, 61, 0.1);
            outline: none;
        }

        .form-input:hover {
            border-color: var(--primary-light);
        }

        /* Button Styling */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            transition: all 0.3s ease;
            transform: translateY(0);
            box-shadow: 0 4px 15px rgba(0, 29, 61, 0.2);
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

        /* Checkbox Styling */
        .checkbox-primary {
            accent-color: var(--primary-color);
        }

        .checkbox-primary:focus {
            box-shadow: 0 0 0 2px rgba(0, 29, 61, 0.2);
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
        }

        /* Success Message Styling */
        .success-message {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
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
        @media (max-width: 640px) {
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
        }

        /* Password Toggle Button */
        .password-toggle {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.25rem;
            transition: background-color 0.2s ease;
        }

        .password-toggle:hover {
            background-color: rgba(0, 29, 61, 0.1);
        }

        /* Focus visible for accessibility */
        .form-input:focus-visible,
        .btn-primary:focus-visible,
        .password-toggle:focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* Custom scrollbar if needed */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-light);
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen gradient-bg flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto h-20 w-20 logo-container rounded-full flex items-center justify-center shadow-lg mb-6 fade-in">
                    <i class="fas fa-building text-3xl icon-primary"></i>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2 slide-up">Selamat Datang</h2>
                <p class="text-blue-200 slide-up">Silakan masuk ke akun Anda di Kantor Camat Waesama</p>
            </div>

            <!-- Login Form -->
            <div class="glass-effect rounded-2xl shadow-2xl p-8 slide-up">
                <!-- Session Status -->
                @if(session('status'))
                    <div class="success-message">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6" id="loginForm">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block form-label mb-2">
                            <i class="fas fa-envelope mr-2 icon-primary"></i>Email
                        </label>
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username"
                               class="form-input appearance-none relative block w-full px-4 py-3 placeholder-gray-500 text-gray-900 rounded-lg sm:text-sm"
                               placeholder="Masukkan email Anda">
                        @error('email')
                            <p class="error-message">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block form-label mb-2">
                            <i class="fas fa-lock mr-2 icon-primary"></i>Password
                        </label>
                        <div class="relative">
                            <input id="password"
                                   type="password"
                                   name="password"
                                   required
                                   autocomplete="current-password"
                                   class="form-input appearance-none relative block w-full px-4 py-3 placeholder-gray-500 text-gray-900 rounded-lg pr-12 sm:text-sm"
                                   placeholder="Masukkan password Anda">
                            <button type="button"
                                    onclick="togglePassword()"
                                    class="password-toggle absolute inset-y-0 right-0 flex items-center icon-secondary icon-hover">
                                <i id="password-icon" class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="error-message">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center">
                            <input id="remember_me"
                                   type="checkbox"
                                   name="remember"
                                   class="checkbox-primary h-4 w-4 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-sm link-primary font-medium">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                                class="w-full btn-primary text-white font-semibold py-3 px-4 rounded-lg">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            <span id="button-text">Masuk</span>
                            <i id="loading-spinner" class="fas fa-spinner fa-spin ml-2 hidden"></i>
                        </button>
                    </div>

                    @if (Route::has('register'))
                        <div class="text-center pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600">
                                Belum punya akun?
                                <a href="{{ route('register') }}" class="link-primary font-medium">
                                    Daftar sekarang
                                </a>
                            </p>
                        </div>
                    @endif
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
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');

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

        // Form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function() {
            const submitButton = this.querySelector('button[type="submit"]');
            const buttonText = document.getElementById('button-text');
            const loadingSpinner = document.getElementById('loading-spinner');

            // Disable button and show loading
            submitButton.disabled = true;
            buttonText.textContent = 'Memproses...';
            loadingSpinner.classList.remove('hidden');

            // Add loading class to form
            this.classList.add('loading');
        });

        // Auto-focus email field when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            if (emailInput && !emailInput.value) {
                emailInput.focus();
            }
        });

        // Add floating label effect
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });

            // Check on page load
            if (input.value) {
                input.parentElement.classList.add('focused');
            }
        });
    </script>
</body>
</html>
