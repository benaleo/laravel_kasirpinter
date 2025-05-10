<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Roles/Index');
    }

    public function store(RoleRequest $request)
    {
        $role = Role::create($request->validated());
        
        if (isset($request->permissions)) {
            $role->permissions()->sync($request->permissions);
        }

        return $role;
    }

    public function show(Role $role)
    {
        return $role->load('permissions');
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        
        if (isset($request->permissions)) {
            $role->permissions()->sync($request->permissions);
        }

        return $role->load('permissions');
    }

    public function destroy(Role $role)
    {
        $role->permissions()->detach();
        $role->delete();

        return response()->json();
    }

    public function availablePermissions(Request $request)
    {
        $query = Permission::query();
        
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return $query->get(['id', 'name', 'description']);
    }
}
