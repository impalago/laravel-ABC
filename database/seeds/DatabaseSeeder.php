<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(PermissionRoleSeeder::class);
        $this->call(RoleUserSeeder::class);

        Model::reguard();
    }
}

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Owner',
                'email' => 'owner@owner.com',
                'isActive' => 1,
                'password' => bcrypt('owner'),
            ],
            [
                'name' => 'Demo user',
                'email' => 'demo@demo.com',
                'isActive' => 1,
                'password' => bcrypt('demo'),
            ]
        ]);
    }
}

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'permission_title' => 'Edit settings',
                'permission_slug' => 'edit_settings',
                'permission_description' => 'The ability to edit settings',
            ],
            [
                'permission_title' => 'Edit users',
                'permission_slug' => 'edit_users',
                'permission_description' => 'The ability to edit the list of users',
            ],
            [
                'permission_title' => 'Facebook',
                'permission_slug' => 'module_facebook',
                'permission_description' => 'Access to Facebook',
            ],
            [
                'permission_title' => 'Google Analytics',
                'permission_slug' => 'module_google_analytics',
                'permission_description' => 'Access to Google Analytics',
            ],
            [
                'permission_title' => 'YouTube',
                'permission_slug' => 'module_youtube',
                'permission_description' => 'Access to YouTube',
            ]
        ]);
    }
}

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'role_title' => 'Owner',
                'role_slug' => 'owner'
            ],
            [
                'role_title' => 'Demo user',
                'role_slug' => 'demo_user'
            ]
        ]);
    }
}

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_role')->insert([
            [
                'permission_id' => '1',
                'role_id' => '1'
            ],
            [
                'permission_id' => '2',
                'role_id' => '1'
            ],
            [
                'permission_id' => '3',
                'role_id' => '1'
            ],
            [
                'permission_id' => '4',
                'role_id' => '1'
            ],
            [
                'permission_id' => '5',
                'role_id' => '1'
            ],

            [
                'permission_id' => '3',
                'role_id' => '2'
            ],
            [
                'permission_id' => '4',
                'role_id' => '2'
            ],
            [
                'permission_id' => '5',
                'role_id' => '2'
            ],
        ]);
    }
}

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->insert([
            [
                'role_id' => '1',
                'user_id' => '1'
            ],
            [
                'role_id' => '2',
                'user_id' => '2'
            ],
        ]);
    }
}
