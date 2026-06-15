<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Support\PublicUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SliderController extends Controller
{
    public function index(): View
    {
        $sliders = Slider::orderBy('position')->orderByDesc('created_at')->get();

        return view('kelolacard', compact('sliders'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:120'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $lastPosition = Slider::max('position') ?? 0;

        Slider::create([
            'title' => $data['title'] ?? null,
            'image' => PublicUpload::store($request->file('image'), 'sliders'),
            'position' => $lastPosition + 1,
            'is_active' => true,
        ]);

        return back()->with('success', 'Gambar slider berhasil ditambahkan.');
    }

    public function update(Request $request, Slider $slider): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:120'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $slider->title = $data['title'] ?? null;
        $slider->is_active = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            PublicUpload::delete($slider->image);
            $slider->image = PublicUpload::store($request->file('image'), 'sliders');
        }

        $slider->save();

        return back()->with('success', 'Gambar slider berhasil diperbarui.');
    }

    public function destroy(Slider $slider): RedirectResponse
    {
        PublicUpload::delete($slider->image);
        $slider->delete();

        return back()->with('success', 'Gambar slider berhasil dihapus.');
    }

    public function reorder(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'slider_ids' => ['required', 'array'],
            'slider_ids.*' => ['integer', 'exists:sliders,id'],
        ]);

        foreach ($data['slider_ids'] as $index => $sliderId) {
            Slider::whereKey($sliderId)->update(['position' => $index + 1]);
        }

        return back()->with('success', 'Urutan slider berhasil disimpan.');
    }
}
