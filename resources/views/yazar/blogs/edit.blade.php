@extends('layouts.panel')

@section('title', 'Yazıyı Düzenle')

@section('content')
    <div class="mb-6">
        <a href="{{ route('yazar.blogs.index') }}" class="text-blue-600 hover:underline text-sm">← Yazılarıma Dön</a>
        <h2 class="text-2xl font-bold text-gray-800 mt-2">✏️ Yazıyı Düzenle</h2>
    </div>

    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg mb-6 text-sm">
        ℹ️ Yazıyı güncelledikten sonra tekrar admin onayına gönderilecektir.
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('yazar.blogs.update', $blog) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-5">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Yazı Başlığı *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $blog->title) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori *</label>
                <select id="category_id" name="category_id"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror">
                    <option value="">— Kategori seçin —</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">İçerik *</label>
                <textarea id="content" name="content" rows="14"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror">{{ old('content', $blog->content) }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg transition">
                    💾 Güncelle & Onaya Gönder
                </button>
                <a href="{{ route('yazar.blogs.index') }}"
                    class="text-gray-500 hover:text-gray-700 text-sm transition">İptal</a>
            </div>
        </form>
    </div>
@endsection
