<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-building text-2xl text-blue-600"></i>
                    </div>
                    <div class="ml-3">
                        <h1 class="text-lg font-semibold text-gray-900">Admin Panel</h1>
                        <p class="text-sm text-gray-500">Kantor Camat</p>
                    </div>
                </div>
            </div>
            
            <nav class="mt-6">
                <div class="px-3">
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="fas fa-tachometer-alt mr-3"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.penduduk.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.penduduk.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="fas fa-users mr-3"></i>
                                Data Penduduk
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.surat.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.surat.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="fas fa-envelope mr-3"></i>
                                Layanan Surat
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.antrian.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.antrian.index') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="fas fa-clock mr-3"></i>
                                Antrian
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.antrian.dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.antrian.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="fas fa-chart-line mr-3"></i>
                                Dashboard Antrian
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pengaduan.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.pengaduan.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="fas fa-comments mr-3"></i>
                                Pengaduan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.user.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.user.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="fas fa-user-cog mr-3"></i>
                                Manajemen User
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.laporan*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="fas fa-chart-bar mr-3"></i>
                                Laporan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('notifications.page') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('notifications.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                <i class="fas fa-bell mr-3"></i>
                                Notifikasi
                                <span id="sidebarNotificationBadge" class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1 {{ ($unreadNotificationCount ?? 0) > 0 ? '' : 'hidden' }}">{{ $unreadNotificationCount ?? 0 }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        @yield('header')
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Notifications Dropdown -->
                        <div class="relative" id="notificationDropdown">
                            <button id="notificationButton" class="relative p-2 text-gray-600 hover:text-gray-900 focus:outline-none focus:text-gray-900">
                                <i class="fas fa-bell text-lg"></i>
                                <span id="notificationBadge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center {{ ($unreadNotificationCount ?? 0) > 0 ? '' : 'hidden' }}">{{ $unreadNotificationCount ?? 0 }}</span>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="notificationMenu" class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 z-50 hidden">
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-medium text-gray-900">Notifikasi</h3>
                                        <button id="markAllRead" class="text-xs text-blue-600 hover:text-blue-800">Tandai Semua Dibaca</button>
                                    </div>
                                </div>
                                <div id="notificationList" class="max-h-96 overflow-y-auto">
                                    @if(isset($recentNotifications) && $recentNotifications->count() > 0)
                                        @foreach($recentNotifications as $notification)
                                            <div class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer {{ $notification->read_at ? 'opacity-75' : 'bg-blue-50' }}" onclick="markNotificationAsRead({{ $notification->id }})">
                                                <div class="flex items-start space-x-3">
                                                    <div class="flex-shrink-0">
                                                        <i class="{{ $notification->priority === 'urgent' ? 'fas fa-exclamation-triangle text-red-500' : ($notification->priority === 'high' ? 'fas fa-exclamation-circle text-orange-500' : 'fas fa-info-circle text-blue-500') }} text-sm"></i>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $notification->title }}</p>
                                                        <p class="text-xs text-gray-500 truncate">{{ Str::limit($notification->message, 60) }}</p>
                                                        <div class="flex items-center justify-between mt-1">
                                                            <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                                            @if($notification->sender)
                                                                <span class="text-xs text-gray-400">dari {{ $notification->sender->name }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if(!$notification->read_at)
                                                        <div class="flex-shrink-0"><div class="w-2 h-2 bg-blue-500 rounded-full"></div></div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="px-4 py-3 text-sm text-gray-500 text-center">
                                            <i class="fas fa-bell-slash text-2xl mb-2"></i>
                                            <p>Tidak ada notifikasi</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="px-4 py-2 border-t border-gray-200">
                                     <a href="{{ route('notifications.page') }}" class="text-xs text-blue-600 hover:text-blue-800">Lihat Semua Notifikasi</a>
                                 </div>
                            </div>
                        </div>
                        
                        <!-- User Dropdown -->
                        <div class="relative">
                            <button class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none focus:text-gray-900">
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down ml-2"></i>
                            </button>
                        </div>
                        
                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Real-time Notifications Script -->
    <script>
    $(document).ready(function() {
        let notificationPolling;
        
        // Initialize notifications
        loadNotifications();
        updateUnreadCount();
        
        // Start polling for new notifications every 30 seconds
        startNotificationPolling();
        
        // Toggle notification dropdown
        $('#notificationButton').click(function(e) {
            e.stopPropagation();
            $('#notificationMenu').toggleClass('hidden');
            if (!$('#notificationMenu').hasClass('hidden')) {
                loadNotifications();
            }
        });
        
        // Close dropdown when clicking outside
        $(document).click(function(e) {
            if (!$(e.target).closest('#notificationDropdown').length) {
                $('#notificationMenu').addClass('hidden');
            }
        });
        
        // Mark all as read
        $('#markAllRead').click(function() {
            markAllNotificationsAsRead();
        });
        
        function startNotificationPolling() {
            notificationPolling = setInterval(function() {
                updateUnreadCount();
            }, 30000); // Poll every 30 seconds
        }
        
        function stopNotificationPolling() {
            if (notificationPolling) {
                clearInterval(notificationPolling);
            }
        }
        
        function loadNotifications() {
            $.ajax({
                url: '{{ route("notifications.index") }}',
                method: 'GET',
                success: function(response) {
                    displayNotifications(response.notifications);
                    updateNotificationBadge(response.unread_count);
                },
                error: function() {
                    $('#notificationList').html('<div class="px-4 py-3 text-sm text-red-500 text-center">Gagal memuat notifikasi</div>');
                }
            });
        }
        
        function updateUnreadCount() {
            $.ajax({
                url: '{{ route("notifications.unread-count") }}',
                method: 'GET',
                success: function(response) {
                    updateNotificationBadge(response.unread_count);
                }
            });
        }
        
        function updateNotificationBadge(count) {
            const badge = $('#notificationBadge');
            const sidebarBadge = $('#sidebarNotificationBadge');
            
            if (count > 0) {
                badge.text(count).removeClass('hidden');
                sidebarBadge.text(count).removeClass('hidden');
            } else {
                badge.addClass('hidden');
                sidebarBadge.addClass('hidden');
            }
        }
        
        function displayNotifications(notifications) {
            if (notifications.length === 0) {
                $('#notificationList').html('<div class="px-4 py-3 text-sm text-gray-500 text-center">Tidak ada notifikasi</div>');
                return;
            }
            
            let html = '';
            notifications.slice(0, 5).forEach(function(notification) { // Show only first 5
                const isRead = notification.read_at !== null;
                const priorityClass = getPriorityClass(notification.priority);
                const priorityIcon = getPriorityIcon(notification.priority);
                
                html += `
                    <div class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer ${!isRead ? 'bg-blue-50' : ''}" onclick="markNotificationAsRead(${notification.id})">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <i class="${priorityIcon} text-sm ${getPriorityColor(notification.priority)}"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">${notification.title}</p>
                                <p class="text-xs text-gray-500 truncate">${notification.message}</p>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-xs text-gray-400">${formatTimeAgo(notification.created_at)}</span>
                                    ${notification.sender ? `<span class="text-xs text-gray-400">dari ${notification.sender.name}</span>` : ''}
                                </div>
                            </div>
                            ${!isRead ? '<div class="flex-shrink-0"><div class="w-2 h-2 bg-blue-500 rounded-full"></div></div>' : ''}
                        </div>
                    </div>
                `;
            });
            
            $('#notificationList').html(html);
        }
        
        function getPriorityClass(priority) {
            const classes = {
                'urgent': 'bg-red-100 text-red-800',
                'high': 'bg-orange-100 text-orange-800',
                'medium': 'bg-blue-100 text-blue-800',
                'low': 'bg-gray-100 text-gray-800'
            };
            return classes[priority] || classes['medium'];
        }
        
        function getPriorityIcon(priority) {
            const icons = {
                'urgent': 'fas fa-exclamation-triangle',
                'high': 'fas fa-exclamation-circle',
                'medium': 'fas fa-info-circle',
                'low': 'fas fa-minus-circle'
            };
            return icons[priority] || icons['medium'];
        }
        
        function getPriorityColor(priority) {
            const colors = {
                'urgent': 'text-red-500',
                'high': 'text-orange-500',
                'medium': 'text-blue-500',
                'low': 'text-gray-500'
            };
            return colors[priority] || colors['medium'];
        }
        
        function formatTimeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffInSeconds = Math.floor((now - date) / 1000);
            
            if (diffInSeconds < 60) {
                return 'Baru saja';
            } else if (diffInSeconds < 3600) {
                const minutes = Math.floor(diffInSeconds / 60);
                return `${minutes} menit lalu`;
            } else if (diffInSeconds < 86400) {
                const hours = Math.floor(diffInSeconds / 3600);
                return `${hours} jam lalu`;
            } else {
                const days = Math.floor(diffInSeconds / 86400);
                return `${days} hari lalu`;
            }
        }
        
        function markNotificationAsRead(id) {
            $.ajax({
                url: `/notifications/${id}/read`,
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    loadNotifications();
                    updateUnreadCount();
                }
            });
        }
        
        // Alternative function for marking as read with different endpoint
        function markAsRead(notificationId) {
            $.post(`/notifications/${notificationId}/mark-as-read`)
                .done(function() {
                    loadNotifications();
                    updateUnreadCount();
                })
                .fail(function() {
                    console.error('Failed to mark notification as read');
                });
        }
        
        function markAllNotificationsAsRead() {
            $.ajax({
                url: '{{ route("notifications.mark-all-read") }}',
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    loadNotifications();
                    updateUnreadCount();
                    showToast('Semua notifikasi ditandai sebagai dibaca', 'success');
                }
            });
        }
        
        function showToast(message, type) {
            const toast = $(`<div class="fixed top-4 right-4 z-50 px-4 py-2 rounded-md text-white ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}">${message}</div>`);
            $('body').append(toast);
            setTimeout(() => toast.fadeOut(() => toast.remove()), 3000);
        }
        
        // Global function for notification click
        window.markNotificationAsRead = markNotificationAsRead;
        
        // Stop polling when page is hidden/unloaded
        $(window).on('beforeunload', function() {
            stopNotificationPolling();
        });
        
        // Resume polling when page becomes visible
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                stopNotificationPolling();
            } else {
                startNotificationPolling();
                updateUnreadCount();
            }
        });
    });
    </script>
    
    <!-- Custom Scripts -->
    @stack('scripts')
</body>
</html>