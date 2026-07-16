@extends('layouts.panel')

@section('title', 'Yeni Yazı Yaz')

@section('content')
    <div class="mb-6">
        <a href="{{ route('yazar.blogs.index') }}" class="text-blue-600 hover:underline text-sm">← Yazılarıma Dön</a>
        <h2 class="text-2xl font-bold text-gray-800 mt-2">✍️ Yeni Yazı Yaz</h2>
    </div>

    {{-- Onay bildirim kutusu --}}
    <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg mb-6 text-sm">
        ℹ️ Yazdığınız yazı doğrudan yayınlanmaz. Admin onayından sonra web sitesinde görünür hale gelir.
    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-4">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('yazar.blogs.store') }}" method="POST">
            @csrf

            {{-- Başlık --}}
            <div class="mb-5">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Yazı Başlığı *</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                    placeholder="Yazınızın başlığını girin">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kategori --}}
            <div class="mb-5">
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori *</label>
                <select id="category_id" name="category_id"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror">
                    <option value="">— Kategori seçin —</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- İçerik --}}
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">
                    İçerik * <span class="text-gray-400 font-normal">(en az 50 karakter)</span>
                </label>
                <textarea id="content" name="content" rows="14"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror"
                    placeholder="Yazınızı buraya yazın...">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg transition">
                    📤 Onaya Gönder
                </button>
                <a href="{{ route('yazar.blogs.index') }}"
                    class="text-gray-500 hover:text-gray-700 text-sm transition">İptal</a>
            </div>
        </form>
    </div>
@endsection
