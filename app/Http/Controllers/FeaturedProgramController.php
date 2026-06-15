<?php

namespace App\Http\Controllers;

use App\Models\FeaturedProgram;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeaturedProgramController extends Controller
{
    public function index(): View
    {
        $featuredPrograms = FeaturedProgram::with('program')->orderBy('position')->orderByDesc('created_at')->get();
        $programs = Program::latest('created_at')->get();

        return view('kelolaprogramunggulan', compact('featuredPrograms', 'programs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'program_id' => ['required', 'integer', 'exists:program,id', 'unique:featured_programs,program_id'],
        ]);

        $program = Program::findOrFail($data['program_id']);
        $lastPosition = FeaturedProgram::max('position') ?? 0;

        FeaturedProgram::create([
            'program_id' => $program->id,
            'title' => $program->judul,
            'image' => $program->gambar ?: '',
            'position' => $lastPosition + 1,
            'is_active' => true,
        ]);

        return back()->with('success', 'Program berhasil ditambahkan ke Program Unggulan.');
    }

    public function update(Request $request, FeaturedProgram $featuredProgram): RedirectResponse
    {
        $data = $request->validate([
            'program_id' => ['required', 'integer', 'exists:program,id', 'unique:featured_programs,program_id,' . $featuredProgram->id],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $program = Program::findOrFail($data['program_id']);

        $featuredProgram->program_id = $program->id;
        $featuredProgram->title = $program->judul;
        $featuredProgram->image = $program->gambar ?: '';
        $featuredProgram->is_active = $request->boolean('is_active');

        $featuredProgram->save();

        return back()->with('success', 'Pengaturan Program Unggulan berhasil diperbarui.');
    }

    public function destroy(FeaturedProgram $featuredProgram): RedirectResponse
    {
        $featuredProgram->delete();

        return back()->with('success', 'Program berhasil dihapus dari Program Unggulan.');
    }

    public function reorder(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'featured_program_ids' => ['required', 'array'],
            'featured_program_ids.*' => ['integer', 'exists:featured_programs,id'],
        ]);

        foreach ($data['featured_program_ids'] as $index => $programId) {
            FeaturedProgram::whereKey($programId)->update(['position' => $index + 1]);
        }

        return back()->with('success', 'Urutan program unggulan berhasil disimpan.');
    }
}
