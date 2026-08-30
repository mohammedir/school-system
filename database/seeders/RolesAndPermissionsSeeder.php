<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'Student management' => [
                'Students Section View',
                'Student view.blade.php',
                'Student create',
                'Student edit',
                'Delete Student',
            ],
            'User and Permission Management' =>[
                'User and Permission Management Section View',
                'users view.blade.php',
                'user view.blade.php',
                'user create',
                'user edit',
                'user change password',
                'user delete',
                'roles view.blade.php',
                'roles view.blade.php',
                'role view.blade.php',
                'role create',
                'role edit',
            ],
            'Settings' => [
                'Settings Section View',
                'List edit',
                'Delete List',
            ],
            'Reports' => [
                'Reports Section View'
            ]
        ];

        foreach ($permissions as $group => $actions) {
            foreach ($actions as $name) {
                Permission::firstOrCreate(
                    ['name' => $name, 'guard_name' => 'web'],
                    ['group' => $group]
                );
            }
        }



        // Create roles and assign existing permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());


        $user = User::find(1);
        if ($user) {
            $user->assignRole('admin');
        }

    }

}
