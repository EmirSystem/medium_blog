@extends('layouts.panel')

@section('title', 'Yazar Paneli')

@section('content')
    <h2 class="text-2xl font-bold mb-6">Hoş geldin, {{ Auth::user()->name }}!</h2>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Son Yazılarım</h3>
            <a href="{{ route('yazar.blogs.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Yeni Yazı
            </a>
        </div>

        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Başlık</th>
                    <th class="text-left py-2">Kategori</th>
                    <th class="text-left py-2">Durum</th>
                    <th class="text-left py-2">Tarih</th>
                </tr>
            </thead>
            <tbody>
                @forelse(Auth::user()->blogs()->latest()->take(10)->get() as $blog)
                    <tr class="border-b">
                        <td class="py-2">{{ $blog->title }}</td>
                        <td class="py-2">{{ $blog->category->name }}</td>
                        <td class="py-2">
                            @if ($blog->status === 'approved')
                                <span class="text-green-600">✅ Onaylı</span>
                            @elseif($blog->status === 'pending')
                                <span class="text-yellow-600">⏳ Onay Bekliyor</span>
                            @else
                                <span class="text-red-600">❌ Reddedildi</span>
                            @endif
                        </td>
                        <td class="py-2">{{ $blog->created_at->format('d.m.Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-4 text-gray-500 text-center">Henüz yazı paylaşmadınız.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
