@extends('layouts.panel')

@section('title', 'Kategori Yönetimi')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📁 Kategori Yönetimi</h2>
        <a href="{{ route('admin.categories.create') }}"
            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            ➕ Yeni Kategori
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-4">✅ {{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4">❌ {{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">Kategori Adı</th>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">Slug</th>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">Blog Sayısı</th>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">Durum</th>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">İşlemler</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($categories as $category)
                    <tr class="hover:bg-gray-50 {{ $category->status === 'passive' ? 'opacity-60' : '' }}">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $category->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500 font-mono">{{ $category->slug }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $category->blogs_count }} yazı</td>
                        <td class="px-4 py-3">
                            @if ($category->status === 'active')
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">✅ Aktif</span>
                            @else
                                <span class="text-xs bg-gray-200 text-gray-600 px-2 py-1 rounded-full font-medium">⏸ Pasif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                {{-- Aktif/Pasif Toggle --}}
                                <form action="{{ route('admin.categories.toggleStatus', $category) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                        class="text-xs {{ $category->status === 'active' ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }} px-3 py-1 rounded transition"
                                        title="{{ $category->status === 'active' ? 'Pasifleştir' : 'Aktifleştir' }}">
                                        {{ $category->status === 'active' ? '⏸ Pasifleştir' : '▶️ Aktifleştir' }}
                                    </button>
                                </form>

                                {{-- Sil --}}
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-xs bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1 rounded transition"
                                        onclick="return confirm('\"{{ $category->name }}\" kategorisini silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.')">
                                        🗑 Sil
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-400">Henüz kategori oluşturulmamış.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $categories->links() }}</div>
@endsection
