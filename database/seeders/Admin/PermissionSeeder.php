<?php

namespace Database\Seeders\Admin;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            ['id' => '1', 'name' => 'view admin', 'guard_name' => 'admin', 'group_name' => 'admin', 'created_at' => '2026-02-24 05:27:25', 'updated_at' => '2026-02-24 05:27:25'],
            ['id' => '2', 'name' => 'create admin', 'guard_name' => 'admin', 'group_name' => 'admin', 'created_at' => '2026-02-24 05:27:25', 'updated_at' => '2026-02-24 05:27:25'],
            ['id' => '3', 'name' => 'edit admin', 'guard_name' => 'admin', 'group_name' => 'admin', 'created_at' => '2026-02-24 05:27:25', 'updated_at' => '2026-02-24 05:27:25'],
            ['id' => '4', 'name' => 'delete admin', 'guard_name' => 'admin', 'group_name' => 'admin', 'created_at' => '2026-02-24 05:27:25', 'updated_at' => '2026-02-24 05:27:25'],
            ['id' => '5', 'name' => 'view role', 'guard_name' => 'admin', 'group_name' => 'Role', 'created_at' => '2026-02-24 05:27:25', 'updated_at' => '2026-02-24 05:27:25'],
            ['id' => '6', 'name' => 'create role', 'guard_name' => 'admin', 'group_name' => 'Role', 'created_at' => '2026-02-24 05:27:25', 'updated_at' => '2026-02-24 05:27:25'],
            ['id' => '7', 'name' => 'edit role', 'guard_name' => 'admin', 'group_name' => 'Role', 'created_at' => '2026-02-24 05:27:25', 'updated_at' => '2026-02-24 05:27:25'],
            ['id' => '8', 'name' => 'delete role', 'guard_name' => 'admin', 'group_name' => 'Role', 'created_at' => '2026-02-24 05:27:25', 'updated_at' => '2026-02-24 05:27:25'],
            ['id' => '9', 'name' => 'view permission', 'guard_name' => 'admin', 'group_name' => 'Permission', 'created_at' => '2026-02-24 05:27:25', 'updated_at' => '2026-02-24 05:27:25'],
            ['id' => '10', 'name' => 'create permission', 'guard_name' => 'admin', 'group_name' => 'Permission', 'created_at' => '2026-02-24 05:27:25', 'updated_at' => '2026-02-24 05:27:25'],
            ['id' => '11', 'name' => 'edit permission', 'guard_name' => 'admin', 'group_name' => 'Permission', 'created_at' => '2026-02-24 05:27:25', 'updated_at' => '2026-02-24 05:27:25'],
            ['id' => '12', 'name' => 'delete permission', 'guard_name' => 'admin', 'group_name' => 'Permission', 'created_at' => '2026-02-24 05:27:25', 'updated_at' => '2026-02-24 05:27:25'],

        ];

        DB::table('permissions')->insert($permissions);
    }
}
