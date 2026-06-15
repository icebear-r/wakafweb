<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Slider;
use App\Models\Article;
use App\Models\Kategori;
use App\Models\Program;
use App\Models\FeaturedProgram;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FeaturedProgramController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserManagementController;

/* route halaman */
Route::get('/', function () {
    $sliders = Slider::where('is_active', true)->orderBy('position')->get();
    $featuredPrograms = FeaturedProgram::with('program')
        ->where('is_active', true)
        ->whereHas('program')
        ->orderBy('position')
        ->take(3)
        ->get()
        ->pluck('program');
    $latestArticles = Article::where('is_active', true)->latest('updated_at')->take(4)->get();

    return view('beranda', compact('sliders', 'featuredPrograms', 'latestArticles'));
});

Route::get('/beranda', function () {
    $sliders = Slider::where('is_active', true)->orderBy('position')->get();
    $featuredPrograms = FeaturedProgram::with('program')
        ->where('is_active', true)
        ->whereHas('program')
        ->orderBy('position')
        ->take(3)
        ->get()
        ->pluck('program');
    $latestArticles = Article::where('is_active', true)->latest('updated_at')->take(4)->get();

    return view('beranda', compact('sliders', 'featuredPrograms', 'latestArticles'));
})->name('beranda');

Route::get('/program', function () {
    $categoryOrder = ['Pendidikan', 'Lingkungan', 'Ekonomi', 'Ibadah', 'Kemanusiaan'];
    $categories = Kategori::whereIn('nama_kategori', $categoryOrder)
        ->orderByRaw("FIELD(nama_kategori, '" . implode("','", $categoryOrder) . "')")
        ->get();
    $programs = Program::latest('created_at')->get();

    return view('program', compact('categories', 'programs'));
})->name('program');

Route::get('/program/{program}', function (Program $program) {
    return view('detailprogram', compact('program'));
})->name('program.detail');

Route::get('/artikel', function () {
    $articles = Article::where('is_active', true)->latest('updated_at')->get();

    return view('artikel', compact('articles'));
})->name('artikel');

Route::get('/artikel/{article}', function (Article $article) {
    return view('detailartikel', compact('article'));
})->name('artikel.detail');

Route::get('/tentangkami', function () {
    return view('tentangkami');
})->name('tentangkami');

/* route login */
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $request->validate([
        'user_id' => ['required'],
        'password' => ['required'],
    ]);

    $user = User::where('user_id', $request->user_id)->first();

    $storedPassword = (string) $user?->password;
    $storedPasswordAlgo = password_get_info($storedPassword)['algo'];
    $storedPasswordIsHash = $storedPasswordAlgo !== null && $storedPasswordAlgo !== 0;
    $passwordMatches = $user && (
        ($storedPasswordIsHash && Hash::check($request->password, $storedPassword)) ||
        hash_equals($storedPassword, (string) $request->password)
    );

    if ($passwordMatches) {
        if (! $storedPasswordIsHash || Hash::needsRehash($storedPassword)) {
            $user->password = $request->password;
            $user->save();
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('admin');
    }

    return back()->withErrors([
        'user_id' => 'User ID atau password salah.',
    ]);
})->name('login.process');

Route::get('/admin', function () {
    $managedUsers = Auth::user()?->role === 'superadmin'
        ? User::orderBy('created_at', 'desc')->get()
        : collect();

    return view('admin', compact('managedUsers'));
})->middleware('auth')->name('admin');

Route::middleware('auth')->group(function () {
    Route::post('/admin/users', [UserManagementController::class, 'store'])->name('admin.users.store');
    Route::put('/admin/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('admin.users.update-role');

    Route::get('/kelolacard', [SliderController::class, 'index'])->name('kelolacard');
    Route::post('/kelolacard', [SliderController::class, 'store'])->name('sliders.store');
    Route::put('/kelolacard/{slider}', [SliderController::class, 'update'])->name('sliders.update');
    Route::delete('/kelolacard/{slider}', [SliderController::class, 'destroy'])->name('sliders.destroy');
    Route::post('/kelolacard/reorder', [SliderController::class, 'reorder'])->name('sliders.reorder');

    Route::get('/kelolaprogramunggulan', [FeaturedProgramController::class, 'index'])->name('kelolaprogramunggulan');
    Route::post('/kelolaprogramunggulan', [FeaturedProgramController::class, 'store'])->name('featured-programs.store');
    Route::put('/kelolaprogramunggulan/{featuredProgram}', [FeaturedProgramController::class, 'update'])->name('featured-programs.update');
    Route::delete('/kelolaprogramunggulan/{featuredProgram}', [FeaturedProgramController::class, 'destroy'])->name('featured-programs.destroy');
    Route::post('/kelolaprogramunggulan/reorder', [FeaturedProgramController::class, 'reorder'])->name('featured-programs.reorder');

    Route::get('/kelolaprogram', [ProgramController::class, 'index'])->name('kelolaprogram');
    Route::post('/kelolaprogram', [ProgramController::class, 'store'])->name('programs.store');
    Route::put('/kelolaprogram/{program}', [ProgramController::class, 'update'])->name('programs.update');
    Route::delete('/kelolaprogram/{program}', [ProgramController::class, 'destroy'])->name('programs.destroy');

    Route::get('/kelolaartikel', [ArticleController::class, 'index'])->name('kelolaartikel');
    Route::post('/kelolaartikel', [ArticleController::class, 'store'])->name('articles.store');
    Route::put('/kelolaartikel/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/kelolaartikel/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});
