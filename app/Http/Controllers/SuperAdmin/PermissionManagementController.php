<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use Spatie\Permission\Models\Permission;

class PermissionManagementController extends Controller
{
      public function permissions()
    {
        $permissions = Permission::orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('SuperAdmin/Permissions', [
            'permissions' => $permissions,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name|max:125',
            'description' => 'nullable|string|max:500',
        ]);

        Permission::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:125|unique:permissions,name,' . $permission->id,
            'description' => 'nullable|string|max:500',
        ]);

        $permission->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->back();
    }

    public function destroy(Permission $permission)
    {
        // Check if permission is being used by any roles
        if ($permission->roles()->count() > 0) {
            return redirect()->back()->withErrors(['error' => 'Cannot delete permission that is assigned to roles']);
        }

        $permission->delete();

        return redirect()->back();
    }
}
