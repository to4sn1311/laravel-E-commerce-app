<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $roles = Role::all();
    return view('admin.roles.index', ['roles' => $roles]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $permissions = Permission::all()->groupBy('group');
    return view('admin.roles.create', ['permissions' => $permissions]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|unique:roles|max:255',
      'display_name' => 'required|max:255',
      'group' => 'required|max:255',
      'permissions' => 'required|array|min:1'
    ], [
      'permissions.required' => 'Please select at least one permission',
      'permissions.min' => 'Please select at least one permission'
    ]);

    $role = Role::create([
      'name' => $validated['name'],
      'display_name' => $validated['display_name'],
      'group' => $validated['group'],
      'guard_name' => 'web'
    ]);

    $role->syncPermissions($validated['permissions']);

    return redirect()->route('roles.index')
      ->with('success', 'Role created successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    return 'show';
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $role = Role::findOrFail($id);
    $permissions = Permission::all()->groupBy('group');
    return view('admin.roles.edit', [
      'role' => $role,
      'permissions' => $permissions
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $validated = $request->validate([
      'name' => 'required|max:255|unique:roles,name,' . $id,
      'display_name' => 'required|max:255',
      'group' => 'required|max:255',
      'permissions' => 'required|array|min:1'
    ], [
      'permissions.required' => 'Please select at least one permission',
      'permissions.min' => 'Please select at least one permission'
    ]);

    $role = Role::findOrFail($id);
    $role->update([
      'name' => $validated['name'],
      'display_name' => $validated['display_name'],
      'group' => $validated['group']
    ]);

    $role->syncPermissions($validated['permissions']);

    return redirect()->route('roles.index')
      ->with('success', 'Role updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $role = Role::findOrFail($id);

    // Prevent deletion of super-admin role
    if ($role->name === 'super-admin') {
      return redirect()->route('roles.index')
        ->with('error', 'Cannot delete super-admin role');
    }

    $role->delete();
    return redirect()->route('roles.index')
      ->with('success', 'Role deleted successfully');
  }
}
