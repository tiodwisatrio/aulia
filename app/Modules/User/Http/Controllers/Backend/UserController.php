<?php

namespace App\Modules\User\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\User\Models\User;
use App\Modules\User\Http\Requests\StoreUserRequest;
use App\Modules\User\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Role visibility rules:
     * - developer   : can see/manage admin, super_admin, developer
     * - super_admin : can see/manage admin, super_admin
     * - admin       : can see/manage admin only
     */
    private function visibleRoles(): array
    {
        $role = Auth::user()->role;
        return match($role) {
            'developer'   => ['admin', 'super_admin', 'developer'],
            'super_admin' => ['admin', 'super_admin'],
            default       => ['admin'],
        };
    }

    private function canManage(User $target): bool
    {
        return in_array($target->role, $this->visibleRoles());
    }

    public function index(Request $request)
    {
        $users = User::whereIn('role', $this->visibleRoles())->latest()->paginate(10);
        return view('user::backend.index', compact('users'));
    }

    public function create()
    {
        $availableRoles = $this->getAvailableRoles();
        return view('user::backend.create', compact('availableRoles'));
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        if (!in_array($validated['role'], $this->visibleRoles())) {
            abort(403, 'Anda tidak berhak membuat user dengan role tersebut.');
        }

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function show(User $user)
    {
        if (!$this->canManage($user)) abort(403);
        return view('user::backend.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (!$this->canManage($user)) abort(403);
        $availableRoles = $this->getAvailableRoles();
        return view('user::backend.edit', compact('user', 'availableRoles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        if (!$this->canManage($user)) abort(403);

        $validated = $request->validated();

        if (!in_array($validated['role'], $this->visibleRoles())) {
            abort(403, 'Anda tidak berhak menetapkan role tersebut.');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        if (!$this->canManage($user)) abort(403);

        if (Auth::id() === $user->id) {
            abort(403, 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }

    private function getAvailableRoles(): array
    {
        $all = [
            'admin'       => 'Admin',
            'super_admin' => 'Super Admin',
            'developer'   => 'Developer',
        ];

        return array_intersect_key($all, array_flip($this->visibleRoles()));
    }
}
