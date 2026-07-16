@extends('layouts.panel')

@section('title', 'Tüm Yazılar')

@section('content')

    <div class="page-header">
        <h2 class="page-title">
            <span class="page-title-icon">📚</span>
            Tüm Blog Yazıları
        </h2>
        <span class="badge badge-gray">Toplam: {{ $blogs->total() }}</span>
    </div>

    @if (session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="panel-table-wrap">
        <table class="panel-table">
            <thead>
                <tr>
                    <th>Başlık</th>
                    <th>Yazar</th>
                    <th>Kategori</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($blogs as $blog)
                    <tr>
                        <td>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span style="font-weight:600; color:#f1f5f9;">{{ Str::limit($blog->title, 50) }}</span>
                                @if ($blog->has_profanity)
                                    <span class="badge badge-danger" style="font-size:10px;">⚠️ Uyarı</span>
                                @endif
                            </div>
                        </td>
                        <td style="color:rgba(255,255,255,0.55);">{{ $blog->user->name }}</td>
                        <td>
                            <span class="badge badge-cyan">{{ $blog->category->name }}</span>
                        </td>
                        <td>
                            @if ($blog->status === 'approved')
                                <span class="badge badge-success">✅ Onaylı</span>
                            @elseif ($blog->status === 'pending')
                                <span class="badge badge-warning">⏳ Bekliyor</span>
                            @else
                                <span class="badge badge-danger">❌ Reddedildi</span>
                            @endif
                        </td>
                        <td style="color:rgba(255,255,255,0.4); font-size:12.5px;">{{ $blog->created_at->format('d.m.Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-state-icon">📭</div>
                                <div class="empty-state-text">Hiç yazı bulunamadı.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">{{ $blogs->links() }}</div>
@endsection
