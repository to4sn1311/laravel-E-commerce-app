<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $users = User::with('roles')->get();
    return view('admin.users.index', compact('users'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $roles = Role::all();
    return view('admin.users.create', compact('roles'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreUserRequest $request)
  {
    $validated = $request->validated();

    if ($request->hasFile('avatar')) {
      $avatarPath = $request->file('avatar')->store('avatars', 'public');
      $validated['avatar'] = $avatarPath;
    }

    $user = User::create([
      'name' => $validated['name'],
      'email' => $validated['email'],
      'password' => Hash::make($validated['password']),
      'phone' => $validated['phone'],
      'address' => $validated['address'],
      'avatar' => $validated['avatar'] ?? null
    ]);

    $user->syncRoles($validated['roles']);

    return redirect()->route('users.index')
      ->with('success', 'User created successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(User $user)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(User $user)
  {
    $roles = Role::all();
    return view('admin.users.edit', compact('user', 'roles'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateUserRequest $request, User $user)
  {
    $validated = $request->validated();

    if ($request->hasFile('avatar')) {
      // Delete old avatar if exists
      if ($user->avatar) {
        Storage::disk('public')->delete($user->avatar);
      }
      $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
    }

    // Only include password if it's provided
    if (empty($validated['password'])) {
      unset($validated['password']);
    } else {
      $validated['password'] = Hash::make($validated['password']);
    }

    $user->update($validated);
    $user->syncRoles($validated['roles']);

    return redirect()->route('users.index')
      ->with('success', 'User updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    try {
      $user = User::findOrFail($id);

      if ($user->hasRole('super-admin')) {
        return redirect()->route('users.index')
          ->with('error', 'Cannot delete super-admin user');
      }

      // Remove all roles first
      $user->syncRoles([]);

      // Delete avatar if exists
      if ($user->avatar) {
        Storage::disk('public')->delete($user->avatar);
      }

      // Now delete the user
      $user->delete();

      return redirect()->route('users.index')
        ->with('success', 'User deleted successfully');
    } catch (\Exception $e) {
      return redirect()->route('users.index')
        ->with('error', 'Error deleting user: ' . $e->getMessage());
    }
  }
}
