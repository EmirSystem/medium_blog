@extends('layouts.panel')

@section('title', 'Yazılarım')

@section('content')

    <div class="page-header">
        <h2 class="page-title">
            <span class="page-title-icon">📝</span>
            Yazılarım
        </h2>
        <a href="{{ route('yazar.blogs.create') }}" class="btn btn-primary btn-sm">
            ➕ Yeni Yazı Yaz
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
                    <th>Başlık</th>
                    <th>Kategori</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($blogs as $blog)
                    <tr>
                        <td>
                            <span style="font-weight:600; color:#f1f5f9;">{{ Str::limit($blog->title, 60) }}</span>
                        </td>
                        <td>
                            <span class="badge badge-cyan">{{ $blog->category->name }}</span>
                        </td>
                        <td>
                            @if ($blog->status === 'approved')
                                <span class="badge badge-success">✅ Onaylı — Yayında</span>
                            @elseif ($blog->status === 'pending')
                                <span class="badge badge-warning">⏳ Onay Bekliyor</span>
                            @else
                                <span class="badge badge-danger">❌ Reddedildi</span>
                            @endif
                        </td>
                        <td style="color:rgba(255,255,255,0.4); font-size:12.5px;">{{ $blog->created_at->format('d.m.Y') }}</td>
                        <td>
                            <div style="display:flex; align-items:center; gap:6px;">
                                @if ($blog->status !== 'approved')
                                    <a href="{{ route('yazar.blogs.edit', $blog) }}" class="btn btn-ghost btn-sm">
                                        ✏️ Düzenle
                                    </a>
                                @endif
                                <form action="{{ route('yazar.blogs.destroy', $blog) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Bu yazıyı silmek istediğinizden emin misiniz?')">
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
                                <div class="empty-state-icon">✍️</div>
                                <div class="empty-state-text">Henüz yazı paylaşmadınız.</div>
                                <a href="{{ route('yazar.blogs.create') }}" class="btn btn-primary">➕ İlk Yazını Yaz</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">{{ $blogs->links() }}</div>
@endsection
