<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Support\PublicUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::latest('updated_at')->get();

        return view('kelolaartikel', compact('articles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        if ($this->wordCount($data['excerpt'] ?? '') > 18) {
            return back()
                ->withErrors(['excerpt' => 'Ringkasan artikel maksimal 18 kata agar tampil penuh di card.'])
                ->withInput();
        }

        Article::create([
            'title' => $data['title'],
            'excerpt' => $data['excerpt'] ?? null,
            'content' => $data['content'] ?? null,
            'image' => $request->hasFile('image')
                ? PublicUpload::store($request->file('image'), 'articles')
                : null,
            'is_active' => true,
        ]);

        return back()->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($this->wordCount($data['excerpt'] ?? '') > 18) {
            return back()
                ->withErrors(['excerpt' => 'Ringkasan artikel maksimal 18 kata agar tampil penuh di card.'])
                ->withInput();
        }

        $article->title = $data['title'];
        $article->excerpt = $data['excerpt'] ?? null;
        $article->content = $data['content'] ?? null;
        $article->is_active = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($article->image) {
                PublicUpload::delete($article->image);
            }

            $article->image = PublicUpload::store($request->file('image'), 'articles');
        }

        $article->save();

        return back()->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        if ($article->image) {
            PublicUpload::delete($article->image);
        }

        $article->delete();

        return back()->with('success', 'Artikel berhasil dihapus.');
    }

    private function wordCount(?string $text): int
    {
        preg_match_all('/\S+/u', trim((string) $text), $matches);

        return count($matches[0]);
    }
}
