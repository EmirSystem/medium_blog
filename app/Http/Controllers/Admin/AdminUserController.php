<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        $users = User::with('role')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Kullanıcıyı siler. On delete cascade sayesinde
     * blog yazıları da otomatik silinir.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Süper Admin silinemez.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "\"$name\" kullanıcısı ve tüm yazıları silindi.");
    }

    /**
     * Kullanıcı hesabını aktif/pasif/banlı yapar (silmeden statü değiştirme).
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Süper Admin durumu değiştirilemez.');
        }

        $newStatus = $user->status === 'active' ? 'passive' : 'active';
        $user->update(['status' => $newStatus]);

        $msg = $newStatus === 'passive'
            ? "\"$user->name\" kullanıcısı pasifleştirildi."
            : "\"$user->name\" kullanıcısı aktifleştirildi.";

        return redirect()->route('admin.users.index')->with('success', $msg);
    }
}
