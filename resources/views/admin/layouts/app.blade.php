<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    @stack('styles')
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <!-- Navbar -->
    <nav class="bg-blue-800 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('admin.articles.index') }}" class="font-bold text-xl">KeoHub Admin</a>
                    <div class="hidden md:block ml-10">
                        <div class="flex items-baseline space-x-4">
                            <a href="{{ route('admin.articles.index') }}" class="{{ request()->routeIs('admin.articles.*') ? 'bg-blue-900' : 'hover:bg-blue-700' }} px-3 py-2 rounded-md text-sm font-medium">Quản lý bài viết</a>
                            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'bg-blue-900' : 'hover:bg-blue-700' }} px-3 py-2 rounded-md text-sm font-medium">Quản lý danh mục</a>
                            <a href="/" target="_blank" class="hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">Xem Website</a>
                        </div>
                    </div>
                </div>
                <div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">Đăng xuất</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex-1 max-w-7xl w-full mx-auto py-6 sm:px-6 lg:px-8">
        @if (session('success'))
            <div id="admin-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 transition-opacity duration-500" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </div>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('admin-alert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.add('opacity-0');
                    setTimeout(() => alert.remove(), 500);
                }, 4000);
            }
        });
    </script>
</body>
</html>
