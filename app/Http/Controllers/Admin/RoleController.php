<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->withCount('users')->paginate(10);
        return Inertia::render('Admin/Roles/Index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy(fn($p) => explode(' ', $p->name)[1] ?? 'general');
        return Inertia::render('Admin/Roles/Create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create(['name' => $request->name]);

        if ($request->filled('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Função criada com sucesso.');
    }

    public function show(Role $role)
    {
        $role->load('permissions');
        return Inertia::render('Admin/Roles/Show', compact('role'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(fn($p) => explode(' ', $p->name)[1] ?? 'general');
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return Inertia::render('Admin/Roles/Edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Função atualizada com sucesso.');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'admin') {
            return redirect()->route('admin.roles.index')
                ->with('error', 'A função admin não pode ser excluída.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Função excluída com sucesso.');
    }
}
