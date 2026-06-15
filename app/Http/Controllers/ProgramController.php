<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Program;
use App\Support\PublicUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(): View
    {
        $categoryOrder = ['Pendidikan', 'Lingkungan', 'Ekonomi', 'Ibadah', 'Kemanusiaan'];
        $categories = Kategori::whereIn('nama_kategori', $categoryOrder)
            ->orderByRaw("FIELD(nama_kategori, '" . implode("','", $categoryOrder) . "')")
            ->get();
        $programs = Program::latest('created_at')->get();

        return view('kelolaprogram', compact('categories', 'programs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:100'],
            'kategori_id' => ['required', 'integer', 'exists:kategori,id'],
            'deskripsi' => ['required', 'string'],
            'artikel_program' => ['required', 'string'],
            'gambar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        Program::create([
            'judul' => $data['judul'],
            'kategori_id' => $data['kategori_id'],
            'programkategori_id' => $data['kategori_id'],
            'deskripsi' => $data['deskripsi'],
            'artikel_program' => $data['artikel_program'],
            'gambar' => PublicUpload::store($request->file('gambar'), 'programs'),
        ]);

        return back()->with('success', 'Program berhasil ditambahkan.');
    }

    public function update(Request $request, Program $program): RedirectResponse
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:100'],
            'kategori_id' => ['required', 'integer', 'exists:kategori,id'],
            'deskripsi' => ['required', 'string'],
            'artikel_program' => ['required', 'string'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $program->judul = $data['judul'];
        $program->kategori_id = $data['kategori_id'];
        $program->programkategori_id = $data['kategori_id'];
        $program->deskripsi = $data['deskripsi'];
        $program->artikel_program = $data['artikel_program'];

        if ($request->hasFile('gambar')) {
            if ($program->gambar) {
                PublicUpload::delete($program->gambar);
            }

            $program->gambar = PublicUpload::store($request->file('gambar'), 'programs');
        }

        $program->save();

        return back()->with('success', 'Program berhasil diperbarui.');
    }

    public function destroy(Program $program): RedirectResponse
    {
        if ($program->gambar) {
            PublicUpload::delete($program->gambar);
        }

        $program->delete();

        return back()->with('success', 'Program berhasil dihapus.');
    }
}
