@extends('layouts.panel')

@section('title', 'Tüm Yazılar')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📚 Tüm Blog Yazıları</h2>
        <span class="text-sm text-gray-500">Toplam: {{ $blogs->total() }}</span>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-4">✅ {{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">Başlık</th>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">Yazar</th>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">Kategori</th>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">Durum</th>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">Tarih</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($blogs as $blog)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-gray-800">{{ Str::limit($blog->title, 50) }}</span>
                                @if ($blog->has_profanity)
                                    <span class="text-xs bg-red-100 text-red-600 px-1.5 py-0.5 rounded">⚠️ Uyarı</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $blog->user->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $blog->category->name }}</td>
                        <td class="px-4 py-3">
                            @if ($blog->status === 'approved')
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">✅ Onaylı</span>
                            @elseif ($blog->status === 'pending')
                                <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-medium">⏳ Bekliyor</span>
                            @else
                                <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full font-medium">❌ Reddedildi</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $blog->created_at->format('d.m.Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-400">Hiç yazı bulunamadı.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $blogs->links() }}</div>
@endsection
