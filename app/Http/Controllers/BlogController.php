<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use App\Services\ProfanityService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function __construct(private ProfanityService $profanityService)
    {
    }

    /**
     * Yazarın kendi blog yazılarını listeler.
     */
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();

        $blogs = $user->blogs()
            ->with('category')
            ->latest()
            ->paginate(15);

        return view('yazar.blogs.index', compact('blogs'));
    }

    /**
     * Yeni yazı oluşturma formu.
     */
    public function create(): View
    {
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        return view('yazar.blogs.create', compact('categories'));
    }

    /**
     * Yeni yazıyı kaydeder.
     * - Küfür filtresinden geçirir (has_profanity alanını set eder)
     * - Status otomatik 'pending' olarak ayarlanır
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content'     => 'required|string|min:50',
        ]);

        // Küfür filtresi kontrolü
        $hasProfanity = $this->profanityService->check(
            $request->title . ' ' . $request->content
        );

        $blog = Blog::create([
            'user_id'      => Auth::id(),
            'category_id'  => $request->category_id,
            'title'        => $request->title,
            'slug'         => Str::slug($request->title) . '-' . time(),
            'content'      => $request->content,
            'status'       => 'pending',  // Her zaman onay bekliyor
            'has_profanity' => $hasProfanity,
        ]);

        $message = 'Yazınız başarıyla gönderildi. Admin onayından sonra yayınlanacak.';

        if ($hasProfanity) {
            $message .= ' ⚠️ Not: Yazınızda sakıncalı içerik tespit edildi, bu durum admin panelinde görünecektir.';
        }

        return redirect()->route('yazar.blogs.index')->with('success', $message);
    }

    /**
     * Yazarın kendi yazısını düzenleme formu.
     */
    public function edit(Blog $blog): View
    {
        // Sadece kendi yazısını düzenleyebilir
        abort_if($blog->user_id !== Auth::id(), 403);

        // Onaylanmış yazı düzenlenemez
        abort_if($blog->status === 'approved', 403, 'Onaylanmış yazılar düzenlenemez.');

        $categories = Category::where('status', 'active')->orderBy('name')->get();
        return view('yazar.blogs.edit', compact('blog', 'categories'));
    }

    /**
     * Yazıyı günceller ve tekrar onaya gönderir.
     */
    public function update(Request $request, Blog $blog): RedirectResponse
    {
        abort_if($blog->user_id !== Auth::id(), 403);
        abort_if($blog->status === 'approved', 403);

        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content'     => 'required|string|min:50',
        ]);

        $hasProfanity = $this->profanityService->check(
            $request->title . ' ' . $request->content
        );

        $blog->update([
            'category_id'  => $request->category_id,
            'title'        => $request->title,
            'slug'         => Str::slug($request->title) . '-' . time(),
            'content'      => $request->content,
            'status'       => 'pending',  // Güncelleme sonrası tekrar onaya gider
            'has_profanity' => $hasProfanity,
        ]);

        return redirect()->route('yazar.blogs.index')
            ->with('success', 'Yazı güncellendi ve tekrar onaya gönderildi.');
    }

    /**
     * Yazarın kendi yazısını siler.
     */
    public function destroy(Blog $blog): RedirectResponse
    {
        abort_if($blog->user_id !== Auth::id(), 403);

        $title = $blog->title;
        $blog->delete();

        return redirect()->route('yazar.blogs.index')
            ->with('success', "\"$title\" başlıklı yazı silindi.");
    }
}
