@extends('layouts.panel')

@section('title', 'Onay Bekleyen Yazılar')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📋 Onay Bekleyen Yazılar</h2>
        <span class="bg-yellow-100 text-yellow-800 text-sm font-medium px-3 py-1 rounded-full">
            {{ $blogs->total() }} yazı bekliyor
        </span>
    </div>

    {{-- Başarı/Hata mesajları --}}
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

    @forelse ($blogs as $blog)
        <div class="bg-white rounded-lg shadow mb-4 overflow-hidden">
            <div class="p-5">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-lg font-bold text-gray-900">{{ $blog->title }}</h3>
                            {{-- Küfür Uyarısı --}}
                            @if ($blog->has_profanity)
                                <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded-full">
                                    ⚠️ Sakıncalı İçerik Uyarısı
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-3">
                            <span>👤 {{ $blog->user->name }}</span>
                            <span>📁 {{ $blog->category->name }}</span>
                            <span>📅 {{ $blog->created_at->format('d.m.Y H:i') }}</span>
                            <span>📝 {{ mb_strlen(strip_tags($blog->content)) }} karakter</span>
                        </div>

                        {{-- Küfür varsa detay uyarısı --}}
                        @if ($blog->has_profanity)
                            <div class="bg-red-50 border border-red-200 rounded p-3 mb-3">
                                <p class="text-red-700 text-sm font-medium">
                                    ⚠️ Bu yazıda yasaklı kelime/ifade tespit edildi. Lütfen içeriği dikkatlice inceleyin.
                                </p>
                            </div>
                        @endif

                        {{-- İçerik önizleme --}}
                        <p class="text-gray-600 text-sm bg-gray-50 p-3 rounded">
                            {{ Str::limit(strip_tags($blog->content), 250) }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Aksiyon Butonları --}}
            <div class="px-5 py-3 bg-gray-50 border-t flex items-center gap-3">
                {{-- Onayla --}}
                <form action="{{ route('admin.blogs.approve', $blog) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition"
                        onclick="return confirm('Bu yazıyı onaylayıp yayınlamak istediğinizden emin misiniz?')">
                        ✅ Onayla & Yayınla
                    </button>
                </form>

                {{-- Reddet --}}
                <form action="{{ route('admin.blogs.reject', $blog) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition"
                        onclick="return confirm('Bu yazıyı reddetmek istediğinizden emin misiniz?')">
                        ❌ Reddet
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <p class="text-5xl mb-4">🎉</p>
            <p class="text-gray-500 text-lg">Onay bekleyen yazı bulunmuyor.</p>
        </div>
    @endforelse

    {{-- Sayfalama --}}
    <div class="mt-4">
        {{ $blogs->links() }}
    </div>
@endsection
