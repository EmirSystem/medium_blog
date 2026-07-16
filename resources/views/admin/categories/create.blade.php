@extends('layouts.panel')

@section('title', 'Yeni Kategori Oluştur')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:underline text-sm">← Kategorilere Dön</a>
        <h2 class="text-2xl font-bold text-gray-800 mt-2">➕ Yeni Kategori Oluştur</h2>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-lg">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Kategori Adı *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                    placeholder="ör. Bilim, Teknoloji, Matematik">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Açıklama</label>
                <textarea id="description" name="description" rows="3"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Kategori hakkında kısa açıklama (isteğe bağlı)">{{ old('description') }}</textarea>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg transition">
                ✅ Kategori Oluştur
            </button>
        </form>
    </div>
@endsection
