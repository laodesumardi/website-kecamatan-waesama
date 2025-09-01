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

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }

        .sidebar-collapsed {
            width: 4rem;
        }

        .sidebar-expanded {
            width: 16rem;
        }

        .main-content-collapsed {
            margin-left: 4rem;
        }

        .main-content-expanded {
            margin-left: 16rem;
        }

        /* Mobile responsive styles */
        @media (max-width: 768px) {
            .sidebar-expanded {
                width: 16rem;
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                z-index: 50;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar-expanded.mobile-open {
                transform: translateX(0);
            }

            .sidebar-collapsed {
                width: 16rem;
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                z-index: 50;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

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
                background: rgba(0, 0, 0, 0.5);
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

        .nav-item:hover {
            background: #003f88;
        }

        .nav-item.active {
            background: #003f88;
            box-shadow: 0 4px 15px 0 rgba(102, 126, 234, 0.3);
        }

        .solid-bg {
            background: #003f88;
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
        }

        .nav-item i {
            width: 1.25rem;
            text-align: center;
            font-size: 1rem;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="mobile-overlay"></div>

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar-transition sidebar-expanded bg-white shadow-xl border-r border-gray-200 flex flex-col">
            <!-- Logo -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 solid-bg rounded-lg flex items-center justify-center" style="background: #003f88;">
                        <i class="fas fa-building text-white text-lg"></i>
                    </div>
                    <div id="logo-text" class="sidebar-transition">
                        <h1 class="text-lg font-bold text-gray-800">Kantor Camat</h1>
                        <p class="text-xs text-gray-500">Waesama</p>
                    </div>
                </div>
                <button id="sidebar-toggle" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-bars text-gray-600"></i>
                </button>
            </div>

            <!-- User Info -->
            <div class="p-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-[#003f88] rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                    <div id="user-info" class="sidebar-transition">
                        <p class="font-medium text-gray-800 text-sm">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->role->display_name }}</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                @yield('sidebar-menu')
            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 px-3 py-2 rounded-lg text-red-600 hover:bg-red-50 transition-colors">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span id="logout-text" class="sidebar-transition">Logout</span>
                    </button>
                </form>
            </div>
        </div>

       <!-- Main Content -->
<div id="main-content" class="flex-1 flex flex-col transition-all duration-300">
    <!-- Top Bar -->
    <header class="bg-white shadow-sm border-b border-gray-200 py-4">
        <div class="flex items-center justify-between px-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $title ?? 'Dashboard' }}</h1>
                @isset($subtitle)
                    <p class="text-gray-600 text-sm mt-1">{{ $subtitle }}</p>
                @endisset
            </div>
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <button class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-bell text-gray-600"></i>
                    <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                </button>

                <!-- Profile Dropdown -->
                <div class="relative">
                    <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="w-8 h-8 bg-[#003f88] rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-xs">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <span class="text-gray-700 font-medium">{{ auth()->user()->name }}</span>
                        <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-1 overflow-y-auto p-6">
        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const logoText = document.getElementById('logo-text');
            const userInfo = document.getElementById('user-info');
            const logoutText = document.getElementById('logout-text');
            const mobileOverlay = document.getElementById('mobile-overlay');

            let isCollapsed = false;
            let isMobile = window.innerWidth <= 768;

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

            sidebarToggle.addEventListener('click', function() {
                if (isMobile) {
                    // Mobile behavior - toggle sidebar overlay
                    sidebar.classList.toggle('mobile-open');
                    mobileOverlay.classList.toggle('active');
                } else {
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

                        // Hide nav text
                        document.querySelectorAll('.nav-text').forEach(el => {
                            el.style.display = 'none';
                        });
                    } else {
                        sidebar.classList.remove('sidebar-collapsed');
                        sidebar.classList.add('sidebar-expanded');
                        mainContent.classList.remove('main-content-collapsed');
                        mainContent.classList.add('main-content-expanded');

                        logoText.style.display = 'block';
                        userInfo.style.display = 'block';
                        logoutText.style.display = 'inline';

                        // Show nav text
                        document.querySelectorAll('.nav-text').forEach(el => {
                            el.style.display = 'inline';
                        });
                    }
                }
            });

            // Close mobile sidebar when clicking overlay
            mobileOverlay.addEventListener('click', function() {
                sidebar.classList.remove('mobile-open');
                mobileOverlay.classList.remove('active');
            });
        });
    </script>
</body>
</html>
