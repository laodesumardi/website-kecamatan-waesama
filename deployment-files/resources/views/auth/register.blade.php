<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - {{ config('app.name', 'Kantor Camat Waesama') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/auth-colors.css') }}">
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen gradient-bg flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto h-20 w-20 bg-white rounded-full flex items-center justify-center shadow-lg mb-6 fade-in">
                    <i class="fas fa-user-plus text-3xl icon-primary"></i>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2 slide-up">Daftar Akun Baru</h2>
                <p class="text-blue-light slide-up">Silakan lengkapi data diri Anda untuk mendaftar</p>
            </div>

            <!-- Register Form -->
            <div class="glass-effect rounded-2xl shadow-2xl p-8 slide-up">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Personal Information Section -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-user mr-2 text-blue-600"></i>Informasi Pribadi
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-primary mb-2">
                                    <i class="fas fa-id-card mr-2 icon-primary"></i>Nama Lengkap
                                </label>
                                <input id="name" 
                                       type="text" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required 
                                       autofocus 
                                       autocomplete="name"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition-all duration-300"
                                       placeholder="Masukkan nama lengkap">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- NIK -->
                            <div>
                                <label for="nik" class="block text-sm font-medium text-primary mb-2">
                                    <i class="fas fa-id-badge mr-2 icon-primary"></i>NIK
                                </label>
                                <input id="nik" 
                                       type="text" 
                                       name="nik" 
                                       value="{{ old('nik') }}" 
                                       required
                                       maxlength="16"
                                       pattern="[0-9]{16}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition-all duration-300"
                                       placeholder="16 digit NIK">
                                <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-primary mb-2">
                                    <i class="fas fa-phone mr-2 icon-primary"></i>Nomor Telepon
                                </label>
                                <input id="phone" 
                                       type="tel" 
                                       name="phone" 
                                       value="{{ old('phone') }}" 
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition-all duration-300"
                                       placeholder="08xxxxxxxxxx">
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <!-- Birth Date -->
                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-primary mb-2">
                                    <i class="fas fa-calendar mr-2 icon-primary"></i>Tanggal Lahir
                                </label>
                                <input id="birth_date" 
                                       type="date" 
                                       name="birth_date" 
                                       value="{{ old('birth_date') }}" 
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition-all duration-300">
                                <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                            </div>

                            <!-- Gender -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-primary mb-2">
                                    <i class="fas fa-venus-mars mr-2 icon-primary"></i>Jenis Kelamin
                                </label>
                                <div class="flex space-x-6">
                                    <label class="flex items-center">
                                        <input type="radio" name="gender" value="L" {{ old('gender') == 'L' ? 'checked' : '' }} required
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-2 text-sm text-gray-700">Laki-laki</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="gender" value="P" {{ old('gender') == 'P' ? 'checked' : '' }} required
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-2 text-sm text-gray-700">Perempuan</span>
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-primary mb-2">
                                    <i class="fas fa-map-marker-alt mr-2 icon-primary"></i>Alamat Lengkap
                                </label>
                                <textarea id="address" 
                                          name="address" 
                                          rows="3" 
                                          required
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition-all duration-300"
                                          placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Account Information Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-key mr-2 text-blue-600"></i>Informasi Akun
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Email -->
                            <div class="md:col-span-2">
                                <label for="email" class="block text-sm font-medium text-primary mb-2">
                                    <i class="fas fa-envelope mr-2 icon-primary"></i>Email
                                </label>
                                <input id="email" 
                                       type="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autocomplete="username"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition-all duration-300"
                                       placeholder="Masukkan email Anda">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-primary mb-2">
                                    <i class="fas fa-lock mr-2 icon-primary"></i>Password
                                </label>
                                <div class="relative">
                                    <input id="password" 
                                           type="password" 
                                           name="password" 
                                           required 
                                           autocomplete="new-password"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition-all duration-300 pr-12"
                                           placeholder="Minimal 8 karakter">
                                    <button type="button" 
                                            onclick="togglePassword('password', 'password-icon')" 
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 icon-secondary icon-hover">
                                        <i id="password-icon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-primary mb-2">
                                    <i class="fas fa-lock mr-2 icon-primary"></i>Konfirmasi Password
                                </label>
                                <div class="relative">
                                    <input id="password_confirmation" 
                                           type="password" 
                                           name="password_confirmation" 
                                           required 
                                           autocomplete="new-password"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition-all duration-300 pr-12"
                                           placeholder="Ulangi password">
                                    <button type="button" 
                                            onclick="togglePassword('password_confirmation', 'password-confirmation-icon')" 
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 icon-secondary icon-hover">
                                        <i id="password-confirmation-icon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button type="submit" 
                                class="w-full btn-primary text-white font-semibold py-3 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                        </button>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                Masuk di sini
                            </a>
                        </p>
                    </div>
                </form>
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

        // NIK validation
        document.getElementById('nik').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '').slice(0, 16);
        });

        // Phone validation
        document.getElementById('phone').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>
