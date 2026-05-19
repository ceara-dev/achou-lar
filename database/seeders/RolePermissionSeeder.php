<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()['cache']->forget('spatie.permission.cache');

        $permissions = collect(PermissionEnum::cases())
            ->map(fn(PermissionEnum $p) => Permission::findOrCreate($p->value, 'web'));

        $admin = Role::findOrCreate(RoleEnum::Admin->value, 'web');
        $admin->givePermissionTo($permissions);

        $manager = Role::findOrCreate(RoleEnum::Manager->value, 'web');
        $manager->givePermissionTo([
            PermissionEnum::ViewUsers->value,
            PermissionEnum::CreateUsers->value,
            PermissionEnum::EditUsers->value,
            PermissionEnum::ViewRoles->value,
            PermissionEnum::ViewPermissions->value,
            PermissionEnum::ViewAudits->value,
            PermissionEnum::ViewDashboard->value,
            PermissionEnum::ViewCompanies->value,
            PermissionEnum::CreateCompanies->value,
            PermissionEnum::EditCompanies->value,
        ]);

        Role::findOrCreate(RoleEnum::User->value, 'web');
    }
}
