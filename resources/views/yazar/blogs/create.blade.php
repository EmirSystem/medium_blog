@extends('layouts.panel')

@section('title', 'Yeni Yazı Yaz')

@section('content')

    <a href="{{ route('yazar.blogs.index') }}" class="back-link">← Yazılarıma Dön</a>

    <div class="page-header">
        <h2 class="page-title">
            <span class="page-title-icon">✍️</span>
            Yeni Yazı Yaz
        </h2>
    </div>

    <div class="alert alert-info">
        ℹ️ Yazdığınız yazı doğrudan yayınlanmaz. Admin onayından sonra web sitesinde görünür hale gelir.
    </div>

    @if (session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="form-card">
        <form action="{{ route('yazar.blogs.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="title" class="form-label">Yazı Başlığı <span>*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') }}"
                    class="form-input @error('title') is-error @enderror"
                    placeholder="Etkileyici bir başlık girin...">
                @error('title')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_id" class="form-label">Kategori <span>*</span></label>
                <select id="category_id" name="category_id"
                    class="form-select @error('category_id') is-error @enderror">
                    <option value="">— Kategori seçin —</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="content" class="form-label">
                    İçerik <span>* (en az 50 karakter)</span>
                </label>
                <textarea id="content" name="content" rows="16"
                    class="form-textarea @error('content') is-error @enderror"
                    placeholder="Yazınızı buraya yazın...">{{ old('content') }}</textarea>
                @error('content')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div style="display:flex; align-items:center; gap:12px; margin-top:4px;">
                <button type="submit" class="btn btn-primary">
                    📤 Onaya Gönder
                </button>
                <a href="{{ route('yazar.blogs.index') }}" class="btn btn-ghost">İptal</a>
            </div>
        </form>
    </div>
@endsection
