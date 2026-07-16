<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminCategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('blogs')->latest()->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:500',
        ]);

        Category::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'status'      => 'active',
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', "\"$request->name\" kategorisi oluşturuldu.");
    }

    /**
     * Kategoriyi silmek yerine pasifize eder (status = passive).
     * Pasif kategorideki yazılar web'de gizlenir.
     */
    public function toggleStatus(Category $category): RedirectResponse
    {
        $newStatus = $category->status === 'active' ? 'passive' : 'active';
        $category->update(['status' => $newStatus]);

        $msg = $newStatus === 'passive'
            ? "\"$category->name\" kategorisi pasifleştirildi. İlgili yazılar gizlendi."
            : "\"$category->name\" kategorisi aktifleştirildi.";

        return redirect()->route('admin.categories.index')->with('success', $msg);
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
        return redirect()->route('admin.categories.index')
            ->with('success', "\"$category->name\" kategorisi silindi.");
    }
}
