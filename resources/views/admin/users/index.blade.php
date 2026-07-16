@extends('layouts.panel')

@section('title', 'Kullanıcı Yönetimi')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">👥 Kullanıcı Yönetimi</h2>
        <span class="text-sm text-gray-500">Toplam: {{ $users->total() }}</span>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-4">✅ {{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4">❌ {{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">Kullanıcı</th>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">E-posta</th>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">Rol</th>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">Durum</th>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">Kayıt Tarihi</th>
                    <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">İşlemler</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50 {{ $user->status !== 'active' ? 'opacity-60' : '' }}">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-sm font-bold text-gray-600">
                                    {{ mb_substr($user->name, 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            @if ($user->isSuperAdmin())
                                <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded-full font-medium">👑 Süper Admin</span>
                            @else
                                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full font-medium">✍️ Yazar</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if ($user->status === 'active')
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">✅ Aktif</span>
                            @elseif ($user->status === 'passive')
                                <span class="text-xs bg-gray-200 text-gray-600 px-2 py-1 rounded-full">⏸ Pasif</span>
                            @else
                                <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full">🚫 Banlı</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $user->created_at->format('d.m.Y') }}</td>
                        <td class="px-4 py-3">
                            @if (!$user->isSuperAdmin())
                                <div class="flex items-center gap-2">
                                    {{-- Aktif/Pasif Toggle --}}
                                    <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="text-xs {{ $user->status === 'active' ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }} px-2 py-1 rounded transition">
                                            {{ $user->status === 'active' ? '⏸ Pasifleştir' : '▶️ Aktifleştir' }}
                                        </button>
                                    </form>

                                    {{-- Sil (Cascade ile tüm yazıları da silinir) --}}
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="text-xs bg-red-100 text-red-700 hover:bg-red-200 px-2 py-1 rounded transition"
                                            onclick="return confirm('{{ $user->name }} kullanıcısını ve TÜM yazılarını kalıcı olarak silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!')">
                                            🗑 Sil
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-xs text-gray-400 italic">— Korumalı —</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
@endsection
