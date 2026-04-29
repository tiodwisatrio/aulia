<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
   
    public function index()
    {
        Gate::authorize('manage-users');

        $currentUser = Auth::user();
        $users = User::when(!$currentUser->isDeveloper(), function ($query) use ($currentUser) {
            // Super Admin cannot see Developer users
            if ($currentUser->isSuperAdmin()) {
                return $query->where('role', '!=', 'developer');
            }
        })->latest()->paginate(10);

        return view('users.index', compact('users'));
    }


    public function create()
    {
        Gate::authorize('manage-users');

        $currentUser = Auth::user();

        // Available roles based on current user's permission
        $availableRoles = $this->getAvailableRoles($currentUser);

        return view('users.create', compact('availableRoles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Only Super Admin and Developer can create users
        Gate::authorize('manage-users');

        $currentUser = Auth::user();
        $validated = $request->validated();

        // Super Admin cannot create Developer users
        if ($currentUser->isSuperAdmin() && !$currentUser->isDeveloper()) {
            if ($validated['role'] === 'developer') {
                abort(403, 'Super Admin cannot create Developer users.');
            }
        }

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Only Super Admin and Developer can view user details
        Gate::authorize('manage-users');

        // Super Admin cannot view Developer users
        if (!Auth::user()->isDeveloper() && $user->isDeveloper()) {
            abort(403, 'Unauthorized action.');
        }

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Check if user can modify this user
        Gate::authorize('modify-user', $user);

        $currentUser = Auth::user();

        // Available roles based on current user's permission
        $availableRoles = $this->getAvailableRoles($currentUser);

        return view('users.edit', compact('user', 'availableRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // Check if user can modify this user
        Gate::authorize('modify-user', $user);

        $currentUser = Auth::user();
        $validated = $request->validated();

        // Only Super Admin (not Developer) have role restrictions
        // Developer can modify anyone including themselves
        if ($currentUser->isSuperAdmin() && !$currentUser->isDeveloper()) {
            if (isset($validated['role']) && $validated['role'] === 'developer') {
                abort(403, 'Super Admin cannot assign Developer role.');
            }
            if ($user->isDeveloper()) {
                abort(403, 'Super Admin cannot edit Developer users.');
            }
        }

        // Only hash password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Check if user can modify this user
        Gate::authorize('modify-user', $user);

        $currentUser = Auth::user();

        // Cannot delete yourself
        if (Auth::id() === $user->id) {
            abort(403, 'You cannot delete your own account.');
        }

        // Super Admin cannot delete Developer users
        if ($currentUser->isSuperAdmin() && !$currentUser->isDeveloper()) {
            if ($user->isDeveloper()) {
                abort(403, 'Super Admin cannot delete Developer users.');
            }
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    /**
     * Get available roles based on current user's permission
     */
    private function getAvailableRoles(User $currentUser): array
    {
        $roles = [
            'admin' => 'Admin',
            'super_admin' => 'Super Admin',
            'developer' => 'Developer',
        ];

        // Super Admin cannot assign Developer role
        if ($currentUser->isSuperAdmin() && !$currentUser->isDeveloper()) {
            unset($roles['developer']);
        }

        return $roles;
    }
}