<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'role' => 'required|in:customer,admin',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(32)),
            'role' => $data['role'],
        ]);

        // Send password reset notification
        $token = app('auth.password.broker')->createToken($user);
        $user->sendPasswordResetNotification($token);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully. A password reset link has been sent to their email.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() === $user->id && $request->has('role') && $request->role !== $user->role->value) {
            return redirect()->back()->with('error', 'You cannot change your own role.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:customer,admin'],
        ]);

        if ($data['role'] === 'admin' && $user->role->value !== 'admin') {
            if ($user->orders()->exists() || $user->payments()->exists()) {
                return redirect()->back()->with('error', 'A role promoting user should have a brand new account.');
            }
        }

        $role = $data['role'] ?? null;
        unset($data['role']);

        $user->update($data);

        if ($role) {
            $user->changeRole(UserRole::from($role));
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
