@extends('layouts.panel')

@section('title', 'Kullanıcı Yönetimi')

@section('content')

    <div class="page-header">
        <h2 class="page-title">
            <span class="page-title-icon">👥</span>
            Kullanıcı Yönetimi
        </h2>
        <span class="badge badge-gray">Toplam: {{ $users->total() }}</span>
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
                    <th>Kullanıcı</th>
                    <th>E-posta</th>
                    <th>Rol</th>
                    <th>Durum</th>
                    <th>Kayıt Tarihi</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr style="{{ $user->status !== 'active' ? 'opacity:0.55;' : '' }}">
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div class="user-avatar-sm">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</div>
                                <span style="font-weight:600; color:#f1f5f9;">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td style="color:rgba(255,255,255,0.5); font-size:13px;">{{ $user->email }}</td>
                        <td>
                            @if ($user->isSuperAdmin())
                                <span class="badge badge-purple">👑 Süper Admin</span>
                            @else
                                <span class="badge badge-info">✍️ Yazar</span>
                            @endif
                        </td>
                        <td>
                            @if ($user->status === 'active')
                                <span class="badge badge-success">✅ Aktif</span>
                            @elseif ($user->status === 'passive')
                                <span class="badge badge-gray">⏸ Pasif</span>
                            @else
                                <span class="badge badge-danger">🚫 Banlı</span>
                            @endif
                        </td>
                        <td style="color:rgba(255,255,255,0.4); font-size:12.5px;">{{ $user->created_at->format('d.m.Y') }}</td>
                        <td>
                            @if (!$user->isSuperAdmin())
                                <div style="display:flex; align-items:center; gap:6px;">
                                    <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $user->status === 'active' ? 'btn-warning' : 'btn-success' }}">
                                            {{ $user->status === 'active' ? '⏸ Pasifleştir' : '▶️ Aktifleştir' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('{{ $user->name }} kullanıcısını ve TÜM yazılarını kalıcı olarak silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!')">
                                            🗑 Sil
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span style="font-size:12px; color:rgba(255,255,255,0.2); font-style:italic;">— Korumalı —</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">{{ $users->links() }}</div>
@endsection
