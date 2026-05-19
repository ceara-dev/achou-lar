<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::with('roles')->paginate(10);
        return Inertia::render('Admin/Permissions/Index', compact('permissions'));
    }

    public function show(Permission $permission)
    {
        $permission->load('roles');
        return Inertia::render('Admin/Permissions/Show', compact('permission'));
    }
}
