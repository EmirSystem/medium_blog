@extends('layouts.panel')

@section('title', 'Yazar Paneli')

@section('content')

    <div class="page-header">
        <h2 class="page-title">
            <span class="page-title-icon">✍️</span>
            Hoş geldin, {{ Auth::user()->name }}!
        </h2>
        <span class="badge badge-cyan">Yazar</span>
    </div>

    {{-- Hızlı istatistikler --}}
    @php
        $myBlogs   = Auth::user()->blogs();
        $totalBlogs    = $myBlogs->count();
        $approvedBlogs = (clone $myBlogs)->where('status','approved')->count();
        $pendingBlogs  = (clone $myBlogs)->where('status','pending')->count();
    @endphp

    <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:16px; margin-bottom:28px;">
        <div class="stat-card stat-card-4">
            <div class="stat-icon">📝</div>
            <div class="stat-label">Toplam Yazım</div>
            <div class="stat-value">{{ $totalBlogs }}</div>
        </div>
        <div class="stat-card stat-card-2">
            <div class="stat-icon">✅</div>
            <div class="stat-label">Yayında</div>
            <div class="stat-value">{{ $approvedBlogs }}</div>
        </div>
        <div class="stat-card stat-card-3">
            <div class="stat-icon">⏳</div>
            <div class="stat-label">Onay Bekliyor</div>
            <div class="stat-value">{{ $pendingBlogs }}</div>
        </div>
    </div>

    {{-- Son Yazılarım --}}
    <div class="page-header" style="margin-bottom:16px;">
        <h3 style="font-size:16px; font-weight:700; color:#f1f5f9; display:flex; align-items:center; gap:8px;">
            <span>📋</span> Son Yazılarım
        </h3>
        <a href="{{ route('yazar.blogs.create') }}" class="btn btn-primary btn-sm">
            ➕ Yeni Yazı
        </a>
    </div>

    <div class="panel-table-wrap">
        <table class="panel-table">
            <thead>
                <tr>
                    <th>Başlık</th>
                    <th>Kategori</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                </tr>
            </thead>
            <tbody>
                @forelse(Auth::user()->blogs()->latest()->take(10)->get() as $blog)
                    <tr>
                        <td>
                            <span style="font-weight:600; color:#f1f5f9;">{{ Str::limit($blog->title, 55) }}</span>
                        </td>
                        <td>
                            <span class="badge badge-cyan">{{ $blog->category->name }}</span>
                        </td>
                        <td>
                            @if ($blog->status === 'approved')
                                <span class="badge badge-success">✅ Onaylı</span>
                            @elseif($blog->status === 'pending')
                                <span class="badge badge-warning">⏳ Bekliyor</span>
                            @else
                                <span class="badge badge-danger">❌ Reddedildi</span>
                            @endif
                        </td>
                        <td style="color:rgba(255,255,255,0.4); font-size:12.5px;">{{ $blog->created_at->format('d.m.Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
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
@endsection
