@extends('layouts.panel')

@section('title', 'Kategori Yönetimi')

@section('content')

    <div class="page-header">
        <h2 class="page-title">
            <span class="page-title-icon">📁</span>
            Kategori Yönetimi
        </h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
            ➕ Yeni Kategori
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-error">❌ {{ session('error') }}</div>
    @endif

    <div class="panel-table-wrap">
        <table class="panel-table">
            <thead>
                <tr>
                    <th>Kategori Adı</th>
                    <th>Slug</th>
                    <th>Blog Sayısı</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr style="{{ $category->status === 'passive' ? 'opacity:0.55;' : '' }}">
                        <td>
                            <span style="font-weight:600; color:#f1f5f9;">{{ $category->name }}</span>
                        </td>
                        <td>
                            <code style="font-size:12px; color:rgba(255,255,255,0.4); background:rgba(255,255,255,0.05); padding:2px 8px; border-radius:5px; font-family:monospace;">{{ $category->slug }}</code>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $category->blogs_count }} yazı</span>
                        </td>
                        <td>
                            @if ($category->status === 'active')
                                <span class="badge badge-success">✅ Aktif</span>
                            @else
                                <span class="badge badge-gray">⏸ Pasif</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; align-items:center; gap:6px;">
                                <form action="{{ route('admin.categories.toggleStatus', $category) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                        class="btn btn-sm {{ $category->status === 'active' ? 'btn-warning' : 'btn-success' }}">
                                        {{ $category->status === 'active' ? '⏸ Pasifleştir' : '▶️ Aktifleştir' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('\"{{ $category->name }}\" kategorisini silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.')">
                                        🗑 Sil
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-state-icon">📁</div>
                                <div class="empty-state-text">Henüz kategori oluşturulmamış.</div>
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">➕ İlk Kategoriyi Oluştur</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">{{ $categories->links() }}</div>
@endsection
