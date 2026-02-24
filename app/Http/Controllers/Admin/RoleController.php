<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AlertService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function role()
    {
        $roles = Role::where('guard_name', 'admin')->paginate(15);
        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy('group_name');
        // dd($permissions);
        return view('admin.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'required|array',
        ]);
  
        if ($request->name == 'super_admin'){
         return redirect()->route('admin.role')->with('error', 'Super admin role can not be created.');
        }
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'admin',
        ]);

        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.role')->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all()->groupBy('group_name');
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('admin.role.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
            'permissions' => 'nullable|array',
        ]);
        $role = Role::findOrFail($id);
        // super admin role can not be updated
        if ($role->name == 'super_admin'){
         return redirect()->route('admin.role')->with('error', 'Super admin role can not be updated.');
        }
        $role->update(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('admin.role')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        if ($role->name == 'super_admin'){
            return redirect()->route('admin.role')->with('error', 'Super admin role can not be deleted.');
        }
    
        try {
            DB::beginTransaction();
            $role->users()->detach();
            $role->permissions()->detach();
            $role->delete();
            DB::commit();
            return redirect()->route('admin.role')->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.role')->with('error', 'Role deletion failed.');
        }
    }
}
