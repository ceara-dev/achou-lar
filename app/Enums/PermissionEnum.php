<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case ViewUsers = 'view users';
    case CreateUsers = 'create users';
    case EditUsers = 'edit users';
    case DeleteUsers = 'delete users';
    case ViewRoles = 'view roles';
    case CreateRoles = 'create roles';
    case EditRoles = 'edit roles';
    case DeleteRoles = 'delete roles';
    case ViewPermissions = 'view permissions';
    case CreatePermissions = 'create permissions';
    case EditPermissions = 'edit permissions';
    case DeletePermissions = 'delete permissions';
    case ViewAudits = 'view audits';
    case ViewDashboard = 'view dashboard';
    case ViewCompanies = 'view companies';
    case CreateCompanies = 'create companies';
    case EditCompanies = 'edit companies';
    case DeleteCompanies = 'delete companies';
}
