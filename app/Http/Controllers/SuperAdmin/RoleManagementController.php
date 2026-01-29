<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleManagementController extends Controller
{
 public function roles()
    {
        $roles = Role::with('permissions')
            ->withCount('users')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        $permissions = Permission::all();
        
        // Define role types (you can customize these)
        $roleTypes = [
            'system',
            'custom',
            'department',
            'project',
            'temporary',
        ];

        return Inertia::render('SuperAdmin/Roles', [
            'roles' => $roles,
            'permissions' => $permissions,
            'roleTypes' => $roleTypes,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name|max:125',
            'type' => 'nullable|string|max:191',
            'description' => 'nullable|string|max:500',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
            'type' => $validated['type'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);
        
        $role->syncPermissions($validated['permissions']);

        return redirect()->back();
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:125|unique:roles,name,' . $role->id,
            'type' => 'nullable|string|max:191',
            'description' => 'nullable|string|max:500',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update([
            'name' => $validated['name'],
            'type' => $validated['type'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);
        
        $role->syncPermissions($validated['permissions']);

        return redirect()->back();
    }

    public function destroy(Role $role)
    {
        // Prevent deletion of superadmin role
        if ($role->name === 'superadmin') {
            return redirect()->back()->withErrors(['error' => 'Cannot delete superadmin role']);
        }

        $role->delete();

        return redirect()->back();
    }
}
