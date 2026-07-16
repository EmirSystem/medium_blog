@extends('layouts.panel')

@section('title', 'Yeni Kategori Oluştur')

@section('content')

    <a href="{{ route('admin.categories.index') }}" class="back-link">← Kategorilere Dön</a>

    <div class="page-header">
        <h2 class="page-title">
            <span class="page-title-icon">➕</span>
            Yeni Kategori Oluştur
        </h2>
    </div>

    <div class="form-card" style="max-width:520px;">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Kategori Adı <span>*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="form-input @error('name') is-error @enderror"
                    placeholder="ör. Bilim, Teknoloji, Matematik">
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Açıklama <span>(isteğe bağlı)</span></label>
                <textarea id="description" name="description" rows="3"
                    class="form-textarea"
                    placeholder="Kategori hakkında kısa açıklama">{{ old('description') }}</textarea>
            </div>

            <div style="display:flex; align-items:center; gap:12px; margin-top:8px;">
                <button type="submit" class="btn btn-primary">
                    ✅ Kategori Oluştur
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost">İptal</a>
            </div>
        </form>
    </div>
@endsection
