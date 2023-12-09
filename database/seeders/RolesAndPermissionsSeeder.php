<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Misc
        $miscPermission = Permission::create(['name' => 'N/A']);

        // USER MODEL
        $user_create = Permission::create(['name' => 'create: user']);
        $user_read = Permission::create(['name' => 'read: user']);
        $user_update = Permission::create(['name' => 'update: user']);
        $user_delete = Permission::create(['name' => 'delete: user']);

        // ROLE MODEL
        $role_create = Permission::create(['name' => 'create: role']);
        $role_read = Permission::create(['name' => 'read: role']);
        $role_update = Permission::create(['name' => 'update: role']);
        $role_delete = Permission::create(['name' => 'delete: role']);

        // PERMISSION MODEL
        $permission_create = Permission::create(['name' => 'create: permission']);
        $permission_read = Permission::create(['name' => 'read: permission']);
        $permission_update = Permission::create(['name' => 'update: permission']);
        $permission_delete = Permission::create(['name' => 'delete: permission']);

        // ADMINS
        $admin_create = Permission::create(['name' => 'read: admin']);
        $admin_update = Permission::create(['name' => 'update: admin']);

        // CREATE ROLES
        $userRole = Role::create(['name' => 'user'])->syncPermissions([
            $miscPermission,
        ]);

        $superAdminRole = Role::create(['name' => 'super-admin'])->syncPermissions([
            $user_create,
            $user_read,
            $user_update,
            $user_delete,
            $role_create,
            $role_read,
            $role_update,
            $role_delete,
            $permission_create,
            $permission_read,
            $permission_update,
            $permission_delete,
            $admin_create,
            $admin_update,
        ]);
        $adminRole = Role::create(['name' => 'admin'])->syncPermissions([
            $user_create,
            $user_read,
            $user_update,
            $user_delete,
            $role_create,
            $role_read,
            $role_update,
            $role_delete,
            $permission_create,
            $permission_read,
            $permission_update,
            $permission_delete,
            $admin_update,
        ]);

        $mdRole = Role::create(['name' => 'md'])->syncPermissions([
            $user_create,
            $user_read,
            $user_update,
            $user_delete,
        ]);
        $cosRole = Role::create(['name' => 'cos'])->syncPermissions([
            $user_read,
            $role_read,
            $permission_read,
            $admin_create,
        ]);
        $hsdRole = Role::create(['name' => 'hsd'])->syncPermissions([
            $user_create,
            $user_read,
            $user_update,
        ]);

        $engineerRole = Role::create(['name' => 'engineer'])->syncPermissions([
            $user_create,
            $user_read,
            $user_update,
        ]);

        // CREATE ADMINS & USERS
        User::create([
            'name' => 'super admin',
            'is_admin' => 1,
            'email' => 'super@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ])->assignRole($superAdminRole);

        User::create([
            'name' => 'admin',
            'is_admin' => 1,
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ])->assignRole($adminRole);

        User::create([
            'name' => 'md',
            'is_admin' => 1,
            'email' => 'md@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ])->assignRole($mdRole);

        User::create([
            'name' => 'cos',
            'is_admin' => 0,
            'email' => 'cos@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ])->assignRole($cosRole);

        User::create([
            'name' => 'hsd',
            'is_admin' => 1,
            'email' => 'hsd@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ])->assignRole($hsdRole);

        User::create([
            'name' => 'engineer',
            'is_admin' => 0,
            'email' => 'engineerr@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ])->assignRole($engineerRole);

        for ($i=1; $i < 10; $i++) {
            User::create([
                'name' => 'Test '.$i,
                'is_admin' => 0,
                'email' => 'test'.$i.'@test.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // password
                'remember_token' => Str::random(10),
            ])->assignRole($userRole);
        }
    }
}
