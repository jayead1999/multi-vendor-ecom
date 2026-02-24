<?php
namespace App\Helpers;
use Spatie\Permission\Models\Role;

// if (!function_exists('getRoleName')) {
//     function getRoleName($roleId) {
//         $role = Role::find($roleId);
//         return $role ? $role->name : 'No Role';
//     }
// }

if (!function_exists('hasPermission')){
    function hasPermission(array $permissions):bool{
        return auth('admin')->user()->hasAnyPermission($permissions); 
    }
}