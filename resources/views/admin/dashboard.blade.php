@extends('layouts.panel')

@section('title', 'Admin Dashboard')

@section('content')

    <div class="page-header">
        <h2 class="page-title">
            <span class="page-title-icon">📊</span>
            Hoş geldin, {{ Auth::user()->name }}!
        </h2>
        <span class="badge badge-purple">Süper Admin</span>
    </div>

    {{-- Stat Cards --}}
    <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:16px; margin-bottom:28px;">

        <div class="stat-card stat-card-1">
            <div class="stat-icon">⏳</div>
            <div class="stat-label">Onay Bekleyen</div>
            <div class="stat-value">{{ \App\Models\Blog::where('status', 'pending')->count() }}</div>
        </div>

        <div class="stat-card stat-card-2">
            <div class="stat-icon">👥</div>
            <div class="stat-label">Toplam Kullanıcı</div>
            <div class="stat-value">{{ \App\Models\User::count() }}</div>
        </div>

        <div class="stat-card stat-card-3">
            <div class="stat-icon">📁</div>
            <div class="stat-label">Toplam Kategori</div>
            <div class="stat-value">{{ \App\Models\Category::count() }}</div>
        </div>
    </div>

    {{-- Recent pending table --}}
    <div class="page-header" style="margin-bottom:16px;">
        <h3 style="font-size:16px; font-weight:700; color:#f1f5f9; display:flex; align-items:center; gap:8px;">
            <span>📋</span> Son Onay Bekleyen Yazılar
        </h3>
        <a href="{{ route('admin.blogs.pending') }}" class="btn btn-ghost btn-sm">Tümünü Gör →</a>
    </div>

    <div class="panel-table-wrap">
        <table class="panel-table">
            <thead>
                <tr>
                    <th>Başlık</th>
                    <th>Yazar</th>
                    <th>Kategori</th>
                    <th>Tarih</th>
                    <th>Uyarı</th>
                </tr>
            </thead>
            <tbody>
                @forelse(\App\Models\Blog::where('status', 'pending')->latest()->take(5)->get() as $blog)
                    <tr>
                        <td>
                            <span style="font-weight:600; color:#f1f5f9;">{{ Str::limit($blog->title, 45) }}</span>
                        </td>
                        <td>{{ $blog->user->name }}</td>
                        <td>
                            <span class="badge badge-cyan">{{ $blog->category->name }}</span>
                        </td>
                        <td style="color:rgba(255,255,255,0.4); font-size:12.5px;">{{ $blog->created_at->format('d.m.Y') }}</td>
                        <td>
                            @if ($blog->has_profanity)
                                <span class="badge badge-danger">⚠️ Uyarı</span>
                            @else
                                <span style="color:rgba(255,255,255,0.2); font-size:12px;">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-state-icon">🎉</div>
                                <div class="empty-state-text">Onay bekleyen yazı yok.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
