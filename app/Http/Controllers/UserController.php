<?php

namespace App\Http\Controllers;


use App\Model\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function create()
    {
//        $role = Role::create(['name' => 'kpzg']);
//
        $permission = Permission::create(['name' => 'save Invoice']);

//        $role->givePermissionTo($permission);
//        $permission->assignRole($role);

//        $role->syncPermissions($permission);
//        return $permission->syncRoles($role);

//        $role->revokePermissionTo($permission);
//        $permission->removeRole($role);

//        $a=  User::query()->getProcessor();
//        var_dump($a);
        $user = User::query()->where('ID', 79)->first();
        $user->givePermissionTo('edit articles');
        return $user->getPermissionNames();
    }
}