<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    private const ROLES = ['admin', 'superadmin'];

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeSuperAdmin($request);

        $validated = $request->validate([
            'user_id' => ['required', 'string', 'max:100', 'unique:user,user_id'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            'role' => ['required', Rule::in(self::ROLES)],
        ]);

        User::create($validated);

        return back()->with('success', 'User baru berhasil ditambahkan.');
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $this->authorizeSuperAdmin($request);

        $validated = $request->validate([
            'role' => ['required', Rule::in(self::ROLES)],
        ]);

        if ($request->user()->is($user) && $validated['role'] !== 'superadmin') {
            return back()->withErrors([
                'role' => 'Role akun superadmin yang sedang digunakan tidak bisa diturunkan.',
            ]);
        }

        $user->update($validated);

        return back()->with('success', 'Role user berhasil diperbarui.');
    }

    private function authorizeSuperAdmin(Request $request): void
    {
        abort_unless($request->user()?->role === 'superadmin', 403);
    }
}
