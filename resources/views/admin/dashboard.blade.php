@extends('layouts.panel')

@section('title', 'Admin Dashboard')

@section('content')

    <h2 class="text-2xl font-bold mb-6">Hoş geldin, {{ Auth::user()->name }}!</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm">Onay Bekleyen Yazılar</h3>
            <p class="text-3xl font-bold text-blue-600">{{ \App\Models\Blog::where('status', 'pending')->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm">Toplam Kullanıcı</h3>
            <p class="text-3xl font-bold text-green-600">{{ \App\Models\User::count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm">Toplam Kategori</h3>
            <p class="text-3xl font-bold text-yellow-600">{{ \App\Models\Category::count() }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold mb-4">Son Onay Bekleyen Yazılar</h3>
        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Başlık</th>
                    <th class="text-left py-2">Yazar</th>
                    <th class="text-left py-2">Kategori</th>
                    <th class="text-left py-2">Tarih</th>
                    <th class="text-left py-2">İşlem</th>
                </tr>
            </thead>
            <tbody>
                @forelse(\App\Models\Blog::where('status', 'pending')->latest()->take(5)->get() as $blog)
                    <tr class="border-b">
                        <td class="py-2">{{ $blog->title }}</td>
                        <td class="py-2">{{ $blog->user->name }}</td>
                        <td class="py-2">{{ $blog->category->name }}</td>
                        <td class="py-2">{{ $blog->created_at->format('d.m.Y') }}</td>
                        <td class="py-2">
                            @if ($blog->has_profanity)
                                <span class="text-red-600 text-sm">⚠️ Küfür uyarısı!</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-gray-500 text-center">Onay bekleyen yazı yok.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
