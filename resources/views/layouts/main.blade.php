<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} - Kantor Camat Waesama</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/mobile-responsive.js') }}"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
    <script src="{{ asset('js/csrf-handler.js') }}"></script>

    <style>
        :root {
            --primary-color: #001d3d;
            --primary-light: #003566;
            --primary-dark: #000814;
            --primary-100: #e6f2ff;
            --primary-200: #b3d9ff;
            --primary-300: #80bfff;
            --primary-600: #002a5c;
            --primary-700: #001a33;
            --primary-800: #00141a;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }

        .sidebar-collapsed {
            width: 4rem;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 40;
        }

        .sidebar-expanded {
            width: 16rem;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 40;
        }

        .main-content-collapsed {
            margin-left: 4rem;
            width: calc(100% - 4rem);
            transition: all 0.3s ease;
        }

        .main-content-expanded {
            margin-left: 16rem;
            width: calc(100% - 16rem);
            transition: all 0.3s ease;
        }

        /* Ensure proper scrolling */
        .main-content-area {
            height: calc(100vh - 80px); /* Subtract header height */
            overflow-y: auto;
        }

        /* Mobile responsive styles */
        @media (max-width: 768px) {
            .sidebar-expanded,
            .sidebar-collapsed {
                width: 16rem;
                z-index: 50;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar-expanded.mobile-open,
            .sidebar-collapsed.mobile-open {
                transform: translateX(0);
            }

            .main-content-expanded,
            .main-content-collapsed {
                margin-left: 0;
                width: 100%;
            }

            .mobile-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 29, 61, 0.5);
                z-index: 40;
                display: none;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .mobile-overlay.active {
                display: block;
                opacity: 1;
            }
        }

        /* Hide desktop toggle on mobile */
        #sidebar-toggle {
            display: block;
        }

        @media (max-width: 1024px) {
            #sidebar-toggle {
                display: none;
            }
        }

        /* Additional mobile responsive styles */
        @media (max-width: 640px) {
            .main-content-area {
                padding: 1rem;
            }

            header .flex {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            h1 {
                font-size: 1.25rem !important;
            }
        }

        .nav-item:hover {
            background: var(--primary-light) !important;
            color: white !important;
        }

        .nav-item.active {
            background: var(--primary-light) !important;
            color: white !important;
            box-shadow: 0 4px 15px 0 rgba(0, 29, 61, 0.3);
        }

        .nav-item:hover .nav-text,
        .nav-item.active .nav-text {
            color: white !important;
        }

        .solid-bg {
            background: var(--primary-color);
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }

        .bg-primary-50 {
            background-color: #f8fafc !important;
        }

        .bg-primary-light {
            background-color: var(--primary-light) !important;
        }

        .bg-primary-600 {
            background-color: var(--primary-600) !important;
        }

        .bg-primary-700 {
            background-color: var(--primary-700) !important;
        }

        .bg-primary-800 {
            background-color: var(--primary-800) !important;
        }

        .border-primary-600 {
            border-color: var(--primary-600) !important;
        }

        .border-primary-700 {
            border-color: var(--primary-700) !important;
        }

        .text-primary-200 {
            color: var(--primary-200) !important;
        }

        .text-primary-300 {
            color: var(--primary-300) !important;
        }

        .hover\:bg-primary-700:hover {
            background-color: var(--primary-700) !important;
        }

        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Standardized Menu Styling */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            margin-bottom: 0.25rem;
            color: #e2e8f0;
        }

        .nav-item i {
            width: 1.25rem;
            text-align: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .nav-text {
            white-space: nowrap;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        /* Sidebar collapsed state */
        .sidebar-collapsed .nav-text {
            opacity: 0;
            width: 0;
        }

        .sidebar-expanded .nav-text {
            opacity: 1;
            width: auto;
        }

        /* Notification and Profile dropdown styling */
        .notification-dropdown,
        .profile-dropdown {
            background-color: var(--primary-800) !important;
            border-color: var(--primary-600) !important;
        }

        /* Success and Error messages with consistent theme */
        .alert-success {
            background-color: #d1fae5;
            border-color: #a7f3d0;
            color: #065f46;
        }

        .alert-error {
            background-color: #fee2e2;
            border-color: #fecaca;
            color: #991b1b;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="mobile-overlay"></div>

    <div class="h-screen overflow-hidden">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar-transition sidebar-expanded bg-primary shadow-xl border-r border-primary-700 flex flex-col">
            <!-- Logo -->
            <div class="flex items-center justify-between p-4 border-b border-primary-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 solid-bg rounded-lg flex items-center justify-center">
                        <i class="fas fa-building text-white text-lg"></i>
                    </div>
                    <div id="logo-text" class="sidebar-transition">
                        <h1 class="text-lg font-bold text-white">Kantor Camat</h1>
                        <p class="text-xs text-primary-200">Waesama</p>
                    </div>
                </div>
                <button id="sidebar-toggle" class="p-2 rounded-lg hover:bg-primary-700 transition-colors">
                    <i class="fas fa-bars text-white"></i>
                </button>
            </div>

            <!-- User Info -->
            <div class="p-4 border-b border-primary-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-primary-light rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                    <div id="user-info" class="sidebar-transition">
                        <p class="font-medium text-white text-sm">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-primary-200">{{ auth()->user()->role->display_name }}</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                @if(auth()->user()->role->name === 'Admin')
                    @include('partials.admin-sidebar')
                @elseif(auth()->user()->role->name === 'Pegawai')
                    @include('partials.pegawai-sidebar')
                @elseif(auth()->user()->role->name === 'Warga')
                    @include('partials.warga-sidebar')
                @endif
            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-primary-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 px-3 py-2 rounded-lg text-red-400 hover:bg-red-900 hover:bg-opacity-30 transition-colors">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span id="logout-text" class="sidebar-transition">Logout</span>
                    </button>
                </form>
            </div>
        </div>

       <!-- Main Content -->
<div id="main-content" class="flex flex-col transition-all duration-300 h-screen">
    <!-- Top Bar -->
    <header class="bg-primary shadow-sm border-b border-primary-700 py-4">
        <div class="flex items-center justify-between px-6">
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-toggle" class="lg:hidden p-2 rounded-lg hover:bg-primary-700 transition-colors">
                <i class="fas fa-bars text-white text-xl"></i>
            </button>

            <div class="flex-1 lg:flex-none">
                <h1 class="text-xl lg:text-2xl font-bold text-white">{{ $title ?? 'Dashboard' }}</h1>
                @isset($subtitle)
                    <p class="text-primary-200 text-sm mt-1">{{ $subtitle }}</p>
                @endisset
            </div>
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <div class="relative">
                    <button id="notification-btn" class="relative p-2 rounded-lg hover:bg-primary-700 transition-colors">
                        <i class="fas fa-bell text-white"></i>
                        <span id="notification-badge" class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full hidden"></span>
                        <span id="notification-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1 min-w-[16px] h-4 flex items-center justify-center hidden"></span>
                    </button>

                    <!-- Notification Dropdown -->
                    <div id="notification-dropdown" class="absolute right-0 mt-2 w-80 bg-primary-800 rounded-lg shadow-lg border border-primary-600 z-50 hidden notification-dropdown">
                        <div class="p-4 border-b border-primary-600">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-white">Notifikasi</h3>
                                <button id="mark-all-read" class="text-sm text-primary-200 hover:text-white">Tandai Semua Dibaca</button>
                            </div>
                        </div>
                        <div id="notification-list" class="max-h-96 overflow-y-auto">
                            <div class="p-4 text-center text-primary-200">
                                <i class="fas fa-bell-slash text-2xl mb-2"></i>
                                <p>Tidak ada notifikasi</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="relative">
                    <button id="profile-btn" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-primary-700 transition-colors">
                        <div class="w-8 h-8 bg-primary-light rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-xs">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <span class="text-white font-medium">{{ auth()->user()->name }}</span>
                        <i class="fas fa-chevron-down text-primary-200 text-xs"></i>
                    </button>

                    <!-- Profile Dropdown Menu -->
                    <div id="profile-dropdown" class="absolute right-0 mt-2 w-48 bg-primary-800 rounded-lg shadow-lg border border-primary-600 z-50 hidden profile-dropdown">
                        <div class="p-2">
                            <div class="px-3 py-2 border-b border-primary-600">
                                <p class="font-medium text-white">{{ auth()->user()->name }}</p>
                                <p class="text-sm text-primary-200">{{ auth()->user()->email }}</p>
                                <p class="text-xs text-primary-300">{{ auth()->user()->role->display_name }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 text-sm text-white hover:bg-primary-700 rounded-md">
                                <i class="fas fa-user mr-2"></i>
                                Profil Saya
                            </a>
                            <a href="#" class="flex items-center px-3 py-2 text-sm text-white hover:bg-primary-700 rounded-md">
                                <i class="fas fa-cog mr-2"></i>
                                Pengaturan
                            </a>
                            <div class="border-t border-primary-600 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-3 py-2 text-sm text-red-400 hover:bg-red-900 hover:bg-opacity-30 rounded-md">
                                        <i class="fas fa-sign-out-alt mr-2"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="main-content-area p-6 bg-primary-50 min-h-screen">
        @if(session('success'))
            <div class="mb-4 alert-success border px-4 py-3 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 alert-error border px-4 py-3 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            </div>
        </div>
        @endif

        @yield('content')
    </main>
</div>

<!-- Mobile Overlay -->
<div id="mobile-overlay" class="mobile-overlay"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const logoText = document.getElementById('logo-text');
            const userInfo = document.getElementById('user-info');
            const logoutText = document.getElementById('logout-text');
            const mobileOverlay = document.getElementById('mobile-overlay');

            let isCollapsed = false;
            let isMobile = window.innerWidth <= 768;

            // Ensure sidebar starts in expanded state
            sidebar.classList.add('sidebar-expanded');
            sidebar.classList.remove('sidebar-collapsed');
            mainContent.classList.add('main-content-expanded');
            mainContent.classList.remove('main-content-collapsed');

            // Check if mobile on resize
            window.addEventListener('resize', function() {
                const wasMobile = isMobile;
                isMobile = window.innerWidth <= 768;

                if (wasMobile !== isMobile) {
                    // Reset sidebar state when switching between mobile/desktop
                    if (isMobile) {
                        sidebar.classList.remove('mobile-open');
                        mobileOverlay.classList.remove('active');
                    } else {
                        sidebar.classList.remove('mobile-open');
                        mobileOverlay.classList.remove('active');
                    }
                }
            });

            // Desktop sidebar toggle
            sidebarToggle.addEventListener('click', function() {
                if (!isMobile) {
                    // Desktop behavior - collapse/expand sidebar
                    isCollapsed = !isCollapsed;

                    if (isCollapsed) {
                        sidebar.classList.remove('sidebar-expanded');
                        sidebar.classList.add('sidebar-collapsed');
                        mainContent.classList.remove('main-content-expanded');
                        mainContent.classList.add('main-content-collapsed');

                        logoText.style.display = 'none';
                        userInfo.style.display = 'none';
                        logoutText.style.display = 'none';
                    } else {
                        sidebar.classList.remove('sidebar-collapsed');
                        sidebar.classList.add('sidebar-expanded');
                        mainContent.classList.remove('main-content-collapsed');
                        mainContent.classList.add('main-content-expanded');

                        logoText.style.display = 'block';
                        userInfo.style.display = 'block';
                        logoutText.style.display = 'inline';
                    }
                }
            });

            // Mobile menu toggle
            mobileMenuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('mobile-open');
                mobileOverlay.classList.toggle('active');
            });

            // Close mobile sidebar when clicking overlay
            mobileOverlay.addEventListener('click', function() {
                sidebar.classList.remove('mobile-open');
                mobileOverlay.classList.remove('active');
            });

            // Notification and Profile Dropdown functionality
            const notificationBtn = document.getElementById('notification-btn');
            const notificationDropdown = document.getElementById('notification-dropdown');
            const profileBtn = document.getElementById('profile-btn');
            const profileDropdown = document.getElementById('profile-dropdown');
            const markAllReadBtn = document.getElementById('mark-all-read');

            // Toggle notification dropdown
            notificationBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                notificationDropdown.classList.toggle('hidden');
                profileDropdown.classList.add('hidden');
                loadNotifications();
            });

            // Toggle profile dropdown
            profileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                profileDropdown.classList.toggle('hidden');
                notificationDropdown.classList.add('hidden');
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                notificationDropdown.classList.add('hidden');
                profileDropdown.classList.add('hidden');
            });

            // Prevent dropdown from closing when clicking inside
            notificationDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            profileDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            // Mark all notifications as read
            markAllReadBtn.addEventListener('click', function() {
                fetch('/notifications/mark-all-read', {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadNotifications();
                        updateNotificationCount();
                    }
                })
                .catch(error => console.error('Error:', error));
            });

            // Load notifications
            function loadNotifications() {
                fetch('/notifications')
                    .then(response => response.json())
                    .then(data => {
                        const notificationList = document.getElementById('notification-list');

                        if (data.notifications.length === 0) {
                            notificationList.innerHTML = `
                                <div class="p-4 text-center text-gray-500">
                                    <i class="fas fa-bell-slash text-2xl mb-2"></i>
                                    <p>Tidak ada notifikasi</p>
                                </div>
                            `;
                        } else {
                            notificationList.innerHTML = data.notifications.map(notification => `
                                <div class="p-4 border-b border-gray-100 hover:bg-gray-50 ${notification.read_at ? 'opacity-60' : ''}">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-800 text-sm">${notification.title}</h4>
                                            <p class="text-gray-600 text-sm mt-1">${notification.message}</p>
                                            <p class="text-gray-400 text-xs mt-2">${formatDate(notification.created_at)}</p>
                                        </div>
                                        <div class="flex items-center space-x-2 ml-2">
                                            ${!notification.read_at ? `
                                                <button onclick="markAsRead(${notification.id})" class="text-blue-600 hover:text-blue-800 text-xs">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            ` : ''}
                                            <button onclick="deleteNotification(${notification.id})" class="text-red-600 hover:text-red-800 text-xs">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `).join('');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Update notification count
            function updateNotificationCount() {
                fetch('/notifications/unread-count')
                    .then(response => response.json())
                    .then(data => {
                        const badge = document.getElementById('notification-badge');
                        const count = document.getElementById('notification-count');

                        if (data.unread_count > 0) {
                            if (data.unread_count > 9) {
                                count.textContent = '9+';
                                count.classList.remove('hidden');
                                badge.classList.add('hidden');
                            } else {
                                count.textContent = data.unread_count;
                                count.classList.remove('hidden');
                                badge.classList.add('hidden');
                            }
                        } else {
                            count.classList.add('hidden');
                            badge.classList.add('hidden');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Mark single notification as read
            window.markAsRead = function(notificationId) {
                fetch(`/notifications/${notificationId}/read`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadNotifications();
                        updateNotificationCount();
                    }
                })
                .catch(error => console.error('Error:', error));
            };

            // Delete notification
            window.deleteNotification = function(notificationId) {
                if (confirm('Hapus notifikasi ini?')) {
                    fetch(`/notifications/${notificationId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            loadNotifications();
                            updateNotificationCount();
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            };

            // Format date
            function formatDate(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const diff = now - date;
                const minutes = Math.floor(diff / 60000);
                const hours = Math.floor(diff / 3600000);
                const days = Math.floor(diff / 86400000);

                if (minutes < 1) return 'Baru saja';
                if (minutes < 60) return `${minutes} menit yang lalu`;
                if (hours < 24) return `${hours} jam yang lalu`;
                if (days < 7) return `${days} hari yang lalu`;

                return date.toLocaleDateString('id-ID', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
            }

            // Load notification count on page load
            updateNotificationCount();

            // Auto-refresh notification count every 30 seconds
            setInterval(updateNotificationCount, 30000);
        });
    </script>
</body>
</html>
