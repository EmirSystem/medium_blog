<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminBlogController extends Controller
{
    /**
     * Onay bekleyen blog yazılarını listeler.
     */
    public function pending(): View
    {
        $blogs = Blog::where('status', 'pending')
            ->with(['user', 'category'])
            ->latest()
            ->paginate(15);

        return view('admin.blogs.pending', compact('blogs'));
    }

    /**
     * Blog yazısını onaylar.
     */
    public function approve(Blog $blog): RedirectResponse
    {
        $blog->update([
            'status'       => 'approved',
            'published_at' => now(),
        ]);

        return redirect()->route('admin.blogs.pending')
            ->with('success', "\"$blog->title\" başlıklı yazı onaylandı ve yayınlandı.");
    }

    /**
     * Blog yazısını reddeder.
     */
    public function reject(Request $request, Blog $blog): RedirectResponse
    {
        $blog->update([
            'status' => 'rejected',
        ]);

        return redirect()->route('admin.blogs.pending')
            ->with('error', "\"$blog->title\" başlıklı yazı reddedildi.");
    }

    /**
     * Tüm blog yazılarını listeler (admin için).
     */
    public function index(): View
    {
        $blogs = Blog::with(['user', 'category'])
            ->latest()
            ->paginate(20);

        return view('admin.blogs.index', compact('blogs'));
    }
}
