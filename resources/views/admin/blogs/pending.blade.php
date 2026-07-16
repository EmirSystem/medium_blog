@extends('layouts.panel')

@section('title', 'Onay Bekleyen Yazılar')

@section('content')

    <div class="page-header">
        <h2 class="page-title">
            <span class="page-title-icon">📋</span>
            Onay Bekleyen Yazılar
        </h2>
        <span class="badge badge-warning">{{ $blogs->total() }} yazı bekliyor</span>
    </div>

    @if (session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-error">❌ {{ session('error') }}</div>
    @endif

    @forelse ($blogs as $blog)
        <div class="blog-review-card">
            <div class="blog-review-body">
                <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:10px;">
                    <div style="flex:1;">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                            <h3 style="font-size:16px; font-weight:700; color:#f1f5f9; margin:0;">{{ $blog->title }}</h3>
                            @if ($blog->has_profanity)
                                <span class="badge badge-danger">⚠️ Sakıncalı İçerik</span>
                            @endif
                        </div>

                        <div style="display:flex; align-items:center; gap:16px; margin-bottom:12px;">
                            <span style="font-size:12.5px; color:rgba(255,255,255,0.45); display:flex; align-items:center; gap:5px;">
                                👤 {{ $blog->user->name }}
                            </span>
                            <span class="badge badge-cyan" style="font-size:11px;">{{ $blog->category->name }}</span>
                            <span style="font-size:12.5px; color:rgba(255,255,255,0.35);">
                                📅 {{ $blog->created_at->format('d.m.Y H:i') }}
                            </span>
                            <span style="font-size:12.5px; color:rgba(255,255,255,0.35);">
                                📝 {{ mb_strlen(strip_tags($blog->content)) }} karakter
                            </span>
                        </div>
                    </div>
                </div>

                @if ($blog->has_profanity)
                    <div class="profanity-warning">
                        ⚠️ Bu yazıda yasaklı kelime/ifade tespit edildi. Lütfen içeriği dikkatlice inceleyin.
                    </div>
                @endif

                <div class="content-preview">
                    {{ Str::limit(strip_tags($blog->content), 260) }}
                </div>
            </div>

            <div class="blog-review-footer">
                <form action="{{ route('admin.blogs.approve', $blog) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success btn-sm"
                        onclick="return confirm('Bu yazıyı onaylayıp yayınlamak istediğinizden emin misiniz?')">
                        ✅ Onayla & Yayınla
                    </button>
                </form>

                <form action="{{ route('admin.blogs.reject', $blog) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Bu yazıyı reddetmek istediğinizden emin misiniz?')">
                        ❌ Reddet
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="panel-table-wrap">
            <div class="empty-state">
                <div class="empty-state-icon">🎉</div>
                <div class="empty-state-text">Onay bekleyen yazı bulunmuyor. Her şey temiz!</div>
            </div>
        </div>
    @endforelse

    <div class="pagination-wrap">{{ $blogs->links() }}</div>
@endsection
