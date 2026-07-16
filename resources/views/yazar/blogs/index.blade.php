@extends('layouts.panel')

@section('title', 'Yazılarım')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📝 Yazılarım</h2>
        <a href="{{ route('yazar.blogs.create') }}"
            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            ➕ Yeni Yazı Yaz
        </a>
    </div>

    {{-- Mesajlar --}}
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-4">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4">
            ❌ {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">Başlık</th>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">Kategori</th>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">Durum</th>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">Tarih</th>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">İşlemler</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($blogs as $blog)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ Str::limit($blog->title, 60) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $blog->category->name }}
                        </td>
                        <td class="px-4 py-3">
                            @if ($blog->status === 'approved')
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">✅ Onaylı - Yayında</span>
                            @elseif ($blog->status === 'pending')
                                <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-medium">⏳ Onay Bekliyor</span>
                            @else
                                <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full font-medium">❌ Reddedildi</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">
                            {{ $blog->created_at->format('d.m.Y') }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                @if ($blog->status !== 'approved')
                                    <a href="{{ route('yazar.blogs.edit', $blog) }}"
                                        class="text-xs bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1 rounded transition">
                                        ✏️ Düzenle
                                    </a>
                                @endif
                                <form action="{{ route('yazar.blogs.destroy', $blog) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-xs bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1 rounded transition"
                                        onclick="return confirm('Bu yazıyı silmek istediğinizden emin misiniz?')">
                                        🗑 Sil
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center">
                            <p class="text-gray-400 text-lg mb-3">Henüz yazı paylaşmadınız.</p>
                            <a href="{{ route('yazar.blogs.create') }}"
                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                                ➕ İlk Yazını Yaz
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $blogs->links() }}</div>
@endsection
