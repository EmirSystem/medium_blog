<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel') - Medium Blog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white flex flex-col">
            <div class="p-4 border-b border-gray-700">
                <h1 class="text-xl font-bold">Medium Blog</h1>
                <p class="text-sm text-gray-400">{{ Auth::user()->role?->name ?? 'Kullanıcı' }}</p>
            </div>

            <nav class="flex-1 p-4 overflow-y-auto">
                <ul class="space-y-1">
                    {{-- Dashboard (her rolde ortak) --}}
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
                            📊 Dashboard
                        </a>
                    </li>

                    {{-- Admin Menüsü --}}
                    @if (Auth::user()->isSuperAdmin())
                        <li class="pt-3">
                            <p class="text-xs text-gray-500 uppercase tracking-wider px-4 mb-1">Blog Yönetimi</p>
                        </li>
                        <li>
                            <a href="{{ route('admin.blogs.pending') }}"
                                class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.blogs.pending') ? 'bg-gray-700' : '' }}">
                                📋 Onay Bekleyenler
                                @php $pendingCount = \App\Models\Blog::where('status','pending')->count(); @endphp
                                @if ($pendingCount > 0)
                                    <span class="float-right bg-yellow-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                                        {{ $pendingCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.blogs.index') }}"
                                class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.blogs.index') ? 'bg-gray-700' : '' }}">
                                📚 Tüm Yazılar
                            </a>
                        </li>

                        <li class="pt-3">
                            <p class="text-xs text-gray-500 uppercase tracking-wider px-4 mb-1">Yönetim</p>
                        </li>
                        <li>
                            <a href="{{ route('admin.categories.index') }}"
                                class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-700' : '' }}">
                                📁 Kategoriler
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.index') }}"
                                class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">
                                👥 Kullanıcılar
                            </a>
                        </li>

                    {{-- Yazar Menüsü --}}
                    @else
                        <li class="pt-3">
                            <p class="text-xs text-gray-500 uppercase tracking-wider px-4 mb-1">Yazılarım</p>
                        </li>
                        <li>
                            <a href="{{ route('yazar.blogs.index') }}"
                                class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('yazar.blogs.index') ? 'bg-gray-700' : '' }}">
                                📝 Yazılarım
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('yazar.blogs.create') }}"
                                class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('yazar.blogs.create') ? 'bg-gray-700' : '' }}">
                                ➕ Yeni Yazı Yaz
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>

            <div class="p-4 border-t border-gray-700 space-y-1">
                <a href="{{ route('profile.edit') }}"
                    class="block px-4 py-2 rounded hover:bg-gray-700 text-gray-300 text-sm">
                    👤 Profilim
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 rounded hover:bg-gray-700 text-red-400 text-sm">
                        🚪 Çıkış Yap
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-y-auto">
            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4">
                    ❌ {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>

</html>

